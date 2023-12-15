<?php 
$objBusiness = new Business();
$business = $objBusiness->getBusiness();
$imgdel = Url::getParam('imgdel');

if (!empty($business)) {

	$objForm = new Form();
	$objValid = new Validation($objForm);
	
	if(!empty($imgdel) && is_file(MENU_PATH_IMAGE.DS.$imgdel)){
		$objBusiness->removeLogo($imgdel);
			$objBusiness->addLogo(array("logocompany" => null));
				Helper::redirect(Url::getCurrentUrl(array('imgdel')).'&action=edited');		
	}
	
	
	if ($objForm->isPost('name')) {
	
		$objValid->_expected = array(
			'name',
			'address',
			'telephone',
			'email',
			'website',
			'vat_rate'
		);
		
		$objValid->_required = array(
			'name',
			'address',
			'telephone',
			'email',
			'vat_rate'
		);
		
		$objValid->_special = array(
			'email' => 'email'
		);
		
		$vars = $objForm->getPostArray($objValid->_expected);
		
		if ($objValid->isValid()) {
			if ($objBusiness->updateBusiness($vars)) {
				
				if(Input::get('logocompany')['size'] > 0 ){
					
					$objBusiness->removeLogo($business->logocompany);					
					$objUpload = new Upload();
							
						if($objUpload->upload(MENU_PATH_IMAGE, $business->name)){
							$objBusiness->addLogo(array("logocompany" => $objUpload->_names[0]));
						}
							
				}
				
				Helper::redirect(Url::getCurrentUrl(array('action', 'id')).'&action=edited');
				
			} else {
				Helper::redirect(Url::getCurrentUrl(array('action', 'id')).'&action=edited-failed');
			}
		}
		
	}
		
	require_once('template/_header.php'); 
?>
	
	<h1>Business</h1>
	
	<form action="" method="post" enctype="multipart/form-data">
		<table cellpadding="0" cellspacing="0" border="0" class="tbl_insert">
			
			<tr>
				<th><label for="name">Name: *</label></th>
				<td>
					<?php echo $objValid->validate('name'); ?>
					<input type="text" name="name"
						id="name" class="fld" 
						value="<?php echo $objForm->stickyText('name', $business->name); ?>" />
				</td>
			</tr>
			
			<tr>
				<th><label for="address">Address: *</label></th>
				<td>
					<?php echo $objValid->validate('address'); ?>
					<textarea name="address" id="address" class="tar" 
						cols="" rows=""><?php echo $objForm->stickyText('address', $business->address); ?></textarea>
				</td>
			</tr>
			
			<tr>
				<th><label for="telephone">Telephone: *</label></th>
				<td>
					<?php echo $objValid->validate('telephone'); ?>
					<input type="text" name="telephone"
						id="telephone" class="fld" 
						value="<?php echo $objForm->stickyText('telephone', $business->telephone); ?>" />
				</td>
			</tr>
			
			<tr>
				<th><label for="email">Email: *</label></th>
				<td>
					<?php echo $objValid->validate('email'); ?>
					<input type="text" name="email"
						id="email" class="fld" 
						value="<?php echo $objForm->stickyText('email', $business->email); ?>" />
				</td>
			</tr>
			
			<tr>
				<th><label for="website">Website:</label></th>
				<td>
					<?php echo $objValid->validate('website'); ?>
					<input type="text" name="website"
						id="website" class="fld" 
						value="<?php echo $objForm->stickyText('website', $business->website); ?>" />
				</td>
			</tr>
			
			<tr>
				<th><label for="vat_rate">TAX: *</label></th>
				<td>
					<?php echo $objValid->validate('vat_rate'); ?>
					<input type="text" name="vat_rate"
						id="vat_rate" class="fld" 
						value="<?php echo $objForm->stickyText('vat_rate', $business->vat_rate); ?>" />
				</td>
			</tr>
			<tr>
					<th><label for="image">New logo:</label></th>
					<td> 
						<input type="file" name="logocompany" id="image" size="30" />
					</td>
			</tr>
			<?php 
				if(!empty($business->logocompany) && is_file(MENU_PATH_IMAGE.DS.$business->logocompany)){
			?>
				<tr>
					<th><label for="image">Logo company:</label></th>
					<td>
						<div class="logocompany">
						<?php
								
							echo "<img src=\"../media/menu/{$business->logocompany}\" alt=\"";
							echo Helper::encodeHTML($business->name, 1)."\"/>";
						
						?>
						<a href="?page=business&imgdel=<?php echo $business->logocompany; ?>" class="deletelogo">Delete Logo</a>
						</div>
						
					</td>
				</tr>
			<?php
				}
			?>
			<tr>
				<th>&nbsp;</th>
				<td>
					<label for="btn" class="sbm sbm_blue fl_l">
					<input type="submit"
						id="btn" class="btn" value="Update" />
					</label>
				</td>
			</tr>
			
		</table>
	</form>

<?php require_once('template/_footer.php'); } ?>