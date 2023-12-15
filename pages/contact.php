<?php
	$objBusiness = new Business();
	$business = $objBusiness->getBusiness();

	require_once("header.php");
?>

<h1 class="titlH1">Contact Us :</h1>
<div class="map">
<div class="overlay" onClick="style.pointerEvents='none'"></div>
<iframe id="inframe" frameborder="3" scrolling="no" marginheight="0" src="<?php $objBusiness->getLocation($business->address,12); ?>"></iframe>
</div>
<div class="clear"></div>
<div class="buisnessInfo">
	<h2><?php echo $business->name; ?> :</h2>
		<ul>	
			<li><?php echo nl2br($business->address); ?></li>
			<li><?php echo $business->telephone ?></li>
			<li><?php echo $business->email; ?></li>
			<li><?php echo $business->website; ?></li>
		</ul>
</div>
<div class="buisnessFrom">
<div>
<h2>Contact Us :</h2>
	<div id="buisnessFrom">
		<p>* Required Fields</p>
			<input type="hidden" id="trackbuisnessform" name="trackbuisnessform" value="" >
			<label id="email">Email<em>*</em></label>
			<input type="email" name="email" onclick="removeWarn(this)">
			<label id="name">Your name<em>*</em></label>
			<input type="text" name="name" onkeypress="checkInputCF(event,this)" onclick="removeWarn(this)">
			<label id="subject">Subject<em>*</em></label>
			<input type="text" name="subject" onkeypress="checkInputCF(event,this)" onclick="removeWarn(this)">
			<label id="comment">Comment<em>*</em></label>
			<textarea name="comment" id="com" onkeypress="checkInputCF(event,this)" onclick="removeWarn(this)"></textarea>
			<label for="btn_login" class="sbm sbm_blue loginBt">
			<input type="submit" id="requestF" class="btn" value="Send" onclick="sendLetter(event,this);">
			</label>
			<div class="clear"></div>
	</div>
</div>
</div>
<?php
	require_once("footer.php");
?>