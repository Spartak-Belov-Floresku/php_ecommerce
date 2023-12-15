<?php 
	$message = Session::getSession('note');
		$message != ''?Input::unSetSession('note'):Helper::redirect("?page=payment");
			Session::clear('basket');
 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Note</title>
<meta name="description" content="" />
<meta name="keywords" content="" />
<meta http-equiv="imagetoolbar" content="no" />
<style type="text/css">
.titlH1{
	text-align:center;
	font-size:28px;
}
#preinvoice{
	dispaly:block;
	padding:25px;
	max-width: 1260px;
	margin:0 auto;
}
#preinvoice>ul{
	font-size:14px;
	line-height:20px;
    font-family: 'Helvetica Neue', Verdana, Arial, sans-serif;
	font-weight:300;
	list-style-position: inside;
	margin-bottom:45px;
}
#preinvoice>ul>li{
	margin-top:25px;
}
#preinvoice>a{
	margin-left:40px;
	
}

</style> 
</head>
<body>
<div id="preinvoice">
<h1 class="titlH1">Thank you for your order</h1>
<ul><?php echo $message; ?></ul>
<a href="#" onclick="window.print(); return false;">Print</a> <a href="?page=orders">My orders</a>
</div>
</body>
</html>