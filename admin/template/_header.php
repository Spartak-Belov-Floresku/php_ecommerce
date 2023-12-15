<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"httpo://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html;
charset=UTF-8" />
<title>Ecommerce website project</title>
<meta name="description" content="Ecommerce website project" />
<meta name="keywords" content="Ecommerce website project" />
<meta http-equiv="imagetoolbar" content="no" />
<link href="css/core.css" rel="stylesheet" type="text/css" />
<script src="js/table.js" type="text/javascript"></script>
</head>
<body style="opacity:1;">
<div id="header">

	<div id="header_in">

		<h5><a href="?page=products">Content Management System</a></h5>
		<?php
			if(Login::isLogged(Login::$_login_admin)){
					echo '<div id="logged_as">Logged in as: <strong>';
					echo Login::getFullNameFront(Session::getSession(Login::$_login_admin));
					echo '</strong> | <a href="?page=logout">Logout</a></div>';
			}
		?>
	</div>

</div>
<div id="outer">

	<div id="wrapper">
		<div id="left">
		<?php if(Login::isLogged(Login::$_login_admin)){ ?>
			<h2>Navigation</h2>
			<div class="dev br_td">&nbsp;</div>
			<ul id="navigation">
				<li>
					<a href="?page=products"
					<?php echo Helper::getActive(
						array('page' => 'products')
					); ?>>
					products
					</a>
				</li>
				<li>
					<a href="?page=categories"
					<?php echo Helper::getActive(
						array('page' => 'categories')
					); ?>>
					categories
					</a>
				</li>
				<li>
					<a href="?page=orders"
					<?php echo Helper::getActive(
						array('page' => 'orders')
					); ?>>
					orders
					</a>
				</li>
				<li>
					<a href="?page=clients"
					<?php echo Helper::getActive(
						array('page' => 'clients')
					); ?>>
					clients
					</a>
				</li>
				<li>
					<a href="?page=business"
					<?php echo Helper::getActive(
						array('page' => 'business')
					); ?>>
					business
					</a>
				</li>
			</ul>
		<?php }else{ ?>
				&nbsp;
		<?php } ?>		
		</div>
		<div id="right">



		