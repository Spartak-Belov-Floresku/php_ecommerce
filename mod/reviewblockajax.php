<?php
header("Content-Type:application/json");
require_once('../inc/autoload.php');

if(Input::exists('post')){
	$id  = IntegerFilter::filter(Input::get('id'));

	$objCatalogue = new Catalogue();
	$product = $objCatalogue->getProduct($id);

	if($product != null){
		echo json_encode($product);
	}
}
?>