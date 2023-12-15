<?php
	require_once('../inc/autoload.php');
	
	if(Input::exists('get') == false){
			$out = array();
				
				$trackingQuickSearch = Login::string2hash(microtime(true));
				
				$registeredForm = Login::string2hash($trackingQuickSearch);
					Input::putSession("registeredForm", $registeredForm);
				$out['registeredForm'] = $registeredForm;
				
				$truckLogin = Login::string2hash($registeredForm);
					Input::putSession("truckLogin", $truckLogin);
				$out['mobLogin'] = $truckLogin;
				$out['loginForm'] = $truckLogin;
				
				$truckRecoverPas = Login::string2hash($truckLogin);
					Input::putSession("recoverForm", $truckRecoverPas );
				$out['recoverForm'] = $truckRecoverPas;
				
				$checkoutForm = Login::string2hash($truckRecoverPas);
					Input::putSession("checkoutForm", $checkoutForm );
				$out['checkoutForm'] = $checkoutForm;
				
				$formcreditcards = Login::string2hash($checkoutForm);
					Input::putSession("formcreditcards", $formcreditcards );
				$out['formcreditcards'] = $formcreditcards;
				
				$changePasswordForm = Login::string2hash($formcreditcards);
					Input::putSession("changePasswordForm", $changePasswordForm );
				$out['changePasswordForm'] = $changePasswordForm;
				
				$permanetcards = Login::string2hash($changePasswordForm);
					Input::putSession("permanetcards", $permanetcards );
				$out['permanetcards'] = $permanetcards;
				
				$trackbuisnessform = Login::string2hash($changePasswordForm);
					Input::putSession("trackbuisnessform", $trackbuisnessform );
				$out['trackbuisnessform'] = $trackbuisnessform;
				
		echo json_encode($out);
	}

?>