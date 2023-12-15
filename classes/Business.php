<?php
final class Business extends Application{
	
	private $_table = 'business';
	
	public function getBusiness(){
		$sql ="SELECT* FROM `{$this->_table}` WHERE `id` = 1";
			if(!$this->db->query($sql)->_error){
				return  $this->db->first();
			}else{
				die("Something wrong!");
			}
	}
	
	public function getVatRate(){
		$business = $this->getBusiness();
		return $business->vat_rate;
	}
	 
	 
	 public function updateBusiness($vars = null) {
		if (!empty($vars)) {
			$this->db->prepareInsert($vars);
				if($this->db->update($this->_table, 1)){
					return true;
				}	
		}
	}
	
	public function addLogo($vars = null){
		if (!empty($vars)) {
			$this->db->prepareInsert($vars);
				if($this->db->update($this->_table, 1)){
					return true;
				}	
		}
	}
	
	public function removeLogo($path = null){
		if($path != null){
			if(is_file(MENU_PATH_IMAGE.DS.$path)){
				unlink(MENU_PATH_IMAGE.DS.$path);
			}
		}
	}
	 
	public function getLocation($address, $zoom = 8){
		$pattern = "/\\n+| +/";
		$addr = str_replace(",","",preg_replace($pattern,"+",$address)); 
		$href = "https://maps.google.com/maps?hl=en&q=".$addr;
		$href .= "&ie=UTF8&hq=&hnear=".$addr;
		$href .= "&t=m&z=".$zoom."&output=embed";
		echo $href;
	}
}
?>