<?php 
$objCatalogue = new Catalogue();
$categories = $objCatalogue->getCategories();
$objCatalogue->createArrayCategories($categories);

$objPaging = new Paging($categories, 20);
$rows = $objPaging->getRecords();

require_once('template/_header.php'); 
?>

<h1>Categories</h1>

<p><a href="?page=categories&amp;action=add"id="createmaincat">Create &#8667; New Main Category</a></p>
<?php if(!empty($rows)){ ?>
<div id="admincategory">
<div><span>Category</span><span>Remove</span><span>Edit</span></div>

<?php echo $objCatalogue->layOutCategoriesInAdminPanel(0); ?>


</div>

<?php echo $objPaging->getPaging(); ?>
<?php }else{
	echo '<p>There are currently no categories created.</p>';
}
?>
<?php require_once('template/_footer.php'); ?>
