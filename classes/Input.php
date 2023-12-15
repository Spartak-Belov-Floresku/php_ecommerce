<?php
class Input{
	public static function exists($type = 'get'){
		switch($type){
			case 'post':
				return (!empty($_POST))?true:false;
			break;
			case 'get':
				return (!empty($_GET))?true:false;
			break;
			default:
				return false;
			break;
		}
	}
		
	public static function get($item){
		if(isset($_POST[$item])){
			return $_POST[$item];
		}else if(isset($_FILES[$item])){
			return $_FILES[$item];
		}else if(isset($_GET[$item])){
			return $_GET[$item];
		}
		return '';
	}
	
	public static function putSession($key, $value){
		$_SESSION[$key] = $value;
	}
	 public static function unSetSession($key){
		 unset($_SESSION[$key]);
	 }
}

?>