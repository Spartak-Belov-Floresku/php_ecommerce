<?php
 require_once('../inc/autoload.php');
 
 if(Input::exists('post')){
	
		$id  = IntegerFilter::filter(Input::get('id'));
		Session::removeItem($id);
	}
 
?>