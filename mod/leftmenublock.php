<?php  

	$menu = "";
		$end = false;

	if($cats != null)
	{
		foreach($cats as $cat){
			$path = str_replace(' ', '_', $cat->imageCategorie);
				$path = strtolower("media/menu/". $path);
				
			if(file_exists($path) && is_file($path)){
				$menu .= '<div id="leftmenublock"><h2>Categories</h2>';
					$end = '</div><script type="text/javascript">leftmenublock(GlobalHeightLeftMenu);</script>';
						break;
			}
		
		}

		foreach($cats as $cat){			
		
			$path = str_replace(' ', '_', $cat->imageCategorie);
				$path = strtolower("media/menu/". $path);
				
			if(file_exists($path) && is_file($path)){
				$menu .= "<a href=\"?page=catalogue&amp;category=". $cat->id ."\"";
					$menu .= Helper::getActive(array('category'=>$cat->id));
						$menu .= "title='".Helper::encodeHtml($cat->name)."'><div class='leftMenuBlock'>";
							$menu .= "<img src='";
					$menu .= $path."' alt='".Helper::encodeHtml($cat->name)."'>";
				$menu .= "</div></a>";	
			}

		}
		
		if($end){
			$menu .= $end;
				echo $menu;
		}
		
	}

?>

