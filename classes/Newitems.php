<?php

final class Newitems{
	
	public static function getBlockNewItems(){
		$db = Dbase::getInstance();
			$query = "SELECT * FROM products ORDER BY Id DESC LIMIT 8";
				$db->query($query);
					$products = $db->results();
					
			$block = "<div id='newItemsInStore'><h2>Latest new items in our store</h2>";
		foreach($products as $p){
			
			$images = !empty($p->image)?Helper::getImages($p->image):array();
			$images = Helper::filterIfImageExists($images, CATALOGUE_PATH.DS,$p->id);
			
				$image = count($images) != 0?$images[0]:"unavailable.png";
					
			$block .= "<a class=\"newItemInStore\" href=\"?page=catalogue-item&amp;category=". $p->category ."&amp;id=". $p->id ."\" data-product-id=\"".$p->id."\">";
				$block .= "<img src=\"media/catalogue/{$image}\" alt=\"";
					$block .= Helper::encodeHTML($p->name, 1);
					$block .= "\"/>";
				$block .= "<p>".Helper::shortenString(Helper::encodeHTML($p->name, 1),30)."</p>";
			$block .= "<p><strong>&dollar;".$p->price."</strong></p></a>";
		}
		
		$block .= "</div>";
		
		echo $block;
	}
	
}

?>