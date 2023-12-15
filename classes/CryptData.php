<?php
class CryptData{
	private $_key, $_ivs, $_iv, $_cipher, $_mode;
	
	public function __construct(){
		
		$this->_cipher = MCRYPT_RIJNDAEL_256;
		$this->_mode = MCRYPT_MODE_CBC;
		$this->_key = sha1('lockkard',true);
		$this->_ivs = mcrypt_get_iv_size($this->_cipher, $this->_mode);
		$this->_iv = mcrypt_create_iv($this->_ivs);
		
		if(strlen($this->_key) < 24){
			$len = strlen($this->_key);
			$len2 = $len + (24-$len);
			for($i = $len; $i < $len2; $i++){
				$this->_key .="\0";
			}
		}
		
	}
	
	public function encrypt($data){
		
		$data1 = array();
		$data = mcrypt_encrypt($this->_cipher, $this->_key, $data, $this->_mode, $this->_iv);
		$data1[] = base64_encode($data);
		$data1[] = base64_encode($this->_iv);
		return $data1;
		
	}
	
	public function decrypt($cc, $iv){
		
		$cc = base64_decode($cc);
		$iv = base64_decode($iv);
		$data = mcrypt_decrypt($this->_cipher, $this->_key, $cc, $this->_mode, $iv);
		return $data;
		
	}
}
?>
