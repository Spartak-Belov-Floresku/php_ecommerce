<?php

	$code = Url::getParam('code');
	
	if(!empty($code)){
		
		$objUser = new User();
		$user = $objUser->getUserByHash($code);
		
		if(!empty($user)){
			
			if($user->active == 0){
				
				if($objUser->makeActive($user->id)){
					
					$mess  = "<h1 class='titlH1'>Thank you</h1>";
					$mess .= "<p style='font-size:16px;line-height:20px;font-family: 'Helvetica Neue', Verdana, Arial, sans-serif;font-weight:300;'>Your account has now been successfully activated.<br><br>";
					$mess .= "You can now log in and continue with your order.</p>";
					
				}else{
					
					$mess  = "<h1 class='titlH1'>Activation unsuccessful</h1>";
					$mess .= "<p style='font-size:16px;line-height:20px;font-family: 'Helvetica Neue', Verdana, Arial, sans-serif;font-weight:300;'>There has been a problem activating your account.<br>";
					$mess .= "<span style='color:#900;font-weight:900;'>Please contact administrator.</span></p>";
				}
				
			}else{
			
				$mess  = "<h1 class='titlH1'>Account already activated</h1>";
				$mess .= "<p style='font-size:16px;line-height:20px;font-family: 'Helvetica Neue', Verdana, Arial, sans-serif;font-weight:300;'>This account has already been activated</p>";
			
			}
		}else{
		
			Helper::redirect("?page=error");
		
		}
		require_once("header.php");
		echo $mess;
		require_once("footer.php");
	}else{
		
		Helper::redirect("?page=error");
		
	}

?>