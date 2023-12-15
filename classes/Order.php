<?php

final class Order extends Application{
		private $_table = 'orders',
				$_table_2 = 'orders_items',
				$_table_3 = 'statuses',

				$_basket = array(),
				$_items  = array(),
				$_fields = array(),
				$_values = array(),

				$_id = null;

				

		public function getItems(){
			$this->_basket = Session::getSession('basket');
			if(!empty($this->_basket)){
				$objCatalogue = new Catalogue();
				foreach($this->_basket as $key => $value){
					$this->_items[$key] = $objCatalogue->getProduct($key);
				}
			}
		}



		

		public function createOrder(){
			$this->getItems();
			if(!empty($this->_items)){
				$objUser = new User();
				$user = $objUser->getUser(Session::getSession(Login::$_login_front));

				if(!empty($user)){
					$objBasket = new Basket();
					
					//$this->_fields[] = 'client';
					$this->_values['client'] = IntegerFilter::filter($user->id);

					//$this->_fields[] = 'vat_rate';
					$this->_values['vat_rate'] = $this->db->escape($objBasket->_vat_rate);

					//$this->_fields[] = 'vat';
					$this->_values['vat'] = $this->db->escape($objBasket->_vat);

					//$this->_fields[] = 'subtotal';
					$this->_values['subtotal'] = $this->db->escape($objBasket->_sub_total);

					//$this->_fields[] = 'total';
					$this->_values['total'] = $this->db->escape($objBasket->_total);

					//$this->_fields[] = 'date';
					$this->_values['date'] = Helper::setDate();

					$this->db->prepareInsert($this->_values);
					$this->db->insert($this->_table);

					$this->_id = $this->db->lastId();

					if(!empty($this->_id)){
						$this->_fields = array();
						$this->_values = array();
						return $this->addItems($this->_id);
					}
				}

				return false;

			}

			return false;

		}

		

		private function addItems($order_id = null){

			if(!empty($order_id)){

				$error = array();
				$array_value = array();

				foreach($this->_items as $item){
					$array_value['order'] 	 = $order_id; 
					$array_value['product'] = $item->id;
					$array_value['price']	 = $item->price;
					$array_value['qty']		 = $this->_basket[$item->id]['qty'];

					$this->db->prepareInsert($array_value);
					$this->db->insert($this->_table_2);

					if($this->db->_error){
						$error = $this->db->_error;
					}

					$array_value = array();

				}
				return empty($error)? true : false;
				
			}
			return false;
		}

		

		

		public function getOrder($id = null){

			$id = IntegerFilter::filter(!empty($id)? $id: $this->_id);
			$sql = "SELECT * FROM `{$this->_table}` WHERE `id` = ?" ;
				return  $this->db->query($sql, array($id))->first();
		}

		public function getOrderItems($id = null){
			
			$id = IntegerFilter::filter(!empty($id)? $id: $this->_id);
			$sql = "SELECT * FROM `{$this->_table_2}` WHERE `order` = ?" ;
				return  $this->db->query($sql, array($id))->results();
		}

		

		public function approve($array = array(),$result = 0){	
			if(!empty($array) && !empty($result)){
				if(array_key_exists('txn_id', $array) &&
				   array_key_exists('custom', $array) &&
				   array_key_exists('payment_status', $array)
				   ){
					   $active = $array['payment_status'] == 'Completed' ? 1 : 0;
					   $out = array();
					   $ipnArray = array();
					   foreach($array as $key => $value){
							$out[] ="{$key} : {$value}";   
					   }
					   	$out = implode("\r\n", $out);
						$ipnArray['pp_status'] = $this->db->escape($active);
						$ipnArray['txn_id'] = $this->db->escape($array['txn_id']);
						$ipnArray['payment_status'] = $this->db->escape($array['payment_status']);
						$ipnArray['ipn'] = $this->db->escape($out);
						$ipnArray['response'] = $this->db->escape($result);
						$this->db->prepareInsert($ipnArray);
						$this->db->update($this->_table, $this->db->escape($array['custom']));
				   }

			}

		}
		
		
		public function getClinetOrders($clientHashCode = null, $by = null){
			if(!empty($clientHashCode) && $by == null){
				$user = $this->db->action("SELECT id","clients", array("hash","=", $clientHashCode));
				$id = IntegerFilter::filter($user->first()->id);
				$sql = "SELECT * FROM `{$this->_table}` WHERE `client` = ? ORDER BY `date` DESC";
				return  $this->db->query($sql, array($id))->results();	
			}else if(!empty($clientHashCode) && $by == "id"){
				$id = IntegerFilter::filter($clientHashCode);
				$sql = "SELECT * FROM `{$this->_table}` WHERE `client` = ? ORDER BY `date` DESC";
				return  $this->db->query($sql, array($id))->results();
			}
		}
		
		public function getStatus($id = null){
			if(!empty($id)){
				$id = IntegerFilter::filter($id);
				$sql = "SELECT * FROM `{$this->_table_3}` WHERE `id` = ?";
				return  $this->db->query($sql, array($id))->first();
			}
		}
		
		public function getOrders($srch = null){
			$sql  = "SELECT * FROM `{$this->_table}`";
			$sql .= !empty($srch)? "WHERE `id` = ?" : null ;
			$sql .="ORDER BY `date` DESC";
			
			if(!empty($srch)){
				return $this->db->query($sql, array(IntegerFilter::filter($srch)))->first();
			}else{
				return $this->db->query($sql)->results();
			}
		}
		
		public function getStatuses(){
			$sql  = "SELECT * FROM `{$this->_table_3}` ORDER BY `id` ASC";
			return $this->db->query($sql)->results();
		}
		
		public function updateOrder($id, $array = null){
			if(!empty($id) && !empty($array) && is_array($array) && array_key_exists('status',$array) && array_key_exists('notes', $array)){
				$this->db->prepareInsert($array);
				return $this->db->update($this->_table, IntegerFilter::filter($id));
			}else if(!empty($id) && !empty($array) && is_array($array) && array_key_exists('pp_status',$array)){
				$this->db->prepareInsert($array);
				return $this->db->update($this->_table, IntegerFilter::filter($id));
			}
			
		}
		
		public function removeOrder($id = null){
			if(!empty($id)){
				return $this->db->delete($this->_table, array('id','=',IntegerFilter::filter($id)));
			}
		}

}



?>