<?php
class States extends Application{
	
	public function getStates(){
		$sql = "SELECT * FROM `state` ORDER BY `state_id` ASC";
		return $this->db->query($sql)->results();
	}
	
	public function getState($id = null){
		if(!empty($id)){
			$sql ="SELECT* FROM `state` WHERE `state_id` = ?";
			if(!$this->db->query($sql, array($id))->_error){
				return  $this->db->first();
			}else{
				return null;
			}
		}
	}
}
?>