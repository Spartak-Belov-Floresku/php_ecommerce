<?php 
$id = Url::getParam('id');
$imgdel = Url::getParam('imgdel');

if(!empty($id)){

	$objCatalogue = new Catalogue();
	$product = $objCatalogue->getProduct($id);

	if(!empty($product)){
		

		$objForm = new Form();
		$objValid = new Validation($objForm);
		$categories = $objCatalogue->getCategories();

		$images = !empty($product->image)?Helper::getImages($product->image):array();
		$images = Helper::filterIfImageExists($images, CATALOGUE_PATH.DS, $id);
		
		if(!empty($imgdel) && is_file(CATALOGUE_PATH.DS.$imgdel)){
				
				unlink(CATALOGUE_PATH.DS.$imgdel);
					$key = array_search($imgdel,$images);
						unset($images[$key]);
							$images2 = array_values($images);
					$stringImg = implode("/",$images2);
				$objCatalogue->updateProduct(array('image'=>$stringImg), $id);
			Helper::redirect(Url::getCurrentUrl(array('action', 'id')).'&action=edited');
				
		}
		
		if($objForm->isPost('name')){
			$objValid->_expected= array(
				'category',
				'name',
				'description',
				'price'
			);
			
			$objValid->_required= array(
				'category',
				'name',
				'description',
				'price'
			);
			
			if($objValid->isValid()){
				
				if($objCatalogue->updateProduct($objValid->_post, $id)){
					
					$objUpload = new Upload();
					
					if($objUpload->upload(CATALOGUE_PATH, $product->name)){
						
							array_push($images,$objUpload->_names[0]);
								$stringImg = implode("/",$images);
								
									$objCatalogue->updateProduct(array('image'=>$stringImg), $id);
							Helper::redirect(Url::getCurrentUrl(array('action', 'id')).'&action=edited');
						
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

		<h1>Product &#8667; <span class="marker">Edit</span></h1>

		<form action="" method="post" enctype="multipart/form-data">
			<table cellpadding="0" cellspacing="0" border="0" class="tbl_insert">
				<tr>
					<th><label for="category">Category: *</label></th>
					<td>
						<?php echo $objValid->validate('category'); ?>
						<select name="category" id="category" class="sel">
							<option value="">Select one&hellip;</option>
							<?php if(!empty($categories)){ ?>
								<?php foreach($categories as $cat){ ?>
									<option value="<?php echo $cat->id; ?>" 
										<?php echo $objForm->stickySelect('category', $cat->id, $product->category); ?>>
										<?php echo Helper::encodeHtml($cat->name); ?>
									</option>
								<?php } ?>
							<?php } ?>
						</select>
					</td>
				</tr>
				<tr>
					<th><label for="name">Name: *</label></th>
					<td>
						<?php echo $objValid->validate('name'); ?>
						<input type="text" name="name" id="name" value="<?php echo $objForm->stickyText('name', $product->name);?>" class="fld">
					</td>
				</tr>
				<tr>
					<th><label for="description">Description: *</label></th>
					<td>
						<?php echo $objValid->validate('description'); ?>
						<textarea name="description" id="description" cols="" rows="" class="tar_fixed"><?php echo $objForm->stickyText('description', $product->description);?></textarea>
					</td>
				</tr>
				<tr>
					<th><label for="price">Price: *</label></th>
					<td>
						<?php echo $objValid->validate('price'); ?>
						<input type="text" name="price" id="price" value="<?php echo $objForm->stickyText('Price', $product->price);?>" class="fld_price">
					</td>
				</tr>
				<tr>
					<th><label for="image">Add image:</label></th>
					<td>
						<?php echo $objValid->validate('image'); ?>
						<input type="file" name="image" id="image" size="30" />
					</td>
				</tr>
				<?php if(count($images) != 0){ ?>
				<tr>
					<th><label for="image">Images:</label></th>
					<td>
						<?php
							if(count($images) > 4){
								echo "<div id='goLeftMini'></div>";
							}
							echo "<div class=\"fs_imag\"><ul class=\"lstIcon\">";
							for($i=0;$i<count($images);$i++){
								
								
								$widthMarginSmall = Helper::getWidthAndMargin(
												Helper::getImgSize(CATALOGUE_PATH.DS.$images[$i], 1),
												Helper::getImgSize(CATALOGUE_PATH.DS.$images[$i], 0),
												Helper::getImgSize(CATALOGUE_PATH.DS.$images[$i], 0),
												90
												);
								echo "<li class=\"smallImage\"><img src=\"../media/catalogue/{$images[$i]}\" alt=\"";
								echo Helper::encodeHTML($product->name, 1);
								echo "\" width=\"{$widthMarginSmall[0]}\"  style=\"margin-top:5px;margin-bottom:10px;\"/>";
								echo "<a href='?page=products&action=edit&id=".$id."&imgdel=".$images[$i]."'>Delete</a>";
								echo "</li>";
							}
							echo "</ul></div>";
							if(count($images) > 4){
								echo "<div id='goRightMini' onclick='goRightOrLeft(this)' class='putArrow'></div>";
							}
						
						?>
					</td>
				</tr>
				<script type="text/javascript">widthlstIcon();</script>
				<?php } ?>
				<tr>
					<th>&nbsp;</th>
					<td>
						<label for="btn" class="sbm sbm_blue fl_l">
							<input type="submit" id="btn" class="btn" value="Update">
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