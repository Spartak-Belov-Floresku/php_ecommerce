<?php 
$objForm = new Form();
$objValid = new Validation($objForm);

if($objForm->isPost('name')){
	
	$objValid->_expected= array('name');
	$objValid->_required= array('name');
	
	$objCatalogue = new Catalogue();
	
	$name = $objForm->getPost('name');
	
	if($objCatalogue->duplicateCategory($name)){
		$objValid->add2Errors('name_duplicate');
	}
	
	
	if($objValid->isValid()){
		
		if($objCatalogue->addCategory($name)){
			
			$objUpload = new Upload();
			
			if($objUpload->upload(MENU_PATH_IMAGE, $name)){
				
				$objCatalogue->addImageToCategory($objUpload->_names[0], $objCatalogue->_id);
				Helper::redirect(Url::getCurrentUrl(array('action', 'id')).'&action=added');
				
			}else{
				
				Helper::redirect(Url::getCurrentUrl(array('action', 'id')).'&action=added-no-upload');
				
			}

		}else{
			Helper::redirect(Url::getCurrentUrl(array('action', 'id')).'&action=added-failed');
		}
	}
}

require_once('template/_header.php'); 
?>

<h1>Categories &#8667; <span class="marker">Add</span></h1>

<form action="" method="post" enctype="multipart/form-data">
	<table cellpadding="0" cellspacing="0" border="0" class="tbl_insert">
		<tr>
			<th><label for="name">Name: *</label></th>
			<td>
				<?php 
					echo $objValid->validate('name'); 
					echo $objValid->validate('name_duplicate');
				?>
				<input type="text" name="name" id="name" value="<?php echo $objForm->stickyText('name');?>" class="fld">

			</td>
		</tr>
		<tr>
			<th><label for="image">Image:</label></th>
			<td> 
				<input type="file" name="image" id="image" size="30" />
			</td>
		</tr>
		
		<tr>
			<th>&nbsp;</th>
			<td>
				<label for="btn" class="sbm sbm_blue fl_l">
					<input type="submit" id="btn" class="btn" value="Add">
				</label>
			</td>
		</tr>
	</table>
</form>

<?php require_once('template/_footer.php'); ?>