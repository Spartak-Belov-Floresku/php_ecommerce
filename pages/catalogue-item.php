<?php
	$id = Url::getParam('id');
		
	if (!empty($id)){
		
		if(Cookies::getCookie("reviewblock")){
			
			Cookies::setCookie("reviewblock",
									Reviewblock::addProduct(
										Cookies::getCookie("reviewblock"),$id,9));
		}else{
			
			Cookies::setCookie("reviewblock",$id);
		
		}
		
		$objCatalogue = new Catalogue();
		$product = $objCatalogue->getProduct($id);
		
		if(!empty($product)){
			
			$category = $objCatalogue->getCategory($product->category);
			
			require_once('header.php');
			
			echo "<h1 class=\"titlH1\">Catalogue &#8667; <span>". $category->name ."</span></h1>";
			
			
			$images = !empty($product->image)?Helper::getImages($product->image):array();
			$images = Helper::filterIfImageExists($images, CATALOGUE_PATH.DS, $product->id);
			
			if(count($images) == 0){
				$images = array('unavailable.png');
			}
			
			if( count($images) != 0){
				$widthMargin = Helper::getWidthAndMargin(
										Helper::getImgSize(CATALOGUE_PATH.DS.$images[0], 1),
										Helper::getImgSize(CATALOGUE_PATH.DS.$images[0], 0),
										Helper::getImgSize(CATALOGUE_PATH.DS.$images[0], 0),
										350
										);
				
				echo "<div class=\"fl_l\">";
				echo "<h3 id=\"productName\">".$product->name."</h3>";
				echo "<p id='show'></p>";
				echo "<div class=\"lft\"><div><img class=\"largeImage\" src=\"media/catalogue/{$images[0]}\" alt=\"";
				echo Helper::encodeHTML($product->name, 1);
				echo "\" width=\"{$widthMargin[0]}\" style=\"margin-top:{$widthMargin[1]}px;\"/><div id=\"zoom\"><div id='zoomInside'></div></div></div>";
					if(count($images) > 1){
						if(count($images) > 4){
								echo "<div id='goLeftMini'></div>";
						}
						echo "<div class=\"fs_imag\"><ul class=\"lstIcon\">";
						for($i=0;$i<count($images);$i++){
							$widthMarginSmall = Helper::getWidthAndMargin(
											Helper::getImgSize(CATALOGUE_PATH.DS.$images[$i], 1),
											Helper::getImgSize(CATALOGUE_PATH.DS.$images[$i], 0),
											Helper::getImgSize(CATALOGUE_PATH.DS.$images[$i], 0),
											70
											);
							echo "<li class=\"smallImage\"><img src=\"media/catalogue/{$images[$i]}\" alt=\"";
							echo Helper::encodeHTML($product->name, 1);
							echo "\" width=\"{$widthMarginSmall[0]}\"  style=\"margin-top:{$widthMarginSmall[1]}px;\"/></li>";
						}
						echo "</ul></div>";
						if(count($images) > 4){
								echo "<div id='goRightMini' onclick='goRightOrLeft(this)' class='putArrow'></div>";
						}
					}
				
				echo "</div>";
			}
			echo "<script type='text/javascript'>widthlstIcon();</script>";
			echo "<div class=\"rgt\">";
			echo "<h3>Price: <strong>&dollar;".$product->price."</strong></h4>";
			echo Basket::activeButton($product->id);
			echo "<p id=\"description\">".Helper::encodeHTML($product->description)."</p>";
			echo "</div></div>";
			echo "<div class=\"dev\">&#160;</div>";
			echo "<div class=\"dev br_td\">&#160;</div>";
			echo "<p id=\"goBack\"><a href=\"javascript:history.go(-1)\">&#171;&#171;&#171;&nbsp;Go back</a></p>";
			
			require_once('footer.php');
		}else{
			require_once('error.php');
		}
		
	}else{
		require_once('error.php');
	}

?>
<script src="js/switchproductimage.js" type="text/javascript"></script>
<script src="js/productSlideShow.js" type="text/javascript"></script>