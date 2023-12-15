<?php
header("Content-Type:application/json");
require_once('../inc/autoload.php');

if(Input::exists('post')){
	$out =  array();
	$id  = IntegerFilter::filter(Input::get('id'));
	$job = IntegerFilter::filter(Input::get('job'));

	$objCatalogue = new Catalogue();
	$product = $objCatalogue->getProduct($id);

	if($product != null){
		switch($job){
			case 0:
			Session::removeItem($id);
			$out['job']=1;
			break;
			case 1:
			Session::setItem($id);
			$out['job']=0;
			break;
		}
		echo json_encode($out);
	}
}
?>