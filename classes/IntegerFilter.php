<?php
class IntegerFilter{
	public static function filter($var){
		$var = preg_replace('/[^0-9]/','',$var);
			$var = $var != ''?$var:null;
		return $var;
	}

}
?>