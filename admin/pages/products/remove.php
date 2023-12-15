<?php 
$id = Url::getParam('id');

if(!empty($id)){
	
	$objCatalogue = new Catalogue();
	$product = $objCatalogue->getProduct($id);
	
	if(!empty($product)){
		
	$yes = Url::getCurrentUrl()	.'&amp;remove=1';
	$no = 'javascript:history.go(-1)';
	
	$remove = Url::getParam('remove');
		
		if(!empty($remove)){
			$objCatalogue->removeProduct($id);
			Helper::redirect('.'.Url::getCurrentUrl(array('action','id','remove','srch',Paging::$_key)));
		}
		
	require_once('template/_header.php');
	
?>
<h1>Product &#8667; <span class="marker">Remove</span></h1>
<p>Are you sure you want to remove this record?<br>
There is no undo!<br>
<a href="<?php echo $yes; ?>">Yes</a> | <a href="<?php echo $no; ?>">No</a></p>
<?php
	require_once('template/_footer.php');
	}
}
?>