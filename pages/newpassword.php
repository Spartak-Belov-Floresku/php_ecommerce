<?php
	Login::restrictFront();
	
	$objForm = new Form();
	$objValid = new Validation($objForm);
	$objUser =  new User();
	
	if($objForm->isPost('password') &&
		Input::get("hiddeChangePassword") == Session::getSession("changePasswordForm") && 
		Session::getSession("changePasswordForm")){
			
		$objValid->_expected = array('password','confirm_password');
		$objValid->_required = array('password','confirm_password');
		
		$objValid->_post_remove = array('confirm_password');
		$objValid->_post_format = array('password' => 'password');
		
		$pass_1 = $objForm->getPost('password');
		$pass_2 = $objForm->getPost('confirm_password');

		if(!empty($pass_1) && !empty($pass_2) && $pass_1 != $pass_2){
			$objValid->add2Errors('password_mismatch');
		}
		
		if($objValid->isValid()){
			$user = $objUser->getUserByHash(Session::getSession(Login::$_login_front));
			
			if($objUser->updateUser(array('password' => $objValid->_post["password"],'recoverpass'=>'1'),$user->id)){
				$text = "<strong>Your password has been successfully changed.</strong><br><br>
							Now, you can login with <strong style='color:red;'>a new password...</strong>";
				Input::putSession("password",$text);
				Input::unSetSession(Login::$_valid_login);
				Helper::redirect('?page=recoversuccess');
			}else{
				Helper::redirect('?page=recoversuccessfailed');
			}
		}
		
			
	}
	
	require_once('header.php'); 
?>
<h1 class="titlH1">Action is needed<br> to change your <strong style="color:red;">temporary</strong> password....</h1>

<form action="" method="post" id="changePasswordForm">
	<input type="hidden" name="hiddeChangePassword" value="">
	<table cellpadding="0" cellspacing="0" border="0" class="tbl_insert loginTable">
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
				<label for="btn_login" class="sbm sbm_blue loginBt">
					<input type="submit" id="btn_login" class="btn" value="Send" onclick="checkInput(this);">
				</label>
			</td>
		</tr>
	</table>
</form>

<div class="dev br_td">&#160;</div>

<?php

	require_once('footer.php');
?>	