<?php
class Cookies{

		public static function setCookie($name = null, $value = null){
			$expire = time() + (60*60*24*365);
				$path = '/';
					setcookie($name,$value,$expire,$path);
		}
		
		public static function getCookie($name = null){
			return isset($_COOKIE[$name])?$_COOKIE[$name]:null;
		}
		
		public static function deleteCookie($name = null){
			$expire = strtotime('-1 year');
					setcookie($name,"",$expire,"/");
		}
		
}
?>