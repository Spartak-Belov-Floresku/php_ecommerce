<?php 
$id = Url::getParam('id');

if(!empty($id)){

	$objOrder = new Order();
	$order = $objOrder->getOrder($id);

	if(!empty($order)){
		

		$objForm = new Form();
		$objValid = new Validation($objForm);
		
		$objUser = new User();
		$user = $objUser->getUser($order->client,"id");
		
		$objStates = new States();
		
		$objCatalogue = new Catalogue();
		
		$items = $objOrder->getOrderItems($id);
		
		$status = $objOrder->getStatuses();

		if($objForm->isPost('status')){
			
			$objValid->_expected= array('status','notes','payment_status');
			$objValid->_required= array('status');
			
			$vars = $objForm->getPostArray($objValid->_expected);
			
			if($objValid->isValid()){
				if($objOrder->updateOrder($id, $vars)){
					
					if(Input::get('payment_status') == "Completed"){
						$objOrder->updateOrder($id, array("pp_status" => 1));
					}else if(Input::get('payment_status') == ""){
						$objOrder->updateOrder($id, array("pp_status" => 0));
					}
					
					if(Input::get('status') != 3){
						$objOrder->updateOrder($id, array("pp_status" => 0, "payment_status" => ""));
					}
					
					Helper::redirect(Url::getCurrentUrl(array('action', 'id')).'&action=edited');
				}else{
					Helper::redirect(Url::getCurrentUrl(array('action', 'id')).'&action=edited-failed');
				}
			}
		}

		require_once('template/_header.php'); 
		?>

		<h1>Orders :: View</h1>

		<form action="" method="post">
			<table cellpadding="0" cellspacing="0" border="0" class="tbl_insert">
				<tr>
					<th>Date:</th>
					<td colspan="4"><?php echo Helper::setDate(2, $order->date); ?></td>
				</tr>
				<tr>
					<th>Order #:</th>
					<td colspan="4"><?php echo $order->id; ?></td>
				</tr>
				
				<?php if(!empty($items)){ ?>
					<tr>
						<th rowspan="<?php echo count($items)+1; ?>">Items:</th>
						<td class="col_5">Id</td>
						<td>Item</td>
						<td class="col_5 ta_r">Qty</td>
						<td class="col_15 ta_r">Amount</td>
					</tr>
					<?php 
						foreach($items as $item){ 
							$product = $objCatalogue->getProduct($item->product);
					?>
						<tr>
							<td><?php echo $product->id; ?></td>
							<td><?php echo Helper::encodeHtml($product->name); ?></td>
							<td class="ta_r"><?php echo $item->qty; ?></td>
							<td class="ta_r">&dollar;<?php echo number_format(($item->price * $item->qty), 2); ?></td>
						</tr>
					<?php } ?>
				<?php } ?>
				
				<tr>
					<th>Sub-total:</th>
					<td colspan="4" class="ta_r">
						&dollar;<?php echo number_format($order->subtotal, 2);?>
					</td>
				</tr>
				<tr>
					<th>TAX (<?php echo $order->vat_rate; ?>%):</th>
					<td colspan="4" class="ta_r">
						&dollar;<?php echo number_format($order->vat, 2);?>
					</td>
				</tr>
				<tr>
					<th>Total:</th>
					<td colspan="4" class="ta_r">
						<strong>&dollar;<?php echo number_format($order->total, 2);?></strong>
					</td>
				</tr>
				<tr>
					<th>Client:</th>
					<td colspan="4">
						<?php
							echo Helper::encodeHtml($user->first_name." ".$user->last_name).'<br>';
							echo Helper::encodeHtml($user->address_1).'<br>';
							echo !empty($user->address_2)? $user->address_2.'<br>': null;
							$state = $objStates->getState($user->state);
							echo Helper::encodeHtml($user->city).', '.Helper::encodeHtml($state->state_abbr).' '.Helper::encodeHtml($user->zip_code).'<br>';
							echo '<a href="mailto:';
							echo $user->email;
							echo '">';
							echo $user->email;
							echo '</a>';
						?>
					</td>
				</tr>
				<tr>
					<th><label for="status">PP status:</label></th>
					<td colspan="4">
						<select name="payment_status" id="ppstatus" class="sel">
							<option value="" <?php if($order->payment_status != "Completed") echo "selected =\"selected\""; ?>>Pending</option>
							<option value="Completed" <?php if( $order->payment_status == "Completed") echo "selected =\"selected\""; ?>>Completed</option>	
						</select>
					</td>
				</tr>
				<tr>
					<th><label for="status">Order status:</label></th>
					<td colspan="4">
						<?php $objValid->validate('status');?>
						<?php if(!empty($status)){ ?>
							<select name="status" id="status" class="sel">
								<?php foreach($status as $stat){ ?>
									<option value="<?php echo $stat->id; ?>"
									<?php echo $objForm->stickySelect('status', $stat->id, $order->status); ?>
									><?php echo Helper::encodeHtml($stat->name); ?></option>
								<?php } ?>
							</select>
						<?php } ?>
					</td>
				</tr>
				<tr>
					<th><label for="notes">Notes:</label></th>
					<td colspan="4">
						<textarea name="notes" id="note" cols="" rows="" class="tar"><?php 
						    echo $objForm->stickyText('notes', $order->notes); 
						?></textarea>
					</td>
				</tr>
				<tr>
					<th>&nbsp;</th>
					<td colspan="4">
						<div class="sbm sbm_blue fl_r">
							<a href="<?php echo Url::getCurrentUrl(array('action')).'&action=invoice'; ?>" class="btn" target="_blank">Invoice</a>
						</div>
						<div class="sbm sbm_blue fl_l mr_r4">
							<a href="<?php echo Url::getCurrentUrl(array('action', 'id')); ?>" class="btn">Go back</a>
						</div>
						<label for="btn_update" class="sbm sbm_blue fl_l">
							<input type="submit" id="btn_update" class="btn" value="Update">
						</label>
					</td>
				</tr>
			</table>
		</form>

		<?php 
		require_once('template/_footer.php'); 
	} 
}
?>