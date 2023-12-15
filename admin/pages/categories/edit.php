<?php 
$id = Url::getParam('id');
$imgdel = Url::getParam('imgdel');

if(!empty($id)){

	$objCatalogue = new Catalogue();
	$category = $objCatalogue->getCategory($id);

	if(!empty($category)){
		

		$objForm = new Form();
		$objValid = new Validation($objForm);
		
		if(!empty($imgdel) && is_file(MENU_PATH_IMAGE.DS.$imgdel)){
				
			unlink(MENU_PATH_IMAGE.DS.$imgdel);
				$objCatalogue->removeImageCategory(array('imageCategorie' => null), $id);
			Helper::redirect(Url::getCurrentUrl(array('action', 'id')).'&action=edited');
				
		}


			if($objForm->isPost('name')){
			
				$objValid->_expected= array('name');
				$objValid->_required= array('name');
				
				$name = $objForm->getPost('name');
				
				if($objCatalogue->duplicateCategory($name, $id)){
						$objValid->add2Errors('name_duplicate');
				}
				
				if($objValid->isValid()){
						
					if($objCatalogue->updateCategory($name, $id)){
						
						if(Input::get('image')['size'] > 0 ){
							
							$cat = $objCatalogue->getCategory($id);
							
							$objCatalogue->removeImageForCategory($cat->imageCategorie);
							
							$objUpload = new Upload();
							
							if($objUpload->upload(MENU_PATH_IMAGE, $name)){
							
								$objCatalogue->addImageToCategory($objUpload->_names[0], $id);
								Helper::redirect(Url::getCurrentUrl(array('action', 'id')).'&action=edited');
				
							}
							
						}else{
				
							Helper::redirect(Url::getCurrentUrl(array('action', 'id')).'&action=edited-no-upload');
				
						}
						
					}else{
						Helper::redirect(Url::getCurrentUrl(array('action', 'id')).'&action=edited-failed');
					}
				}
			}

		require_once('template/_header.php'); 
		?>

		<h1>Categories &#8667; <span class="marker">Edit</span></h1>

		<form action="" method="post" enctype="multipart/form-data">
			<table cellpadding="0" cellspacing="0" border="0" class="tbl_insert">
				<tr>
					<th><label for="name">Name: *</label></th>
					<td>
						<?php 
							echo $objValid->validate('name'); 
							echo $objValid->validate('name_duplicate'); 
						?>
						<input type="text" name="name" id="name" value="<?php echo $objForm->stickyText('name', $category->name);?>" class="fld">
					</td>
				</tr>
						
						<?php
							if($category->parent == 0)
							{
						?>
				<tr>
					<th><label for="image">New image:</label></th>
					<td> 
						<input type="file" name="image" id="image" size="30" />
					</td>
				</tr>
					<?php 
						if(!empty($category->imageCategorie) && is_file(MENU_PATH_IMAGE.DS.$category->imageCategorie)){
					?>
				<tr>
					<th><label for="image">Label category:</label></th>
					<td>
						<?php
								echo "<div class=\"fs_imag\"><ul class=\"lstIcon\" id=\"label_category\">";
								
									
									$widthMarginSmall = Helper::getWidthAndMargin(
													Helper::getImgSize(MENU_PATH_IMAGE.DS.$category->imageCategorie, 1),
													Helper::getImgSize(MENU_PATH_IMAGE.DS.$category->imageCategorie, 0),
													Helper::getImgSize(MENU_PATH_IMAGE.DS.$category->imageCategorie, 0),
													90
													);
									echo "<li class=\"smallImage\"><img src=\"../media/menu/{$category->imageCategorie}\" alt=\"";
									echo Helper::encodeHTML($category->name, 1);
									echo "\" width=\"{$widthMarginSmall[0]}\"  style=\"margin-top:5px;margin-bottom:10px;\"/>";
									echo "<a href='?page=categories&action=edit&id=".$id."&imgdel=".$category->imageCategorie."'>Delete</a>";
									echo "</li>";
								
								echo "</ul></div>";
						
						?>
					</td>
				</tr>
						<?php
								}
							}
						?>
				<tr>
					<th>&nbsp;</th>
					<td>
						<label for="btn" class="sbm sbm_blue fl_l">
							<input type="submit" id="btn" class="btn" value="Update">
						</label>
						<div class="sbm sbm_blue bt_center">
							<a href="?page=categories&action=addsubcategory&id=<?php echo $category->id;?>" class="btn" id="local">Add subcategory</a>
						</div>
					</td>
				</tr>
				
				
			</table>
		</form>

		<?php 
		require_once('template/_footer.php'); 
	} 
}
?>