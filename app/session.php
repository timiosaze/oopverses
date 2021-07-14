<?php 

class Session {

	private static $_sessionStarted = false;
	private static $user_key = 'user_id';
	private static $id_key = 'id';
	private $signed_in;

	public static function start(){
		if(self::$_sessionStarted == false){
			session_start();
			self::$_sessionStarted == true;
		}
	}
	//Setting the session
	public static function set($key, $value)
	{
		$_SESSION[$key] = $value;
	}
	//Getting the Session
	public static function get($key)
	{
		if(isset($_SESSION[$key])){
			return $_SESSION[$key];
		} else{
			return false;
		}
	}
	//Setting the user_id session
	public static function set_id($value)
	{
		$_SESSION[self::$id_key] = $value;
	}
	//Getting the user_id
	public static function get_id()
	{
		if(isset($_SESSION[self::$id_key])){
			return $_SESSION[self::$id_key];
		} else {
			return false;
		}
	}
	//Set the Session for the login
	public static function set_login($value)
	{
		$_SESSION[self::$user_key] = $value;
	}
	//Get the Session for the login
	public static function get_login()
	{
		if(isset($_SESSION[self::$user_key])){
			return $_SESSION[self::$user_key];
		} else {
			return false;
		}
	}
	//Check if User has login successfully 
	public static function check_user(){
		if(isset($_SESSION[$user_key])){
			return true;
		} else {
			return false;
		}
	}
	//Check if Session key exists
	public static function check($key){
		if(isset($_SESSION[$key])){
			return true;
		} else {
			return false;
		}
	}
	
	//Display all sessions
	public static function session_display(){
		echo "<pre>";
		print_r($_SESSION);
		echo "</pre>";
	}

	//Destroy all sessions saved
	public static function destroy()
	{
			self::$_sessionStarted == false;
			self::set_login("");
			session_destroy();
	}
}

