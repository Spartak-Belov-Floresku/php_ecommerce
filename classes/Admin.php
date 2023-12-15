<?php
class Admin extends Application{
	
	private $_table = 'admins';
	public $_hash;
	
	
	public function isUser($email = null, $password = null){
		if(!empty($email) && !empty($password)){
			$password = Login::string2hash($password);
			$sql = "SELECT * FROM `{$this->_table}`
					WHERE `email` = ?
					AND `password` = ? ";
			$result = $this->db->query($sql, array($email, $password))->first();
			if(!empty($result)){
					$hash = Login::string2hash(microtime(true) + $this->db->first()->id);
						$this->db->prepareInsert(array("hash" => $hash));
							$this->db->update($this->_table, $this->db->first()->id);
					$this->_hash = $hash;
				return true;
			}
			return false;
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
}
?>