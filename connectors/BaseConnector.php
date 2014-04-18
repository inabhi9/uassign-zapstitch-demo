<?php 

abstract class BaseConnector{
	
	abstract public function connect();
	
	abstract public function connectFinish();
	
	public static function disconnect(){
		unset($_SESSION[static::SESSION_KEY_NAME]);
	}
	
	public static function isConnected(){
		return isset($_SESSION[static::SESSION_KEY_NAME]);
	}
}

?>