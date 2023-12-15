<?php

final class Catalogue extends Application{

	

	private $_table = 'categories',
			$_table_2 = 'products',
			$_category = array('categories' => array(),'parent_cats' => array());

	public  $_path = 'media/catalogue/',$_id = null;


	public static function Currency($num = 0, $cur = '&dollar;'){

		echo $cur.' '.number_format($num,2);

	} 
	

	

	public function getCategories(){
		$sql ="SELECT* FROM `{$this->_table}` ORDER BY `name` ASC";
			if(!$this->db->query($sql)->_error){
				return  $this->db->results();
			}else{
				die("Something wrong!");
			}
	}
	
	public function createArrayCategories($categories){
		
		foreach($categories as $category){
			
			$this->_category['categories'][$category->id] = $category;
			$this->_category['parent_cats'][$category->parent][] = $category->id;
			
		}
		
	}
	
	public function layOutCategoriesInAdminPanel($parent, $class = "maincategories"){
		
		$html = "";
		if(isset($this->_category['parent_cats'][$parent])){
			
			$html .= '<ul class='.$class.'>';
			
			foreach($this->_category['parent_cats'][$parent] as $cat_id){
				
				if(!isset($this->_category['parent_cats'][$cat_id])){
					$html .= '<li><p><span>'. $this->_category['categories'][$cat_id]->name.'</span>';
					$html .= '<span><a href="?page=categories&amp;action=remove&amp;id='.$this->_category['categories'][$cat_id]->id.'">Remove</a>';
					$html .= '<a href="?page=categories&amp;action=edit&amp;id='.$this->_category['categories'][$cat_id]->id.'">Edit</a></span></p></li>';
				}
				if(isset($this->_category['parent_cats'][$cat_id])){
					$html .= '<li><p><span>'. $this->_category['categories'][$cat_id]->name.'</span>';
					$html .= '<span><a href="?page=categories&amp;action=remove&amp;id='.$this->_category['categories'][$cat_id]->id.'">Remove</a>';
					$html .= '<a href="?page=categories&amp;action=edit&amp;id='.$this->_category['categories'][$cat_id]->id.'">Edit</a></span></p>';
					$html .= $this->layOutCategoriesInAdminPanel($cat_id, $class = "subcategory");
					$html .= '</li>';
				}
				
			}
			$html .= '</ul>';
		}
		
		return $html;
		
	}
	
	public function layOutCategoriesInUser($parent, $class = "maincategories", $classli = "uplevel"){
		
		$html = "";
		$check = 0;
		
		if(isset($this->_category['parent_cats'][$parent])){
			
			if($class != "maincategories")
				$html .= "<ul class=\"".$class."\">";
			
			foreach($this->_category['parent_cats'][$parent] as $cat_id){
				
				if(!isset($this->_category['parent_cats'][$cat_id])){
					
					$html .= "<li class='".$classli."'><a href='?page=catalogue&amp;category=". $this->_category['categories'][$cat_id]->id ."'";
					$html .= Helper::getActive(array('category'=> $this->_category['categories'][$cat_id]->id));
					$html .= ">".Helper::encodeHtml($this->_category['categories'][$cat_id]->name)."</a></li>";
					if($check == 4 && $class != "maincategories"){
						$html .= "<div class='clear'></div>";
						$check = 0;
					}
					
				}
				if(isset($this->_category['parent_cats'][$cat_id])){
					
					$html .= "<li class='".$classli."'>";
					$html .= "<a href='?page=catalogue&amp;category=". $this->_category['categories'][$cat_id]->id ."' ".Helper::getActive(array('category'=> $this->_category['categories'][$cat_id]->id));
					$html .= ">".Helper::encodeHtml($this->_category['categories'][$cat_id]->name)."</a>";
					$html .= $this->layOutCategoriesInUser($cat_id, 'subcategory', 'sublevel');
					$html .= "</li>";
					if($check == 4 && $class != "maincategories"){
						$html .= "<div class='clear'></div>";
						$check = 0;
					}
				}
				$check++;
				
			}
			$html .= '</ul><div class="clear"></div>';
		}
		
							
							
		return $html;
		
	}
	
