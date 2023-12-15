<?php
class Basket{
	
	public $_inst_catalogue,
		   $_empty_basket,
		   $_vat_rate,
		   $_number_of_items,
		   $_sub_total,
		   $_vat,
		   $_total;
		   
	
	public function __construct(){
			$this->_inst_catalogue = new Catalogue();
			$this->_empty_basket = empty($_SESSION['basket'])? true: false;
			
			$objBusiness = new Business();
			$this->_vat_rate = $objBusiness->getVatRate();
			
			$this->noItems();
			$this->subtotal();
			$this->vat();
			$this->total();
	}
	
	public function noItems(){
		$val = 0;
		if(!$this->_empty_basket){
			foreach($_SESSION['basket'] as $key => $basket){
				$val +=$basket['qty'];
			}
		}
		$this->_number_of_items = $val;
	}
	
	
	public function subtotal(){
		$val = 0;
		if(!$this->_empty_basket){
			foreach($_SESSION['basket'] as $key => $basket){
				$product = $this->_inst_catalogue->getProduct($key);
				$val += ($basket['qty'] * $product->price);
			}
		}
		$this->_sub_total = round($val,2);
	}
	
	
	public function vat(){
		$val = 0;
		if(!$this->_empty_basket){
			$val =($this->_vat_rate * ($this->_sub_total/100));
		}
		$this->_vat = round($val,2);
	}
	
	
	public function total(){
		$this->_total = round(($this->_sub_total + $this->_vat), 2);
	}
	
	
	
	public static function activeButton($sess_id){
		if(isset($_SESSION['basket'][$sess_id])){
			$id = 0;
			$label = "Remove from basket";
		}else{
			$id = 1;
			$label = "Add to basket";
		}
		
		$out = "<a href=\"#\" class=\"add_to_basket";
		$out.= $id == 0 ? " red": null;
		$out.= "\" rel=\"";
		$out.=$sess_id."_".$id;
		$out.="\" onClick=\"return false;\">{$label}</a>";
		return $out;
	}
	
	public function itemTotal($price = null , $qty = null){
		if(!empty($price) && !empty($qty)){
			return round(($price * $qty), 2);
		}
	}
	
	public static function removeButton($id = null){
		if(!empty($id)){
			if(isset($_SESSION['basket'][$id])){
				$out = "<a href=\"#\" class=\"remove_basket red_e";
				$out .= "\" rel=\"{$id}\">Remove</a>";
				return $out;
			}
		}
	}
}
?>