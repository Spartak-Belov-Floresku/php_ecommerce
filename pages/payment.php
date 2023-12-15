<?php

Login::restrictFront();
	
	if(Login::string2hash(Input::get("token")) != Session::getSession("token2")){Helper::redirect("?page=summary");}
	
	$creditcardObject = new Creditcard();
	
	$usercreditcards = $creditcardObject->getCreditCards(Session::getSession('cid'));
	
	$errorMess = "";
	
	if(Input::get("truckPermanetCards")&& 
		Input::get("truckPermanetCards") == Session::getSession("permanetcards") && 
			Session::getSession("permanetcards")){
			
		$idCard = IntegerFilter::filter(Input::get("pd_selected"));	

		if($idCard == null){
			
			$errorMess = "Please choose a credit / debit card";
		
		}else{
			
			$objOrder = new Order();
				
				if($objOrder->createOrder()){
					
					$order = $objOrder->getOrder();
				
					if(!empty($order)){
						
						$db = Dbase::getInstance();
						
						$text = "<li><strong>Transaction under #". $order->id ." has been started.</strong></li>
								<li>Amount total: $".$order->total."</li>
								<li>This confirmation can take up to 48 hours. Notification will be sent on your email.</li>
								<li><span style='color:#900; font-weight:900;'>When this transaction will be completed, the invoice would be available in your account.</span></li>";
					
						$check = $creditcardObject->getGreditCardById($idCard, $order->client);
						
						if($creditcardObject->sendOrderToEmail($order) && $check){
										
							$db->prepareInsert(array('notes' => 'The payement with a permanent credit / debit card'));
								$db->update('orders',$order->id);
									Input::putSession("note",$text);
										Helper::redirect('?page=paymentnote');
										
						}else{
										
							$db->prepareInsert(array('notes' => 'Warning !!! User tries to change a code on the web page.Credit card information was not sent'));
								$db->update('orders',$order->id);
									Session::setSession("note",$order->id);
										Helper::redirect('?page=paymentnotefailed');
										
						}
					}
				}
		}	
				
	}else if(Input::get("hiddenCreditCard")&& 
		Input::get("hiddenCreditCard") == Session::getSession("formcreditcards") && 
			Session::getSession("formcreditcards")){
	
		if($creditcardObject->checkCard(Input::get("card"),Input::get("creditnumber"),Input::get("csn"),Input::get("month"),Input::get("year"))){
			
			$objOrder = new Order();
				
				if($objOrder->createOrder()){
					
					$order = $objOrder->getOrder();
					
					if(!empty($order)){
							
							$db = Dbase::getInstance();
							
							$text = "<li><strong>Transaction under #". $order->id ." has been started.</strong></li>
								<li>Amount total: $".$order->total."</li>
								<li>This confirmation can take up to 48 hours. Notification will be sent on your email.</li>
								<li><span style='color:#900; font-weight:900;'>When this transaction will be completed, the invoice would be available in your account.</span></li>";
							
							$remeber = Input::get("rememberCredit");
								
								if(strcasecmp($remeber,"remember") === 0){
									
									if($creditcardObject->sendOrderToEmail($order)){
										
										$creditcardObject->putCreditCardDataInDataBase($order->client);
										
										$db->prepareInsert(array('notes' => 'The payement with a permanent credit / debit card'));
											$db->update('orders',$order->id);
										Input::putSession("note",$text);
											Helper::redirect('?page=paymentnote');
											
									}else{
										
										$db->prepareInsert(array('notes' => 'Credit card information was not sent'));
											$db->update('orders',$order->id);
										Session::setSession("note",$order->id);
											Helper::redirect('?page=paymentnotefailed');
									}
									
								}else{
											
									if($creditcardObject->sendOrderToEmail($order)){
										
										$db->prepareInsert(array('notes' => 'One time payment'));
											$db->update('orders',$order->id);
										Input::putSession("note",$text);
												Helper::redirect('?page=paymentnote');
									
									}else{
										
										$db->prepareInsert(array('notes' => 'Credit card information was not sent'));
											$db->update('orders',$order->id);
										Session::setSession("note",$order->id);
											Helper::redirect('?page=paymentnotefailed');
									
									}

								}

					}
				}
		}
				
	}
	
	require_once("header.php");

?>
<script type="text/javascript">
	var month = <?php echo $creditcardObject->_month; ?>;
	var year =	<?php echo $creditcardObject->_year; ?>;
	var sel = "";