	public function layOutMobileStyleCategoriesInUser($parent, $class = "", $classli = "firstlevelM", $id = null){
		
		$html = "";
		
		if(isset($this->_category['parent_cats'][$parent])){
			
			if($class != "mainMenuMob")
				$html .= "<ul class=\"".$class."\" id=\"".$id."\">";
			
			foreach($this->_category['parent_cats'][$parent] as $cat_id){
				
				if(!isset($this->_category['parent_cats'][$cat_id])){
					
					$html .= "<li class='".$classli."'><a href='?page=catalogue&amp;category=". $this->_category['categories'][$cat_id]->id ."'";
					$html .= Helper::getActive(array('category'=> $this->_category['categories'][$cat_id]->id));
					$html .= ">".Helper::encodeHtml($this->_category['categories'][$cat_id]->name)."</a></li>";	
				}
				if(isset($this->_category['parent_cats'][$cat_id])){
					
					$html .= "<li class='".$classli."' data-up='".$id."'>";
					$html .= "<a href='?page=catalogue&amp;category=". $this->_category['categories'][$cat_id]->id ."' ".Helper::getActive(array('category'=> $this->_category['categories'][$cat_id]->id));
					$html .= ">".Helper::encodeHtml($this->_category['categories'][$cat_id]->name)."</a><span data-listener data-id='sub_".$cat_id."'></span>";
					$html .= $this->layOutMobileStyleCategoriesInUser($cat_id, 'mobSubcategory mobSubcategoryClose', 'sublevel', "sub_".$cat_id."");
					$html .= "</li>";
				}
				
			}
			$html .= '</ul><div class="clear"></div>';
		}
		
							
							
		return $html;
		
	}

	

	public function getCategory($cat){
		$sql ="SELECT* FROM `{$this->_table}` WHERE id = ?";
			if(!$this->db->query($sql, array($cat))->_error){
				return  $this->db->first();
			}else{
				die("Something wrong!");
			}
	}
	
	public function addCategory($name = null){
		if(!empty($name)){
			$name = $this->db->escape($name);
			$categoryName = array('name' => $name);
			$this->db->prepareInsert($categoryName);
			$out = $this->db->insert($this->_table);
			$this->_id = $this->db->_id;
			return $out;
		}
	}
	
	public function addSubCategory($name = null, $cat){
		if(!empty($name)){
			
			$name = $this->db->escape($name);
			$categoryName = array('name' => $name,'parent' => $cat->id);
			$this->db->prepareInsert($categoryName);
			
			$out = false;
			
			if($this->db->insert($this->_table)){
				
				$lastId = $this->db->lastId();
					$parentPath = $cat->parentPath != 0? $cat->parentPath: $cat->id;
						$path = $parentPath.'/'.$lastId;
						$parentPath = array('parentPath' => $path);
					$this->db->prepareInsert($parentPath);
				$out = $this->db->update('categories',$lastId);
				
			}
			
			return $out;
		}
	}
	
	public function updateCategory($name = null, $id = null){
		if(!empty($name) && !empty($id)){
			$this->db->prepareInsert(array('name' => $name));
			return $this->db->update($this->_table, $id);
		}
		return false;
	}
	
	public function removeImageCategory($image = array(), $id = null){
		if(!empty($image) && !empty($id)){
			$this->db->prepareInsert($image);
			return $this->db->update($this->_table, $id);
		}
		return false;
	}
	
	public function addImageToCategory($name = null, $id = null){
		if(!empty($name) && !empty($id)){
			$this->db->prepareInsert(array('imageCategorie' => $name));
			return $this->db->update($this->_table, $id);
		}
		return false;
	}
	
	public function duplicateCategory($name = null, $id = null){
		if(!empty($name)){
			$sql  = "SELECT * FROM `{$this->_table}`
					WHERE `name` = ?";
			if(!empty($id)){
				$sql .= " AND `id` != ?";
				if(!$this->db->query($sql, array($name,$id))->_error){
					return  $this->db->first();
				}else{
					die("Something wrong!");
				}
			}else{
				if(!$this->db->query($sql, array($name))->_error){
					return  $this->db->first();
				}else{
					die("Something wrong!");
				}
			}
		}
		return false;
	}
	
	public function removeCategory($id = null){
		
		$arrayIdsCat = array();
		
		$sql = "SELECT `id`, `parentPath` FROM ". $this->_table;
		$checkImageAndRemove = "SELECT `parent`,`imageCategorie` FROM ". $this->_table." WHERE id = ?";
		
		if($this->db->query($checkImageAndRemove, array($id))){
			$cat = $this->db->first();
				if($cat->parent == 0){
					$this->removeImageForCategory($cat->imageCategorie);
				}
		}
		
		
		if($this->db->query($sql)){
			$results = $this->db->results();
				if($results != 0){
					$arrayIdsCat = $this->getIdCategoriesForDelete($results, $id);
				}
		}
		
		if(count($arrayIdsCat) != 0){
			$this->deleteImagesForRelatedProductsToCategories($arrayIdsCat);
		}
		
		if(count($arrayIdsCat) != 0){
			for($i = 0; $i < count($arrayIdsCat); $i++){
				$this->db->delete($this->_table, array('id','=',IntegerFilter::filter($arrayIdsCat[$i])));
			}
			$arrayIdsCat = array();
		}
		return false;
	}
	
