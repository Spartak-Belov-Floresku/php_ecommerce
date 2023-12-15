<?php

final class Creditcard extends Application{
	
	public 	$_name =  '', 
			$_cardnumber = false, 
			$_csncode = false,$_month = 0, 
			$_year = 0, 
			$_date = 0, 
			$_error = array('cardname' => false, 'cardnumber' => false, 'csn' => false, 'date' => false),
			$_subError = array('cardname' => 'Card name is incorrect...', 'cardnumber' => 'Card number is incorrect...', 'csn' => 'CSN code is incorrect...', 'date' => 'Date is incorrect...');
	private $_names = array('visa','mastercard','americanexpress','discover'), 
			$_frontnames = array('Visa','Master Card','American Express','Discover'),
			$_patterns = array('visa' => '/^4[0-9]{12}(?:[0-9]{3})?$/', 
							   'mastercard' => '/^(?:5[1-5][0-9]{2}|222[1-9]|22[3-9][0-9]|2[3-6][0-9]{2}|27[01][0-9]|2720)[0-9]{12}$/',
							   'americanexpress' => '/^3[47][0-9]{13}$/',
							   'discover' => '/^6(?:011|5[0-9]{2})[0-9]{12}$/',
							   'csn' => '/^[0-9]{3}$/',
							   'empty' => '/false/'),
			$_table = 'usercards';
	
	
	private function getNumber($chekNum){
		
		$creditNum = str_split(strrev($chekNum));
		$totalSum = 0;
		$i = 1;
		foreach($creditNum as $digit){
			
			if($i%2 == 0){
				$creditLocal = 2 * (int)$digit;
				if($creditLocal < 10){
					$totalSum += $creditLocal;
				}else if($creditLocal == 10){
					$totalSum += 1;
				}else if($creditLocal != 0){
					$stringLocal = (string)$creditLocal;
					$stringLocal2 = str_split($stringLocal);
					$totalSum += ((int)$stringLocal2[0] + (int)$stringLocal2[1]);
				}
				$i++;
				continue;
			}
			
			$totalSum += (int)$digit;
			$i++;
		}
		return $totalSum%10 == 0? true:false;
	}
	
	
	
	public function checkCard($name = null,$cardnumber = null,$csncode = null,$month1 = null,$year1 = null){
		
		$this->_name = $name;
		$this->_cardnumber = $cardnumber;
		$this->_csncode = $csncode;
		$year2 = date('Y');
		$month2 = date('m');
		$month = (int) $month1;
		$year = (int) $year1;
		$this->_month = $month;
		$this->_year = $year;
		
		
		
		foreach($this->_names as $n){
			if($n == $name){
				$this->_name = $n;
				break;
			}
			$this->_name = 'empty';
		}
		if($this->_name == false || $this->_name == 'empty'){
			$this->_error['cardname'] = true;
			return false;
		}
		
		if(!preg_match($this->_patterns[$this->_name],$cardnumber)){
			$this->_error['cardnumber'] = true;
			return false;
		}
		if($this->_name == 'visa' && !(strlen($cardnumber) == 13 || strlen($cardnumber) == 16)){
			$this->_error['cardnumber'] = true;
			return false;
		}
		if($this->_name == 'americanexpress' && strlen($cardnumber) != 15){
			$this->_error['cardnumber'] = true;
			return false;
		}
		
		if($this->_name != 'visa' && $this->_name != 'americanexpress' && strlen($cardnumber) != 16){
			$this->_error['cardnumber'] = true;
			return false;
		}
			
		if(!$this->getNumber($cardnumber)){
			$this->_error['cardnumber'] = true;
			return false;
			
		}
		
		if(!preg_match($this->_patterns['csn'],$csncode)){
			$this->_error['csn'] = true;
			return false;
		}
		
		if(($year2 == $year1 && $month2 > $month1) || $year > $year2+10 || $year < $year2 || $month == 0 ){
			$this->_error['date'] = true;
			return false;
		}
		
		$this->_date =  $this->_month."/".$this->_year;
		return true;
	}
	
	public function returnError($ref){
		if($this->_error[$ref]){
			echo '<span class="warn">'.$this->_subError[$ref].'</span>';
		}
		
	}
	
