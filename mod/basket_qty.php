<?php
	require_once('../inc/autoload.php');
	
	if(Input::exists('post')){
		
		$out = array();
		
		$id  = IntegerFilter::filter(Input::get('id'));
		$val = IntegerFilter::filter(Input::get('qty'));
		$val = $val>1000?1000:$val;
		$objCatalogue = new Catalogue();
		$product = $objCatalogue->getProduct($id);
		
		if(!empty($product)){
			
			switch($val){
				case 0:
					Session::removeItem($id);
				break;
				default:
					Session::setItem($id, $val);
				break;
			}
		}
	}
	

?>