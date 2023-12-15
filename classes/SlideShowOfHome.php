<?php
	class SlideShowOfHome{
		private static $_path = "";
		public static function getBlockSlideShow($links = array(),$path){
			$links; 
			$scan = scandir(SLIDESHOW_PATH);
			self::$_path = $path;
			$images = array();
				foreach($scan as $file) { 
					if (!is_dir($file)){ 
						$i = strpos($file,'_');
						$j = substr($file,$i+1,1);
						$images[$j-1]= $file; 
					} 
				}
			$blockSlideShow = "<div id='homeSlideShow'>";
			$k = 0;
				foreach($images as $image){
					$blockSlideShow .= "<a href='". $links[$k]. "' title='".ucfirst($image)."'><img src='".self::$_path.$image."' alt='".ucfirst($image)."'></a>";
					$k++;
				}
			$blockSlideShow .= "<span id='goRight'></span><span id='goLeft'></span>";
				
				
			
			$blockSlideShow .= "</div><div id='runscale'></div><div id='imgpoints'>";
			for($i=0;$i<count($images);$i++){
					$blockSlideShow .= "<span data-number-img='".$i."' class='imgpoint'  title='".ucfirst($images[$i])."' ></span>";
				}
				$blockSlideShow .= "</div>";
			echo $blockSlideShow;
		}
	}

?>