	public function getCardNames(){
		
		$out = "<select name='card' id='cardname' class='sel'><option value=''>--</option>";
		$i = 0;
		foreach($this->_names as $n){
			$sel = null;
			if($n == $this->_name){
				$sel = "selected='true'";
			}
			$out .= "<option value='{$n}' {$sel}>{$this->_frontnames[$i]}</option>";
			$i++;
		}		
			
		$out .= "</select>";
		
		echo $out;
	}
	
	
	public function sendOrderToEmail($order){
		
		$objUser =  new User();
			$user = $objUser->getUser($order->client, 'id');
			 
			$objBusiness = new Business();
				$business = $objBusiness->getBusiness();			
			
				$date = $this->_month.' / '.$this->_year;	
			
			$objEmail = new Email();
				if($objEmail->process(3, array(
											'email' => $business->email,
											'orderId' => $order->id,
											'customerId' => $user->id,
											'customerFirstName' => $user->first_name,
											'customerLastName' => $user->last_name,
											'creditCardName' => $this->_name,
											'creditCatrdNumber' => $this->_cardnumber,
											'creditCSNcode' => $this->_csncode,
											'dateExpiration' => $date
										))){
					return true;								
				}
				
		return false;							
	}
	
	public function putCreditCardDataInDataBase($userId){

		$objUser = new User();
		$user = $objUser->getUserByHash(Session::getSession('cid'));
		
		$cards = $this->checkIfCardExists($user->id);
		
		if($cards){
			$crypt = new CryptData();
			$number = $crypt->encrypt($this->_cardnumber);
			$data = array(
							'userid' => $userId, 
							'cardnetwork' => $this->_name, 
							'cardnumber' => $number[0], 
							'somevalue' => $number[1], 
							'csncard' => $this->_csncode, 
							'expirationdate' => $this->_date
						);
			$this->db->prepareInsert($data);
			$this->db->insert($this->_table);
		}
		
	}
	
	private function checkIfCardExists($id){
		
		$userid = IntegerFilter::filter($id);
		
		$sql ="SELECT cardnumber, somevalue FROM `".$this->_table."` WHERE `userid` = ? ORDER BY `cardnetwork`";
		
		if($this->db->query($sql, array($userid))->count_() > 0){
			$cards = $this->db->results();
			$crypt = new CryptData();
			foreach($cards as $card){
				$numCard = $crypt->decrypt($card->cardnumber, $card->somevalue);
				if(trim($numCard) == trim($this->_cardnumber)){
					return false;
				}
			}
			return true;
		}else{
			return true;
		}
	
	}
	
	public function getCreditCards($userHash){
		
		$objUser = new User();
		$user = $objUser->getUserByHash($userHash);
		
		$sql ="SELECT* FROM `".$this->_table."` WHERE `userid` = ? ORDER BY `cardnetwork`";
		if($this->db->query($sql, array($user->id))->count_() > 0){
			return $this->getFormatedCC($this->db->results());
		}else{
			return null;
		}
	
	}
	
	
	private function getFormatedCC($data){
		
		$crypt = new CryptData();
		
		$cards = array();
		
		for($i = 0; $i < count($data); $i++){
			
			$curYear = date('Y');
			$curMonth = date('m');
			
			$cardDate = explode("/",$data[$i]->expirationdate);
			
			if(($cardDate[0] < $curMonth && $cardDate[1] == $curYear) || $cardDate[1] < $curYear){
				$this->removeCard($data[$i]->cardid);
				continue;
			}
		
			if($cardDate[0] < 10){
				$m = '0'.$cardDate[0];
				$cardDate[0] = $m;
			}
			
			$cards[$i][] = $data[$i]->cardid;
			$cards[$i][] = $data[$i]->cardnetwork;
			 	$cardnum = '';
				$vcc = $crypt->decrypt($data[$i]->cardnumber, $data[$i]->somevalue);
				$cc = substr(trim($vcc),-4);
			$cards[$i][] = $cc;
			$cards[$i][] = $cardDate[0].'/'.$cardDate[1];
			
		}
		
		return $cards;	
	}
	
	private function removeCard($id){
		$this->db->action("DELETE",$this->_table, array('cardid', '=', $id));
	}
	
	public function getGreditCardById($idCard, $client){
		
		$sql ="SELECT* FROM `".$this->_table."` WHERE `userid` = ? AND `cardid` = ? LIMIT 1";
		
		if($this->db->query($sql, array($client, $idCard))->count_() > 0){
			
			$card =  $this->db->first();
			
			$crypt = new CryptData();
			
			$this->_cardnumber = $crypt->decrypt($card->cardnumber, $card->somevalue);
			$this->_name = $card->cardnetwork;
			$this->_csncode = $card->csncard;
			$date = explode("/",$card->expirationdate);
			$this->_month = $date[0];
			$this->_year = 	$date[1];
			
			return true;
			
		}else{
			$this->_cardnumber = "<span style='font-size:14px;weight:900;color:red;'>Warning !!! User tries to change a code on the web page.</span>";
			return false;
			
		}
	}
}

?>