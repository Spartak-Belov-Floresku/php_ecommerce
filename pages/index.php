<?php require_once('header.php'); ?>

	<?php SlideShowOfHome::getBlockSlideShow(array("?page=catalogue-item&category=1&id=3","1","2"),'media/slideshow/');?>
		 
			<script type="text/javascript">homeSlideShowSize();</script>
			<script type="text/javascript">displayNone();</script>
				<script type="text/javascript">growRunScale();</script>
					<script type="text/javascript"> carousel();</script>
<?php
//Cookies::setCookie("lol","lol_hi");
//echo Cookies::getCookie("viewingproducts");
//Cookies::deleteCookie("reviewblock");
//echo Cookies::getCookie("lol");
?>


<?php Newitems::getBlockNewItems();?>




<?php require_once('footer.php'); ?>