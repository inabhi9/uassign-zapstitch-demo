<?php

set_include_path(__DIR__.'/../extensions/google-api-php-client');
include_once __DIR__.'/../extensions/google-api-php-client/Google/Client.php';
include_once __DIR__.'/../extensions/google-api-php-client/Google/Http/MediaFileUpload.php';
include_once __DIR__.'/../extensions/google-api-php-client/Google/Service/Drive.php';
include_once __DIR__.'/BaseConnector.php';

class GdriveException extends Exception{}

class GdriveConnector extends BaseConnector {
	
	private $appKey; // Google client key
	private $appSecret; // Google client secret
	private $redirectUri; // Redirect uri
	private $_client; // Google client
	private $_gservice; // Google drive service
	
	const SESSION_KEY_NAME = "gdriveToken";
	
	function __construct($apiKey, $apiSecret, $redirectUri) {
	
		$this->appKey = $apiKey;
		$this->appSecret = $apiSecret;
		$this->redirectUri = $redirectUri;
		
		// init google client
		$this->_client = new Google_Client();
		$this->_client->setClientId($this->appKey);
		$this->_client->setClientSecret($this->appSecret);
		$this->_client->setRedirectUri($this->redirectUri);
		// we only intersted in user's drive 
		$this->_client->setScopes(array('https://www.googleapis.com/auth/drive'));				
		$this->_gservice = new Google_Service_Drive($this->_client);
		
		// trying to load token if any exists in session
		$this->loadToken();
	}
	
	public function connect(){
		$authorizeUrl = $this->_client->createAuthUrl();
		header("Location: $authorizeUrl");
	}
	
	public function connectFinish(){
		if (!isset($_GET['code'])) {
			throw new GdriveException('No code found');
		}
		try{
			$this->_client->authenticate($_GET['code']);
			$_SESSION[self::SESSION_KEY_NAME] = $this->_client->getAccessToken();
			return $_SESSION[self::SESSION_KEY_NAME];
		} catch (Google_Auth_Exception $ex){
			$rU = $this->redirectUri;
			header ("location: $rU");
		}
	}
	
	public function uploadFile($source, $destination="/"){
		$file = new Google_Service_Drive_DriveFile();
		$file->title = basename($source);
		$chunkSizeBytes = 1 * 1024 * 1024;
		
		// Call the API with the media upload, defer so it doesn't immediately return.
		$this->_client->setDefer(true);
		$request = $this->_gservice->files->insert($file);
		
		// Create a media file upload to represent our upload process.
		$media = new Google_Http_MediaFileUpload(
				$this->_client,
				$request,
				'*/*',
				null,
				true,
				$chunkSizeBytes
		);
		$media->setFileSize(filesize($source));
		
		// Upload the various chunks. $status will be false until the process is
		// complete.
		$status = false;
		$handle = fopen($source, "rb");
		while (!$status && !feof($handle)) {
			$chunk = fread($handle, $chunkSizeBytes);
			$status = $media->nextChunk($chunk);
		}
		
		// The final value of $status will be the data from the API for the object
		// that has been uploaded.
		$result = false;
		if ($status != false) {
			$result = $status;
		}
		
		fclose($handle);
	}
	
	public function createBlankFile($name, $description){
		$mimeType = 'text/plain';
		$file = new Google_Service_Drive_DriveFile();
		$file->setTitle($name);
		$file->setDescription($description);
		$file->setMimeType('text/plain');
		
		$createdFile = $this->_gservice->files->insert($file, array(
				'data' => null,
				'mimeType' => $mimeType,
		));
		return $createdFile->id;
	}
	
	private function loadToken(){
		if (GdriveConnector::isConnected() == True){
			$s = $_SESSION[self::SESSION_KEY_NAME];
			$this->_client->setAccessToken($s);			
		}
	}
}