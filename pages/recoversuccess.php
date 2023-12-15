<?php 

$message = Session::getSession("password");

$message == ""?Helper::redirect(Login::$_login_page_front):Input::unSetSession("password");

require_once('header.php'); 
?>

<h1 class="titlH1">Recover Password</h1>

<p style="
	font-size:16px;
	line-height:20px;
    font-family: 'Helvetica Neue', Verdana, Arial, sans-serif;
	font-weight:300;
"><?php echo $message; ?></p>

<?php 
require_once('footer.php'); 
?>