<?php 
$id = Url::getParam('id');

if(!empty($id)){
	
	$objCatalogue = new Catalogue();
	$category = $objCatalogue->getCategory($id);
	
	if(!empty($category)){
		
	$yes = Url::getCurrentUrl()	.'&amp;remove=1';
	$no = 'javascript:history.go(-1)';
	
	$remove = Url::getParam('remove');
		
		if(!empty($remove)){
			$objCatalogue->removeCategory($id);
			Helper::redirect('.'.Url::getCurrentUrl(array('action','id','remove','srch',Paging::$_key)));
		}
		
	require_once('template/_header.php');
	
?>
<h1>Categories &#8667; <span class="marker">Remove</span></h1>
<p>Are you sure you want to remove this record?</p>
<p style="text-align:center;"><span class="marker" style="font-size:14px;font-weight:700;color:red;"> Warning, all related categories and products will be deleted too!</span></p>
<p>There is no undo!</p>
<p><a href="<?php echo $yes; ?>">Yes</a> | <a href="<?php echo $no; ?>">No</a></p>
<?php
	require_once('template/_footer.php');
	}
}
?>