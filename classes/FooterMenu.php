<?php
class FooterMenu{
		public static function getFooterMenu($path){
			
			$menu = "";
			$reader = new XMLReader();
			
			if(!$reader->open(MENU_PATH.$path)) 
				echo "Funny";
			
				$menu .= "<div id='footerMenu'><ul class='footerFisrt'>";
			while($reader->read()) {
				if ($reader->nodeType == XMLReader::ELEMENT && $reader->name == 'building') {
						$address = $reader->getAttribute('address');
						$href = $reader->getAttribute('href');
						if($address == "ul"){
							$menu .= "</ul><ul class='".$href."'>";
							continue;
						}
					$active  ="";
					if(Url::cPage()==$href && !preg_match('/error.php/',Url::getPage())){
						$active = "class='activeFooter'";
					} 
					$menu .= "<li class='footer'><a href='?page=". strtolower($href) ."' title='". ucwords($address) ."' ".$active.">". strtoupper($address) ."</a></li>";
				}
			}
			$menu .= "</ul></div>";
			$reader->close();
			echo $menu;
		}
	}

?>