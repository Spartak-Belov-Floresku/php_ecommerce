<?php 
$url = Url::getCurrentUrl(array('action','id'));
require_once('template/_header.php');
?>
<h1>Products &#8667; <span class="marker">Edit</span></h1>
<p>The new record has been updatef successfully, but without changing the image.<br>
<a href="<?php echo $url; ?>">Go back to the list of products.</a></p>
<?php require_once('template/_footer.php'); ?>