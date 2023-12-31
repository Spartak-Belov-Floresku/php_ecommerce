<?php
require_once('../inc/autoload.php');

//token
$token2 = Session::getSession('token2');
$objForm = new Form();
$token1 = $objForm->getPost('token');
if($token2 == Login::string2hash($token1)){
	
	// create order
	$objOrder = new Order();
	if($objOrder->createOrder()){ // <- upload to database
		$order = $objOrder->getOrder();
		$items = $objOrder->getOrderItems();
		
		if(!empty($order) && !empty($items)){
			
			$objBasket = new Basket();
			$objCatalogue = new Catalogue();
			$objPayPal = new PayPal();
			
				foreach ($items as $item){
					$product = $objCatalogue->getProduct($item->product);
					$objPayPal->addProduct($item->product , $product->name , $item->price , $item->qty);
				}
				
				$objPayPal->_tax_cart = $objBasket->_vat;
				
				// populate client's details
				$objUser = new User();
				$user = $objUser->getUser($order->client,"id");
				
				if(!empty($user)){
					
					// get user country record
					
					//$objCountry = new Country();
					//$country = $objCountry->getCountry($user->country);
					
					$objStates = new States();
					$state = $objStates->getState($user->state);
					
					// pass client's details to the PayPal instance
					$objPayPal->_populate = array(
						'address1'   => $user->address_1,
						'address2'   => $user->address_2,
						'city'	     => $user->city,
						'state'	     => $state->state_abbr,
						'zip'        => $user->zip_code,
						'country'    => 'US',
						'email'    	 => $user->email,
						'first_name' => $user->first_name,
						'last_name'  => $user->last_name
					);
					
					
					// redirect client to PayPal
					echo $objPayPal->run($order->id);
				}
		}
	}
	
	
}

?>