</script>
<h1 class="titlH1">Credit / Debit Card Information</h1>
<?php
	if($usercreditcards == null){
?>
		<h2>You don't have activated credit or debit cards.</h2>
<?php
	}else{
?>	

<form action="" method="post" id="permanetcards">

	<input type="hidden" name="truckPermanetCards" value="">
	
		<table cellpadding="0" cellspacing="0" border="0" class="tbl_repeat pcards">
			<tr>
				<th>Select</th>
				<th class="ta_r">Your saved method of payment</th>
				<th class="ta_r col_30">Name</th>
				<th class="ta_r col_15">Expiration</th>
			</tr>		
<?php	
        foreach($usercreditcards as $card){
			
?>
		<tr class="percar">
			<td><input name="pd_selected" value="<?php echo $card[0]; ?>" type="radio" onclick="removeError();"></td>
			<td class="ta_r"><img src="images/<?php echo $card[1];?>.png" alt="<?php echo $card[1];?>"> &nbsp; <span><?php echo ucfirst($card[1]);?></span> &nbsp; ending in <?php echo $card[2];?></td>
			<td class="ta_r"><?php echo Login::getFullNameFront(Session::getSession(Login::$_login_front));?></td>
			<td class="ta_r"><?php echo $card[3];?></td>
		</tr>

<?php
			
		}		
?>
	</table>
	
	<div>
		<label id="radionCheck"><?php echo $errorMess; ?></label>
		<label for="btn_login" class="sbm sbm_blue loginBt pc">
			<input type="submit" id="btn_login" class="btn" value="Pay Order" onclick="checkRadio(event, this)" name="cardsdb">
		</label>
		<div class="clear"></div>
	</div>
<?php
	}
?>
	
</form>
<h2 class="pTitle">Add credit / debit card</h2>
<span class="cards"><img src="images/creditcards.png" alt="Creditcards"></span>
<form action="" method="post" id="formcreditcards">
<input type="hidden" name="hiddenCreditCard">
<table cellpadding="0" cellspacing="0" border="0" class="tbl_insert tabelCreditCard">
	<tr>
		<th>
			<label for="cardname">Card :*</label>
		</th>
		<td>
			<?php $creditcardObject->returnError('cardname'); ?>
			<?php  $creditcardObject->getCardNames(); ?>
		</td>
	</tr>
	<tr>
		<th>
			<label for="creditnumber">Card number :*</label>
		</th>
		<td>
			<?php $creditcardObject->returnError('cardnumber'); ?>
			<input type="text" name="creditnumber" id="card_number" class="fld" onkeyup="checknumber(event, this)" value="<?php echo $creditcardObject->_cardnumber; ?>"/>
		</td>
	</tr>
	<tr>
		<th>
			<label for="csn">CSN code :*</label>
		</th>
		<td>
			<?php $creditcardObject->returnError('csn'); ?>
			<input type="text" name="csn" id="csn_code" class="fld" onkeypress="checknumber(event, this)" value="<?php echo $creditcardObject->_csncode; ?>"/>
		</td>
	</tr>
	<tr>
		<th>
			<label for="expiration">Date Expiration :*</label>
		</th>
		<td>
			<?php $creditcardObject->returnError('date'); ?>
			<select name="month" class="sel month" id="month" onchange="focusDate();">
				<script type="text/javascript">
					for(var i=1;i<=12;i++){
						if(month == i){
							sel = "selected='true'";
						}
						var a = i<10?"0":"";
							document.write("<option value='"+i+"' "+sel+">"+a+""+i+"</option>");
							sel = "";
					}
				</script>
			</select >
			<select name="year" class="sel year" id="year" onchange="focusDate();">
				<script type="text/javascript">
					var d = new Date();
					var n = d.getFullYear();
					for(var i = n; i<=n+10; i++){
						if(year == i){
							sel = "selected='true'";
						}
						document.write("<option value='"+i+"' "+sel+">"+i+"</option>");
						sel = "";
					}
				</script>
			</select>
		</td>
	</tr>
	<tr>
		<th>
			<label for="usercredit">Remember ? :</label>
		</th>
		<td>
			<select name="rememberCredit" id="usecredit" class="sel">
				<option value="onetime">One time payment</option>
				<option value="remember">Remember Card</option>
			</select><br>
		</td>
	</tr>
	<tr>
		<th>&#160;</th>
			<td>
				<label for="btn_login" class="sbm sbm_blue loginBt">
					<input type="submit" id="btn_login" class="btn" value="Send" onclick="sendCardNumber(event,this)" name="newcard">
				</label>
			</td>
	</tr>
</table>
<form>

<?php
require_once("footer.php");
?>