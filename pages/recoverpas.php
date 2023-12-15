<?php 
if(Login::isLogged(Login::$_login_front)){
	Helper::redirect(Login::$_dashboard_front);
}

$objForm = new Form();
$objValid = new Validation($objForm);
$objUser =  new User();

if($objForm->getPost('email') && 
		Input::get("hiddeRecover") == Session::getSession("recoverForm") && 
						Session::getSession("recoverForm")){
	$objValid->_expected = array("email");
	$objValid->_required = array("email");
	$objValid->_special = array('email' =>'email');
	
	if($objValid->isValid()){
		$email = $objForm->getPost('email');
		$user = $objUser->getByEmail($email);
			if(!empty($user)){
				$password = array();
				$password = $objUser->randomPassword();
				$objUser->updateUser(array("password" => $password["hash"], "recoverpass" => "0"), $user->id);
				
				$objEmail = new Email();
				if($objEmail->process(2, array(
					'email' 		=> $user->email,
					'first_name' 	=> $user->first_name,
					'last_name' 	=> $user->last_name,
					'password' 		=> $password["password"]
				))){
					$text = "<strong>Your password has been successfully changed.</strong><br><br>
							Your new <strong style='color:red;'>temporary</strong> password has been sent to email.<br><br>
							<span style='color:#900;font-weight:900;'>Receiving email can take 5-10 minutes.</span>";
					Input::putSession("password",$text);
					
					Helper::redirect('?page=recoversuccess');
				}else{
					Helper::redirect('?page=recoversuccessfailed');
				}
			}else{
				$objValid->add2Errors('email_not_exist');
			}
	}
	
}

if(Input::get('email') == "" && 
		Input::get("hiddeRecover") == Session::getSession("recoverForm") && Session::getSession("recoverForm")){
		$objValid->add2Errors('email');
}

require_once('header.php'); 

?>
<h1 class="titlH1">Frogot Password?</h1>

<form action="" method="post" id="recoverForm">
	<input type="hidden" name="hiddeRecover" value="">
	<table cellpadding="0" cellspacing="0" border="0" class="tbl_insert loginTable">
		<tr>
			<th>
				<label for="login_email">Email:</label>
			</th>
			<td>
				<?php echo $objValid->validate('email'); ?>
				<?php echo $objValid->validate('email_not_exist'); ?>
				<input type="text" name="email" id="email" class="fld" value="" autocomplete="off">
			</td>
		</tr>
			<th>&#160;</th>
			<td>
				<label for="btn_login" class="sbm sbm_blue loginBt">
					<input type="submit" id="btn_login" class="btn" value="Send" onclick="checkInput(this);">
				</label>
				<?php
						if($objValid->validate('email_not_exist')){
							?>
							<a href="?page=login" id="recoverpassword" title="Forgot Password?">Not registered yet?</a>
							<?php
						}
					?>
				
			</td>
		</tr>
	</table>
</form>

<div class="dev br_td">&#160;</div>


<?php require_once('footer.php'); ?>