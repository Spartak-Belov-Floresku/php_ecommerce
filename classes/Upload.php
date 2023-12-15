<?php
class Upload{
	
	public $_file = array();
	public $_overwrite = false;
	public $_errors = array();
	public $_names = array();
	
	public function __construct(){
		
		$this->getUploads();
		
	}
	
	public function getUploads(){
		
		if(!empty($_FILES)){
			
			foreach($_FILES as $key => $value){
				
				$this->_file[$key] = $value;
				
			}
		}
		
	}
	
	public function upload($path = null, $nm = null){
		
		if(!empty($path) && is_dir($path) && !empty($this->_file)){
			
			foreach($this->_file as $key => $value){
				
				$name = "";

				if($nm !== null){
					$name = strtolower(trim(str_replace(' ','_',preg_replace("/[^a-zA-Z]+/", " ",$nm))).'.'.trim(substr($value['name'],-3)));
				}else{ 
					$name = Helper::cleanString($value['name']);
				}
				
				if($this->_overwrite == false && is_file($path.DS.$name)){
					$prefix = date('YmdHis', time());
					$end = 	trim(substr($name,-3));
					$name = trim(substr_replace($name,"",-4));
					$name = $name."_".$prefix.".".$end;
				}
				
				if(!move_uploaded_file($value['tmp_name'], $path.DS.$name)){
					$this->_errors[] = $key;
				}
				
				$this->_names[] = $name;
				
			}
			
			return count($this->_errors) == 0? true : false ;
		}
		
		return false;
	}
	
}
?>