<?php

final class User extends Application{

	private $_table = "clients";

	public $_id, $_trackingcode;
	

	public function isUser($email = null, $password = null){
		$password = Login::string2hash($password);
		$sql ="SELECT * FROM `{$this->_table}`
		WHERE `email` = ?
		AND `password` = ?
		AND `active` = 1";
		if($this->db->query($sql, array($email, $password))->first() != null){
			$this->_id = $this->db->first()->id;
				$hash = Login::string2hash(microtime(true) + $this->db->first()->id);
					$this->db->prepareInsert(array("hash" => $hash));
						$this->db->update($this->_table, $this->db->first()->id);
				$this->_hash = $hash;
			return true;
		}
		return false;
	}

	public function addUser($params = null, $password = null){
		if(!empty($params) && !empty($password)){
			$this->db->prepareInsert($params);
			if($this->db->insert($this->_table)){
				//send email
				$objEmail = new Email();
				if($objEmail->process(1, array(
					'email' 		=> $params['email'],
					'first_name' 	=> $params['first_name'],
					'last_name' 	=> $params['last_name'],
					'password' 		=> $password,
					'hash'			=> $params['hash']
				))){
					return true;
				}else{
					return false;
				}
				return true;
			}
			return false;
		}
		return false;
	}
	
	
	public function getUserByHash($hash = null){
		if(!empty($hash)){
			$sql = "SELECT * FROM `{$this->_table}` WHERE `hash` = ?" ;
				return  $this->db->query($sql, array($hash))->first();
		}
	}
	
	public function makeActive($id = null){
		if(!empty($id)){
			$sql = "UPDATE `{$this->_table}` SET `active` = 1 WHERE `id` = ?";
			return !$this->db->query($sql,array($id))->_error;
		}
	}
	
	public function getByEmail($email = null){
		if(!empty($email)){
			$sql = "SELECT * FROM `{$this->_table}` WHERE `email` = ? AND `active` = 1";
				return  $this->db->query($sql, array($email))->first();
		}
	}
	
	public function getUser($trackinhash = null, $by = null){
		if(!empty($trackinhash)){
			if($by == null){
				return $this->db->action("SELECT *",$this->_table,array("hash","=",$trackinhash))->first();
			}else if($by == "id"){
				return $this->db->action("SELECT *",$this->_table,array("id","=",$trackinhash))->first();
			}
		}
	}
	
	public function updateUser($array = null, $id = null){
		if(!empty($array) && !empty($id)){
			$this->db->prepareInsert($array);
			if($this->db->update($this->_table, $id)){
				return true;
			}
			return false;
		}
	}
	
	public function getUsers($srch = null) {
		$srch1 = null;
		$sql = "SELECT * FROM`{$this->_table}` WHERE `active` = 1";
		if(!empty($srch)){
			$srch = $this->db->escape($srch);
			$srch1 = '%'.$srch.'%';
			$sql .= " AND (`first_name` LIKE ? || `last_name` LIKE ?)";
		}
		$sql .= " ORDER BY `last_name`, `first_name` ASC";
		if(!$this->db->query($sql, array($srch1,$srch1))->_error){

				return  $this->db->results();

			}else{

				die("Something wrong!");

			}
	
	}
	
	public function removeUser($id = null) {
		if (!empty($id)) {
			return $this->db->delete($this->_table, array('id','=',IntegerFilter::filter($id)))->count_();
		}
	}
	
	public function randomPassword() {
		$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
		$pass = array(); //remember to declare $pass as an array
		$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
		for ($i = 0; $i < 8; $i++) {
			$n = rand(0, $alphaLength);
			$pass[] = $alphabet[$n];
		}
		$passString["hash"] = Login::string2hash(implode($pass));
		$passString["password"] = implode($pass);
		return  $passString; //turn the array into a string
	}

}



?>