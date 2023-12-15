<?php 
$session = Session::getSession('basket');
$objBasket = new Basket();

$out = array();

if(!empty($session)){
	$objCatalogue = new Catalogue();
	foreach($session as $key=>$value){
		$out[$key] = $objCatalogue->getProduct($key);
	}
}

require_once('header.php'); 

?>

<h1 class="titleBasket">Basket</h1>

<?php if(!empty($out)){ ?>
<div id="big_basket">
	<form action="#" method="post" id="frm_basket" onSubmit="return false;">
	<table cellpadding="0" cellspacing="0" border="0" class="tbl_repeat">
		<tr>
			<th>Item</th>
			<th class="ta_r">Qty</th>
			<th class="ta_r col_15">Price</th>
			<th class="ta_r col_15">Remove</th>
		</tr>
		<?php foreach($out as $item) { ?>
		
			<tr class="item_basket">
				<td><a href="?page=catalogue-item&category=<?php echo $item->category; ?>&id=<?php echo $item->id; ?>" data-product-id="<?php echo $item->id; ?>" class="basket_view"><?php echo Helper::encodeHTML($item->name); ?></a></td>
				<td><input type="text" name ="qty-<?php echo $item->id; ?>" 
					id="qty-<?php echo $item->id; ?>" class="fld_qty"
					value="<?php echo $session[$item->id]['qty']; ?>" autocomplete="off" /></td>
				<td class="ta_r">&dollar;<?php echo number_format($objBasket->itemTotal($item->price, 
								$session[$item->id]['qty']), 2); ?></td>
				<td class="ta_r"><?php echo Basket::removeButton($item->id); ?></td>
			</tr>
		
		
		<?php } ?>
		
		<?php if($objBasket->_vat_rate != 0){ ?>
		
		<tr>
			<td colspan="2" class="br_td">Sub-total:</td>
			<td class="ta_r br_td">&dollar;<?php echo number_format($objBasket->_sub_total, 2); ?></td>
			<td class="ta_r br_td">&#160;</td>
		</tr>
		<tr>
			<td colspan="2" class="br_td">TAX (<?php echo $objBasket->_vat_rate; ?>%):</td>
			<td class="ta_r br_td">&dollar;<?php echo number_format($objBasket->_vat, 2); ?></td>
			<td class="ta_r br_td">&#160;</td>
		</tr>
		
		<?php }?>
		
		<tr>
			<td colspan="2" class="br_td"><strong>Total:</strong></td>
			<td class="ta_r br_td"><strong>&dollar;<?php echo number_format($objBasket->_total, 2); ?></strong></td>
			<td class="ta_r br_td">&#160;</td>
		</tr>
	</table>
	
	<div class="dev br_td basket_dash">&#160;</div>
	
	<div class="sbm sbm_blue fl_r">
		<a href="?page=checkout" class="btn" onclick="checkInput(this);">Checkout</a>
	</div>
	<div class="sbm sbm_blue fl_l update_basket">
		<span class="btn">Update</span>
	</div>
	</form>
</div>
<?php } else { ?>

<p id="emptyBascket">Your basket is currently empty.</p>
<div id="big_basket"></div>

<?php }?>
<?php require_once('footer.php'); ?>