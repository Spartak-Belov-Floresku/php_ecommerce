<?php
$cat = Url::getParam('category');
$limit = Url::limintPerPage();
$sort = Url::orderBy();

if(empty($cat)){
	require_once("error.php");
}else{
	
	$objCatalogue = new Catalogue();
	$category =$objCatalogue->getCategory($cat);

	if($category == null){
		require_once("error.php");
	}else{
		$rows = $objCatalogue->getProducts($cat, $sort[0], $sort[1]);
		
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

<h1 class="titlH1">Catalogue &#8667; <span><?php echo $category->name ; ?></span></h1>
<?php
	if($rows != null){
		foreach($rows as $row){
			
?>
<div class="catalogue_wrapper">
	<div class="catalogue_wrapper_left">
	<?php
	
		$getFirst = !empty($row->image)?Helper::getImages($row->image):array();
		$getFirst = Helper::filterIfImageExists($getFirst, CATALOGUE_PATH.DS, $row->id);
		
		
		$image = count($getFirst) != 0?
		$objCatalogue->_path.$getFirst[0] :
		$objCatalogue->_path.'unavailable.png';
		
		$width = Helper::getImgSize($image, 0);
		$width = $width > 120? 120: $width;
	?>
	<a href="?page=catalogue-item&amp;category=<?php echo $category->id ;?>&amp;id=<?php echo $row->id ;?>">
	<img src="<?php echo $image; ?>" alt="<?php echo Helper::encodeHtml($row->name,1);?>" width="<?php echo $width;?>"/>
	</a>
	</div>
	<div class="catalogue_wrapper_right">
		<h4><a href="?page=catalogue-item&amp;category=<?php echo $category->id ;?>&amp;id=<?php echo $row->id ;?>" title="Go to the Product Page">
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
<p>There are no products in this category.</p>
<?php
		}
		require_once("footer.php");
	}
}
?>