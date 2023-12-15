<?php

$objCatalogue = new Catalogue();
$cats = $objCatalogue->getCategories();
$objCatalogue->createArrayCategories($cats);

$objBusiness = new Business();
$business = $objBusiness->getBusiness();

$basketjs = "";
if(Session::getSession('basket')){
	foreach (Session::getSession('basket') as $key=>$value){
		$string = "";
			$string .=$key;
			foreach($value as $v){
				$string .= "_".$v;
					$basketjs .= $string.",";
						
			}
	}
	$basketjs = chop($basketjs,",");
}
//echo $basketjs."<br>";
//print_r(Session::getSession('basket'));
//print_r(Login::string2hash("password"));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"httpo://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" charset="UTF-8" />
<title><?php echo $business->name; ?></title>
<meta name="description" content="Ecommerce website project" />
<meta name="keywords" content="Ecommerce website project" />
<meta http-equiv="imagetoolbar" content="no" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

<link href="images/images.jpg" sizes="192x192" rel="icon" />
<link href="css/core.css" rel="stylesheet" type="text/css" />
<link href="css/header.css" rel="stylesheet" type="text/css" />
<link href="css/mobilereviewblock.css" rel="stylesheet" type="text/css" />

<link href="css/main.css" rel="stylesheet" type="text/css" />
<link href="css/reviewblock.css" rel="stylesheet" type="text/css" />
<link href="css/leftmenublock.css" rel="stylesheet" type="text/css" />
<link href="css/homeslideshow.css" rel="stylesheet" type="text/css" />
<link href="css/newitemsinstore.css" rel="stylesheet" type="text/css" />

<link href="css/slideShow.css" rel="stylesheet" type="text/css" />

<link href="css/footer.css" rel="stylesheet" type="text/css" />
<link href="css/catalogue.css" rel="stylesheet" type="text/css" />
<link href="css/catalogue-item.css" rel="stylesheet" type="text/css" />

<link href="css/basket.css" rel="stylesheet" type="text/css" />
<link href="css/login.css" rel="stylesheet" type="text/css" />
<link href="css/orders.css" rel="stylesheet" type="text/css" />
<link href="css/payment.css" rel="stylesheet" type="text/css" />
<link href="css/contact.css" rel="stylesheet" type="text/css" />


<script type="text/javascript">var basketjs = "<?php echo $basketjs;?>";</script>
<script src="js/globalVar.js" type="text/javascript"></script>
<script src="js/onloadfunctions.js" type="text/javascript"></script>
<script src="js/headfunction.js" type="text/javascript"></script>
<script src="js/mobilereviewblock.js" type="text/javascript"></script>
<script src="js/homeSlideShow.js" type="text/javascript"></script>
<script src="js/reviewblock.js" type="text/javascript"></script>
<script src="js/leftmenublock.js" type="text/javascript"></script>
<script src="js/newitemsinstore.js" type="text/javascript"></script>
<script src="js/catalogue-item.js" type="text/javascript"></script>
<script src="js/login.js" type="text/javascript"></script>
<script src="js/footer.js" type="text/javascript"></script>
<script src="js/payment.js" type="text/javascript"></script>
<script src="js/contact.js" type="text/javascript"></script>

<!--[if lt IE 9]>
	<script src="js\shiv.js"></script>
<![endif]-->
</head>
<body>
	<div id="page">
		<div id="header">
			<div id="page-header-container">
		
				<a href="." id="logo"><img src="media/menu/<?php echo $business->logocompany; ?>" alt="<?php echo $business->name; ?>" id="insideLogo" ></a>
			
				<div id="advertising" onclick="popInf(this);"><img src="images/logosale.jpg" alt="Sale Logo"></div>
		
				<?php
					if(Login::isLogged(Login::$_login_front)){
						echo '<div id="logged_as"><span id="allLogInf"><label>Logged in as:</label> <strong style="color:green">';
						echo Login::getFullNameFront(Session::getSession(Login::$_login_front));
						echo '</strong> | <a href="?page=orders" id="myOrders">My orders</a>';
						echo ' | <a href="?page=logout" id="logOut">Logout</a></span>';
					}else{
						echo '<div id="logged_as"><a href="?page=login" id="goLog"><span></span><span>Login</span></a>';
					} 
				?>
						<form id="quickSearch1" action="index.php"method="get">
							<input type="text" name="search" placeholder="Search entire store here..." required>
							<button type="submit" title="Search" data-form="quickSearch1" onclick="goToSerch(event, this);"><span></span></button>
						</form>
						<a id="phoneCampuny" href="tel:+1<?php echo $business->telephone; ?>">1 <?php echo $business->telephone; ?></a>
							<span><span>| 9a - 7p EST</span>| Find us On: </span>
								<img class="header-social-image" style="max-height: 24px; float: right;margin-top:2%;" alt="" src="images/social-contact-mod.png" usemap="#social">
									<map name="social">
										<area title="Facebook" shape="rectangle" coords="1,2,23,20" href="">
											<area title="Twitter" shape="rectangle" coords="27,2,47,20" href="">
												<area title="Google Plus" shape="rectangle" coords="51,2,73,20" href="">
									</map>
						</div>

