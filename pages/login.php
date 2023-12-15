<?php 
if(Login::isLogged(Login::$_login_front)){
	Helper::redirect(Login::$_dashboard_front);
}

$objForm = new Form();
$objValid = new Validation($objForm);
$objUser =  new User();

//login form
if($objForm->isPost('login_email')){
	if(Input::get("hiddeLogin") == Session::getSession("truckLogin") && Session::getSession("truckLogin")){
		if($objUser->isUser($objForm->getPost('login_email'),$objForm->getPost('login_password'))){
			Login::loginFront($objUser->_hash, Url::getReferrerUrl());
		}else{
			$objValid->add2Errors('login');
		}
	}
}

//registration form
if($objForm->isPost('first_name') && Input::get("hiddeRegistered") == Session::getSession("registeredForm") && Session::getSession("registeredForm")){
	$objValid->_expected = array(
		'first_name',
		'last_name',
		'address_1',
		'address_2',
		'city',
		'zip_code',
		'state',
		'email',
		'password',
		'confirm_password'
	);

	$objValid->_required = array(
		'first_name',
		'last_name',
		'address_1',
		'city',
		'zip_code',
		'state',
		'email',
		'password',
		'confirm_password'
	);

	$objValid->_special = array(
		'email' => 'email'
	);

	

	$objValid->_post_remove = array(
		'confirm_password'
	);

	

	$objValid->_post_format = array(
		'password' => 'password'
	);

	//validate password
	$pass_1 = $objForm->getPost('password');
	$pass_2 = $objForm->getPost('confirm_password');

	if(!empty($pass_1) && !empty($pass_2) && $pass_1 != $pass_2){
		$objValid->add2Errors('password_mismatch');
	}

	$email = $objForm->getPost('email');
	$user = $objUser->getByEmail($email);
	
	if(!empty($user)){
		$objValid->add2Errors('email_duplicate');
	}

	if($objValid->isValid()){
		//add hash for activating accopunt
		$objValid->_post['hash'] = mt_rand().date('Ymdhis').mt_rand();
		//add registration date
		$objValid->_post['date'] = Helper::setDate();
		if($objUser->addUser($objValid->_post, $objForm->getPost('password'))){
			Helper::redirect('?page=registered');
		}else{
			Helper::redirect('?page=registered-failed');
		}
	}
}

require_once('header.php'); 

?>

<h1 class="titlH1">Login :</h1>

<form action="" method="post" id="loginForm">
	<input type="hidden" name="hiddeLogin" value="">
	<table cellpadding="0" cellspacing="0" border="0" class="tbl_insert loginTable">
		<tr>
			<th>
				<label for="login_email">Email:</label>
			</th>
			<td>
				<?php echo $objValid->validate('login'); ?>
				<input type="text" name="login_email" id="login_email" class="fld" value="" autocomplete="off">
			</td>
		</tr>
		<tr>
			<th>
				<label for="login_password">Password:</label>
			</th>
			<td>
				<input type="password" name="login_password" id="login_password" class="fld" value=""  autocomplete="off">
			</td>
		</tr>
		<tr>
			<th>&#160;</th>
			<td>
				<label for="btn_login" class="sbm sbm_blue loginBt">
					<input type="submit" id="btn_login" class="btn" value="Login" onclick="checkInput(this);">
				</label>	
					<?php
						if($objValid->validate('login')){
							?>
							<a href="?page=recoverpas" id="recoverpassword" title="Forgot Password?">Forgot Password?</a>
							<?php
						}
					?>
			</td>
		</tr>
	</table>
</form>

<div class="dev br_td">&#160;</div>

<h3 class="registered">Not registered yet?</h3>
<form action="" method="post" id="registeredForm">
	<input type="hidden" name="hiddeRegistered" value="">
	<table cellpadding="0" cellspacing="0" border="0" class="tbl_insert registeredTable">
		<tr>
			<th>
				<label for="first_name">First name: *</label>
			</th>
			<td>
				<?php echo $objValid->validate('first_name'); ?>
				<input type="text" name="first_name" id="first_name" class="fld" value="<?php echo $objForm->stickyText('first_name'); ?>" autocomplete="off">
			</td>
		</tr>
		<tr>
			<th>
				<label for="last_name">Last name: *</label>
			</th>
			<td>
				<?php echo $objValid->validate('last_name'); ?>
				<input type="last_name" name="last_name" id="last_name" class="fld" value="<?php echo $objForm->stickyText('last_name'); ?>" autocomplete="off">
			</td>
		</tr>
		<tr>
			<th>
				<label for="address_1">Address 1: *</label>
			</th>
			<td>
				<?php echo $objValid->validate('address_1'); ?>
				<input type="address_1" name="address_1" id="address_1" class="fld" value="<?php echo $objForm->stickyText('address_1'); ?>" autocomplete="off">
			</td>
		</tr>
		<tr>
			<th>
				<label for="address_2">Address 2:</label>
			</th>
			<td>
				<?php echo $objValid->validate('address_2'); ?>
				<input type="address_2" name="address_2" id="address_2" class="fld" value="<?php echo $objForm->stickyText('address_2'); ?>" autocomplete="off">
			</td>
		</tr>
		<tr>
			<th>
				<label for="town">City: *</label>
			</th>
			<td>
				<?php echo $objValid->validate('city'); ?>
				<input type="town" name="city" id="city" class="fld" value="<?php echo $objForm->stickyText('city'); ?>" autocomplete="off">
			</td>
		</tr>
		<tr>
			<th>
				<label for="post_code">Zip code: *</label>
			</th>
			<td>
				<?php echo $objValid->validate('zip_code'); ?>
				<input type="post_code" name="zip_code" id="zip_code" class="fld" value="<?php echo $objForm->stickyText('zip_code'); ?>" autocomplete="off">
			</td>
		</tr>
		<tr>
			<th>
				<label for="country">State: *</label>
			</th>
			<td>
				<?php echo $objValid->validate('state'); ?>
				<?php echo $objForm ->getStates();  ?>
			</td>
		</tr>
		<tr>
			<th>
				<label for="email">Email address: *</label>
			</th>
			<td>
				<?php echo $objValid->validate('email'); ?>
				<?php echo $objValid->validate('email_duplicate'); ?>
				<input type="email" name="email" id="email" class="fld" value="<?php echo $objForm->stickyText('email'); ?>" autocomplete="off">
			</td>
		</tr>
		<tr>
			<th>
				<label for="password">Password: *</label>
			</th>
			<td>
				<?php echo $objValid->validate('password'); ?>
				<?php echo $objValid->validate('password_mismatch'); ?>
				<input type="password" name="password" id="password" class="fld" value="" autocomplete="off">
			</td>
		</tr>
		<tr>
			<th>
				<label for="confirm_password">Confirm password: *</label>
			</th>
			<td>
				<?php echo $objValid->validate('confirm_password'); ?>
				<input type="password" name="confirm_password" id="confirm_password" class="fld" value="" autocomplete="off">
			</td>
		</tr>
		<tr>
			<th>&#160;</th>
			<td>
				<label for="btn" class="sbm sbm_blue registeredBt">
					<input type="submit" id="btn" class="btn" value="Register" onclick="checkInput(this);">
			</td>
		</tr>
	</table>
</form>
<?php require_once('footer.php'); ?>