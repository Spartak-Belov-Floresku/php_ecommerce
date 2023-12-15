<?php
	header("Content-Type:application/json");
	require_once('../inc/autoload.php');
	
	if(Input::exists('post') && 
		Input::get("trackbuisnessform") == Session::getSession("trackbuisnessform") && 
			Session::getSession("trackbuisnessform")){
				
		$body = array();	
		$body['cusEmail'] = Input::get('cusEmail');
		$body['cusName'] = Input::get('cusName');
		$body['cusSubject'] = Input::get('cusSubject');
		$body['cusMessage'] = Input::get('cusMessage');
		
		$objEmail = new Email();
		if($objEmail->process(4, $body)){
			echo "SH Thank you ". $body['cusName'] ." for request. We will send response shortly.";
		}else{
			echo "SH Your email has not be sent. Try again please.";
		}
		
	}
?>