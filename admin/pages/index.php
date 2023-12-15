<?php
	if(Login::isLogged(Login::$_login_admin)){
		Helper::redirect(Login::$_dashboard_admin);
	}

	$trackadmin = Session::getRandomNumber();

	$objForm = new Form();
	$objValid = new Validation($objForm);

	if($objForm->isPost('login_email') && 
			(Login::string2hash(Input::get('trackadmin')) == Session::getSession('trackadmin'))){
		$objAdmin = new Admin();
		if($objAdmin->isUser($objForm->getPost('login_email'), $objForm->getPost('login_password'))){
			Login::loginAdmin($objAdmin->_hash, Url::getReferrerUrl());
		}else{
			$objValid->add2Errors('login');
		}
	}

	Session::setSession('trackadmin',Login::string2hash($trackadmin));

	require_once('template/_header.php');
?>
<form action="" method="post">
	<input type="hidden" name="trackadmin" value="<?php echo $trackadmin; ?>">
	<table cellpadding="0" cellspacing="0" border="0" class="tbl_insert">
		<tr>
			<th><label for="login_email">Login:</label></th>
			<td>
				<?php echo $objValid->validate('login')?>
				<input type="text" name="login_email" id="login_email" class="fld" value="">
			</td>
		</tr>
		<tr>
			<th><label for="login_password">Password:</label></th>
			<td>
				<input type="password" name="login_password" id="login_passwor" class="fld" value="">
			</td>
		</tr>
		<tr>
			<th>&nbsp;</th>
			<td>
				<label for="btn_login" class="sbm sbm_blue fl_l">
					<input type="submit" id="btn_login" class="btn" value="Login">
				</label>
			</td>
		</tr>
	</table>
</form>
<?php
require_once('template/_footer.php');
?>