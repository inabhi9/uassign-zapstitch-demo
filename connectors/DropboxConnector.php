<?php

include __DIR__.'/../extensions/dropbox-php-sdk-1.1.3/lib/Dropbox/autoload.php';
include __DIR__.'/BaseConnector.php';

use \Dropbox as dbx;

class DropboxException extends Exception{}

class DropboxConnector extends BaseConnector {
	
	private $appKey;
	private $appSecret;
	private $redirectUri;
	private $clientIdentifier;
	
	const SESSION_KEY_NAME = 'dropboxToken';
	
	function __construct($apiKey, $apiSecret, $redirectUri, $clientIdentifier) {
		
		$this->appKey = $apiKey;
		$this->appSecret = $apiSecret;
		$this->redirectUri = $redirectUri;
		$this->clientIdentifier = $clientIdentifier;
	}
	
	public function connect(){
		$authorizeUrl = $this->getWebAuth($this->redirectUri)->start();
		header("Location: $authorizeUrl");
		
	}
	
	private function getWebAuth($redirectUri){
		$conf = array("key"=>$this->appKey, 'secret'=>$this->appSecret);
		$appInfo = dbx\AppInfo::loadFromJson($conf);
		$clientIdentifier = $this->clientIdentifier;
		$csrfTokenStore = new dbx\ArrayEntryStore($_SESSION, 'dropbox-auth-csrf-token');
		return new dbx\WebAuth($appInfo, $clientIdentifier, $redirectUri, $csrfTokenStore);
	}
	
	public function connectFinish(){
		
		try {
			list($accessToken, $userId, $urlState) = 
				$this->getWebAuth($this->redirectUri)->finish($_GET);
			
			// Since we didn't pass anything in start()
			assert($urlState === null);  
			$_SESSION[self::SESSION_KEY_NAME] = array('accessToken'=>$accessToken,
					'userId'=>$userId);
			return $_SESSION[self::SESSION_KEY_NAME];
		}
		catch (dbx\WebAuthException_BadRequest $ex) {
			throw new DropboxException("/dropbox-auth-finish: bad request: " . $ex->getMessage());
			// Respond with an HTTP 400 and display error page...
		}
		catch (dbx\WebAuthException_BadState $ex) {
			// Auth session expired.  Restart the auth process.
			$rU = $this->redirectUri;
			header("Location: $rU");
		}
		catch (dbx\WebAuthException_Csrf $ex) {
			throw new DropboxException("CSRF mismatch: ".$ex->getMessage());
			// Respond with HTTP 403 and display error page...
		}
		catch (dbx\WebAuthException_NotApproved $ex) {
			throw new DropboxException("not approved: ".$ex->getMessage());
		}
		catch (dbx\WebAuthException_Provider $ex) {
			throw new DropboxException("error redirect from Dropbox: ".$ex->getMessage());
		}
		catch (dbx\Exception $ex) {
			throw new DropboxException("error communicating with Dropbox API: ".$ex->getMessage());
		}
		
		return null;
		
	}
	
	public function listFolders($path){
		$folderMetadata = $dbxClient->getMetadataWithChildren($path);
		print_r($folderMetadata);
	}
	
	public function downloadFile($ddSource, $destination){
		$f = fopen("working-draft.txt", "w+b");
		$fileMetadata = $dbxClient->getFile("/working-draft.txt", $f);
		fclose($f);
		print_r($fileMetadata);
	}
	
	
}