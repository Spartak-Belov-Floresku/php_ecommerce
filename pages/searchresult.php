<?php

$request = Url::getParam('search');

$request = explode(" ",trim(str_replace('+',' ',$request)));

$limit = Url::limintPerPage();
$sort = Url::orderBy();


	
	$objCatalogue = new Catalogue();
	
		$rows = array();
		
		if(trim($request[0]) != ""){
			$rows = $objCatalogue->getAllProducts(trim($request[0]), $sort[0], $sort[1]);
		}
		
		$i = 1;
			
		while($i < count($request)){
			
			$row = array();
			
			if(trim($request[$i]) != ""){
				$row = $objCatalogue->getAllProducts(trim($request[$i]), $sort[0], $sort[1]);
			}
			
			if(count($row) > 0){
				for ($j = 0; $j < count($row); $j++){
					$check = true;
					for($k = 0; $k < count($rows); $k++){
						if($rows[$k]->id == $row[$j]->id){
							$check = false;
							break;
						}
					}
					if($check){
						$rows[] = $row[$j];
					}
				}
			}
			
			$i++;
			
		}
		
		
		$totalRows = count($rows);
		
		$objPaging = new Paging($rows,$limit);
		$rows = $objPaging->getRecords();
			
		require_once("header.php");
		
		
		
		 
?>
<?php 
	if($rows != null){
?>
<div id="gid">
<?php 
		echo '<div id="sort-by">';
			$objPaging->bropBoxSortBy(); 
				echo '</div>';

				$objPaging->getRifrences($limit, $totalRows);
			$objPaging->dropBoxLimitPerPage();
		$objPaging->currentPosition($limit, $totalRows);
?>
<div class="clear"></div></div>
<?php } ?>

<h1 class="titlH1"><span>Matching product<?php echo $totalRows>1?'s':''; ?> &#8667; <?php echo $totalRows; ?></span></h1>
<?php
	if($rows != null){
		foreach($rows as $row){
			
?>
<div class="catalogue_wrapper">
	<div class="catalogue_wrapper_left">
	<?php
		$getFirst = Helper::getImages($row->image);
		$image = !empty( $getFirst[0] )?
		$objCatalogue->_path.$getFirst[0] :
		$objCatalogue->_path.'unavailable.png';
		
		$width = Helper::getImgSize($image, 0);
		$width = $width > 120? 120: $width;
	?>
	<a href="?page=catalogue-item&amp;category=<?php echo $row->category ;?>&amp;id=<?php echo $row->id ;?>">
	<img src="<?php echo $image; ?>" alt="<?php echo Helper::encodeHtml($row->name,1);?>" width="<?php echo $width;?>"/>
	</a>
	</div>
	<div class="catalogue_wrapper_right">
		<h4><a href="?page=catalogue-item&amp;category=<?php echo $row->category ;?>&amp;id=<?php echo $row->id ;?>" title="Go to the Product Page">
		<?php echo Helper::encodeHtml($row->name,1);?></a></h4>
		<p><?php echo Helper::shortenString(Helper::encodeHtml($row->description)); ?></p>
		<h4>Price: <?php $objCatalogue::Currency($row->price); ?></h4>
		<p><?php echo Basket::activeButton($row->id);?></p>
	</div>
</div>
<?php
		}
		
		$objPaging->getPaging();
		
	}else{

?>
<p>There are no products in the search result.</p>
<?php
		}
		require_once("footer.php");

?>