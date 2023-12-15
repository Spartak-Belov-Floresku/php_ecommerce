<?php
class Country extends Application{
	
	public function getCountries(){
		$sql = "SELECT * FROM `countries` ORDER BY `name` ASC";
		return $this->db->query($sql)->results();
	}
	
	public function getCountry($id = null){
		if(!empty($id)){
			$sql ="SELECT* FROM `countries` WHERE `id` = ?";
			if(!$this->db->query($sql, array($id))->_error){
				return  $this->db->first();
			}else{
				return null;
			}
		}
	}
}
?>