<?php
$message = Session::getSession('note');
		$message != ''?Input::unSetSession('note'):Helper::redirect("?page=payment");
			Session::clear('basket');

$objBusiness = new Business();
$business = $objBusiness->getBusiness();
				
require_once('header.php'); 
?>

<h1 class="titlH1">Transaction has be failed...</h1>

<p style="font-size:16px;color:#400;weight:900;">There was a some problem to process your order.</p>
<p style="font-size:16px;weight:900;">Please give us a phone call <br><a style="color:#400;line-height:35px;"href="tel:<?php echo $business->telephone ; ?>"><?php echo $business->telephone ; ?></a></p>
<p style="font-size:16px;color:#400;weight:900;">Your transaction # <?php echo $message; ?></p>



<?php 
require_once('footer.php'); 
?>