<!------------------Desktop Menu---------------------------------------------------------------------------------->	

				<div id="navigator">
				
					<ul class="maincategories">
						<li class="uplevel"><a href="." title="HOME"<?php echo Url::cPage()=="index"?'class="act"':''; ?>>Home</a></li>
						
					<?php echo $objCatalogue->layOutCategoriesInUser(0); ?>
					
				</div>
				
<!------------------Mobile drive menu---------------------------------------------------------------------------------->	
			
				<div id="mobSkipLinks">
					<a href="mobMenu">
						<span class="icon"></span>
						<span class="label">Menu</span>
					</a>
					<a href="quickSearch2">
						<span class="icon"></span>
						<span class="label">Search</span>
					</a>
					<a href="mobLogin">
						<span class="icon"></span>
						<span class="label">Login</span>
					</a>
					<a href="mobCart">
						<span class="icon"></span>
						<span class="label">Cart</span>
					</a>
				</div>
				
				
<!------------------Content for mobile menu----------------------------------------------------------------------------->

				<div id="mobMenu">
					<ul class="mainMenuMob">
					<li><a href="." title="HOME"<?php echo Url::cPage()=="index"?'class="act"':''; ?>>Home</a></li>
					
					<?php echo $objCatalogue->layOutMobileStyleCategoriesInUser(0, "mainMenuMob"); ?>
					
				</div>
	
				<div>
					<form id="quickSearch2" method="get">
						<input type="text" name="searchProduct" placeholder="Search entire store here..." required>
						<button type="submit" title="Search" data-form="quickSearch2" onclick="goToSerch(event, this);"><span></span></button>
					</form>
				</div>
				
				<div id="mobLogin">
					<?php if(Login::isLogged(Login::$_login_front)){ ?>
							<div id="logged_as"><p><label>Logged in as:</label> <strong>
							<?php echo Login::getFullNameFront(Session::getSession(Login::$_login_front)); ?>
							</strong></p><p><a href="?page=orders" id="myOrders" style="color:green">My orders</a>
						   | <a href="?page=logout" id="logOut">Logout</a></p></div>
					<?php }else{ ?>
						<form action="?page=login" method="post">
							<input type="hidden" name="hiddeLogin" value="">
							<input type="text" name="login_email"placeholder="Email">
							<input type="password" name="login_password" placeholder="Password">
							<input type="submit" value="Login" onclick="checkInput(this);">
						</form>
					<?php } ?>
				</div>
				
				<div id="mobCart">
					<?php require('basket_left.php'); ?>
				</div>	
			
	
<!-------------- Mobile Review Block ------------------------------------------------------------------------------------>

				<?php if(Cookies::getCookie("reviewblock")){ ?>
					<div id="mobileReviewBlock">
						<span onclick="mobileReviewBlock();"><span></span>Recently Viewed</span>
						<div id="mobileReviewBlockInside">
							<?php Reviewblock::displayProducts(); ?>
							<div class="clear"></div>
						</div>
					</div>
				<?php } ?>
				
				
			<div class="clear"></div>
			
		</div><!------page-header-container----->
	</div><!----header---------->
	
	<script type="text/javascript">layoutHeader();</script>
		<script type="text/javascript">ModMenu();</script>

<!----------Mian contaner-------------------------------------------------------------------------------------------->
	<div id="main">

<!----------Left side--------------------------------------------------------------------------------------------->
		<div id="left">
			<div>
				<?php require('basket_left.php'); ?>
			</div>
			
			<?php if(Cookies::getCookie("reviewblock")){ 
					require('reviewblockleft.php'); 
			 } ?>
			
			<?php require('leftmenublock.php'); ?>
			
		</div>
		
<!----------Right side--------------------------------------------------------------------------------------------->
		<div id="right">
		
		
		