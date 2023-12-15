<?php

Login::restrictFront();
$objUser =  new User();

$user = $objUser->getUser(Session::getSession(Login::$_login_front));

if(!empty($user)){
	
$objForm = new Form();
$objValid = new Validation($objForm);

if($objForm->isPost('first_name')&& Input::get("hiddeCheckout") == Session::getSession("checkoutForm") && Session::getSession("checkoutForm")){

	$objValid->_expected = array(
		'first_name',
		'last_name',
		'address_1',
		'city',
		'zip_code',
		'state',
		'email'
	);

	$objValid->_required = array(
		'first_name',
		'last_name',
		'address_1',
		'city',
		'zip_code',
		'state',
		'email'
	);

	$objValid->_special = array('email' => 'email');

	if($objValid->isValid()){

		if($objUser->updateUser($objValid->_post, $user->id)){
			Helper::redirect('?page=summary');
		}else{
			$mess  = "<p class=\"red\">There was a problem updating your details.<br>";
			$mess .= "Please contact administrator.</p>";
		}

	}

}



require_once('header.php');

?>

<h1 class="titlH1">Checkout</h1>

<p class="checkout">Please check your details and click  <strong>Next</strong></p>
<?php echo !empty($mess) ? $mess : null; ?>

<form action="" method="post" id="checkoutForm">
	<input type="hidden" name="hiddeCheckout" value="">
	<table cellpadding="0" cellspacing="0" border="0" class="tbl_insert" id="checkout">
		<tr>
			<th><label for="first_name">First name: *</label></th>
			<td>
			<?php echo $objValid->validate('first_name'); ?>
				<input type="text" name="first_name" id="first_name" class="fld" value="<?php echo $objForm->stickyText('first_name', $user->first_name); ?>" autocomplete="off">
			</td>
		</tr>
		<tr>
			<th><label for="last_name">Last name: *</label></th>
			<td>
			<?php echo $objValid->validate('last_name'); ?>
				<input type="text" name="last_name" id="last_name" class="fld" value="<?php echo $objForm->stickyText('last_name', $user->last_name); ?>" autocomplete="off">
			</td>
		</tr>
		<tr>
			<th><label for="address_1">Address 1: *</label></th>
			<td>
			<?php echo $objValid->validate('address_1'); ?>
				<input type="text" name="address_1" id="address_1" class="fld" value="<?php echo $objForm->stickyText('address_1', $user->address_1); ?>" autocomplete="off">
			</td>
		</tr>
		<tr>
			<th><label for="address_2">Address 2: </label></th>
			<td>
				<input type="text" name="address_2" id="address_2" class="fld" value="<?php echo $objForm->stickyText('address_2', $user->address_2); ?>" autocomplete="off">
			</td>
		</tr>
		<tr>
			<th><label for="town">City: *</label></th>
			<td>
			<?php echo $objValid->validate('city'); ?>
				<input type="text" name="city" id="city" class="fld" value="<?php echo $objForm->stickyText('city', $user->city); ?>" autocomplete="off">
			</td>
		</tr>
		<tr>
			<th><label for="county">Zip code: *</label></th>
			<td>
			<?php echo $objValid->validate('zip_code'); ?>
				<input type="text" name="zip_code" id="zip_code" class="fld" value="<?php echo $objForm->stickyText('zip_code', $user->zip_code); ?>" autocomplete="off">
			</td>
		</tr>
		<tr>
			<th><label for="country">State: *</label></th>
			<td>
				<?php echo $objValid->validate('state'); ?>
				<?php echo $objForm->getStates($user->state);  ?>				
			</td>
		</tr>
		<tr>
			<th><label for="email">Email address: *</label></th>
			<td>
			<?php echo $objValid->validate('email'); ?>
				<input type="text" name="email" id="email" class="fld" value="<?php echo $objForm->stickyText('email', $user->email); ?>" autocomplete="off">
			</td>
		</tr>
		<tr>
			<th>&nbsp;</th>
			<td>
			<label for="btn" class="sbm sbm_blue fl_l" style="width:auto;" id="checkoutBt">
				<input type="submit" id="btn" class="btn" value="Next" onclick="checkInput(this);">
			</label>
			</td>
		</tr>
	</table>
</form>
<?php
require_once('footer.php');
}else{
	Helper::redirect('?page=error');
}
?>