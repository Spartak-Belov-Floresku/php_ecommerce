<?php

class Login{
	
	public static $_login_page_front = "?page=login",
				  $_dashboard_front = "?page=orders",
				  $_login_front = "cid",
				  $_recoverpassword = null,
				  $_recoverpasswordnewpage = "?page=newpassword";

				  

	public static $_login_page_admin = ".",
				  $_dashboard_admin = "?page=products",
				  $_login_admin = "aid";

				  

	public static $_valid_login = "valid",
				  $_referrer = "refer";

	

	

	public static function isLogged($case = null){
		if(isset($_SESSION[$case])){
			if(!empty($case)){
				if(isset($_SESSION[self::$_valid_login]) && $_SESSION[self::$_valid_login] == 1){
					$hash = $_SESSION[$case];
						$table = $case == "cid"? "clients":"admins";
							$db = Dbase::getInstance();
						$user = $db->action("SELECT hash, recoverpass",$table,array("hash","=",$hash));
						self::$_recoverpassword = $user->count_() == 1? $user->first()->recoverpass : "";
					return $user->count_() == 1;
				}
				return false;
			}
		}
		return false;
	}

	

	public static function loginFront($trackinghash, $url = null){
		if(!empty($trackinghash)){
			$url = !empty($url) ? $url : self::$_dashboard_front;
			$_SESSION[self::$_login_front] = $trackinghash;
			$_SESSION[self::$_valid_login] = 1;
			Helper::redirect($url);
		}
	}

	public static function loginAdmin($hash = null, $url = null){
			if(!empty($hash)){
					$url = !empty($url)? $url : self::$_dashboard_admin;
					$_SESSION[self::$_login_admin] = $hash;
					$_SESSION[self::$_valid_login] = 1;
					Helper::redirect($url);
			}
	}

	public static function restrictFront(){
		if(!self::isLogged(self::$_login_front)){
				$url = Url::cPage() != "logout" ?
							self::$_login_page_front."&".self::$_referrer."=".Url::cPage():
							self::$_login_page_front;
				Helper::redirect($url);
		}
		self::pageUpgradePassword();
	}
	
	private static function pageUpgradePassword(){
		if(self::$_recoverpassword != 1 && Url::cPage() != "newpassword"){
			Helper::redirect(self::$_recoverpasswordnewpage);
		}
		if(Url::cPage() == "newpassword" && self::$_recoverpassword == 1){
			$url = Url::cPage() != "logout" ?
							self::$_login_page_front."&".self::$_referrer."=".Url::cPage():
							self::$_login_page_front;
			Helper::redirect($url);
		}
	}

	public static function restrictAdmin(){
		if(!self::isLogged(self::$_login_admin)){
			Helper::redirect(self::$_login_page_admin);
		}
	}

	

	public static function string2hash($string = null){
		if(!empty($string)){
			return hash('sha512',$string);
		}
	}

	

	public static function getFullNameFront($trackinhash = null){
		if(!empty($trackinhash)){
			$objUser = new User();
			$user = $objUser->getUser($trackinhash);
			if(!empty($user)){
				return $user->first_name ." ".$user->last_name;
			}else{
				$objAdmin = new Admin();
				$admin = $objAdmin->getUser($trackinhash);
				if(!empty($admin)){
					return $admin->first_name ." ".$admin->last_name;
				}
			}
		}
	}

	public static function logout($case = null){
		if(!empty($case)){
			$_SESSION[$case] = null;
			$_SESSION[self::$_valid_login] = null;
			unset($_SESSION[$case]);
			unset($_SESSION[self::$_valid_login]);
		}else{
			session_destroy();
		}
	}

}

?>