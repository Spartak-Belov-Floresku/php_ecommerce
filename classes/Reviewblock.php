<?php
	class Reviewblock{
		
		public static function addProduct($value = null,$newproduct = null,$numbers = null){
			$array = explode(",",$value);
				if(count($array) >= $numbers){
					if(!in_array($newproduct,$array)){
						array_push($array,$newproduct);
							array_shift($array);
						$value = implode(',',$array);
					}
				}else{
					if(!in_array($newproduct,$array)){
						array_push($array,$newproduct);
						$value = implode(',',$array);
					}
				}
				
			return $value;	
		}
		
		public static function displayProducts(){
			
			$divproduct = "";
			
			$objCatalogue = new Catalogue();
			
			$products = explode(",",Cookies::getCookie("reviewblock"));
			
			foreach($products as $product){
				
				$p = $objCatalogue->getProduct($product);
				
					if(!empty($p)){
						
						$images = !empty($p->image)?Helper::getImages($p->image):array();
						$images = Helper::filterIfImageExists($images, CATALOGUE_PATH.DS,$p->id);
						
						$image = count($images) != 0?$images[0]:"unavailable.png";
							
						
							$divproduct .= "<a href=\"?page=catalogue-item&amp;category=". $p->category ."&amp;id=". $p->id ."\" data-product-id=\"".$p->id."\">";
								$divproduct .= "<img class=\"trackImg\" src=\"media/catalogue/{$image}\" alt=\"";
								$divproduct .= Helper::encodeHTML($p->name, 1);
							$divproduct .= "\"/>";
						$divproduct .= "<p><strong>&dollar;".$p->price."</strong></p></a>";
					}
			}
			
			echo $divproduct;
		}
		
	}
?>