	private function getIdCategoriesForDelete($categories, $id){
		
		$arrayCategories = array();
		
			foreach($categories as $category){
				
				$parentPathArray = explode("/",$category->parentPath);
				
				if(in_array($id,$parentPathArray)){
						$arrayCategories[] = $category->id;
				}
			}
			$arrayCategories[] = $id;
			
		return $arrayCategories;
		
	}
	
	public function removeImageForCategory($path = null){
		if($path != null){
			if(is_file(MENU_PATH_IMAGE.DS.$path)){
				unlink(MENU_PATH_IMAGE.DS.$path);
			}
		}
	}
	
	private function deleteImagesForRelatedProductsToCategories($arrayIdsCat){
		
		for($i = 0; $i < count($arrayIdsCat); $i++){
			
			$sql ="SELECT `image` FROM `{$this->_table_2}` WHERE `category` = ?";
				
				if($this->db->query($sql, array(IntegerFilter::filter($arrayIdsCat[$i])))){
					
					$result = $this->db->results();
										
					if($result !== null){
						
						for($j = 0; $j < count($result); $j++){
							
							$images = Helper::getImages($result[$j]->image);
							
							if(count($images) != 0){
									
								for($k=0; $k < count($images); $k++){
										
									if(is_file(CATALOGUE_PATH.DS.$images[$k])){
										unlink(CATALOGUE_PATH.DS.$images[$k]);
									}
										
								}
								
							}
							
						}
						
					}
					
				}
		}
		
	}

	public function getProducts($cat, $sort = "id", $by = "ASC"){
		$sort = $sort=="position"?"id":$sort;
		$sort = $this->db->escape($sort);
		$by = $this->db->escape($by);
		$sql ="SELECT* FROM `{$this->_table_2}` WHERE `category` = ? ORDER BY `".$sort."` ".$by."";
			if(!$this->db->query($sql, array($cat))->_error){
				return  $this->db->results();
			}else{
				die("Something wrong!");
			}
	}

	

	public function getProduct($id){
		$sql ="SELECT* FROM `{$this->_table_2}` WHERE `id` = ?";
			if(!$this->db->query($sql, array($id))->_error){
				return  $this->db->first();
			}else{
				return null;
			}
	}
	
	public function getAllProducts($srch = null, $sort = "id", $by = "ASC"){
		$srch1 = null;
		$sql = "SELECT * FROM`{$this->_table_2}`";
		if(!empty($srch)){
			$srch = $this->db->escape($srch);
			$srch1 = '%'.$srch.'%';
			$sql .= "WHERE `name` LIKE ? OR `id` = ? OR `description` LIKE ?";
		}
		$sql .= " ORDER BY `".$sort."` ".$by."";
		if(!$this->db->query($sql, array($srch1,$srch,$srch1))->_error){

				return  $this->db->results();

			}else{

				die("Something wrong!");

			}
		
	}
	
	public function addProduct($params=null){
		if(!empty($params)){
			$params['date'] = Helper::setDate();
			$this->db->prepareInsert($params);
			$out = $this->db->insert($this->_table_2);
			$this->_id = $this->db->_id;
			return $out;
		}
		return false;
	}
	
	public function updateProduct($params = null, $id = null){
		if(!empty($params) && !empty($id)){
			$this->db->prepareInsert($params);
			return $this->db->update($this->_table_2, $id);
		}
	}
	
	public function removeProduct($id){
		if(!empty($id)){
			$product = $this->getProduct($id);
			if(!empty($product)){
				$images = !empty($product->image)?Helper::getImages($product->image):null;
				if(count($images) != null){
					for($i=0;$i<count($images); $i++){
						if(is_file(CATALOGUE_PATH.DS.$images[$i])){
							unlink(CATALOGUE_PATH.DS.$images[$i]);
						}
					}
				}
				return $this->db->delete($this->_table_2, array('id','=',IntegerFilter::filter($id)));
			}
			return false;
		}
		return false;
	}

}



?>