<?php
class Paging{
	
	private $_records, 
			$_max_pp, 
			$_numb_of_pages, 
			$_current, 
			$_numb_of_records, 
			$_offcet = 0;
	public static $_key ='pg';
	public $_url;
	
	public function __construct($rows, $max = 5){
		$this->_records = $rows;
		$this->_numb_of_records = count($this->_records);
		$this->_max_pp = $max;
		$this->_url = Url::getCurrentUrl(self::$_key);
		$current = Url::getParam(self::$_key);
		$this->_current = !empty($current) ? $current:1;
		$this->numberOfPages();
		$this->getOffset();
	}
	
	private function numberOfPages(){
		$this->_numb_of_pages=ceil($this->_numb_of_records/ $this->_max_pp);
	}
	
	private function getOffset(){
		$this->_offset = ($this->_current - 1)*$this->_max_pp;
	}
	
	public function getRecords(){//products to page
		$out = array();
		if($this->_numb_of_pages > 1){
			$last = ($this->_offset + $this->_max_pp);
			for ($i = $this->_offset; $i < $last; $i++){
				if($i < $this->_numb_of_records){
					$out[] = $this->_records[$i];
				}
			}
		}else{
			$out = $this->_records;
		}
		return $out;
	}
	
	private function getLinks(){
		if($this->_numb_of_pages > 1){
			$out = array();
			
			//first link
			
			if($this->_current > 1){
				$out[] = "<a href=\"".$this->_url."\">First</a>";
			}else{
				$out[] = "<span>First</span>";
			}
			
			// previous link
			
			if($this->_current > 1){
				
				//previous page number
				
				$id = ($this->_current - 1);
				
				$url = $id > 1 ? $this->_url."&amp;".self::$_key."=".$id : $this->_url;
				$out[] = "<a href=\"{$url}\">Previous</a>";
			}else{
				
				$out[] = "<span>Previous</span>";
				
			}
			
			//next link
			
			if($this->_current != $this->_numb_of_pages){
				
				//next page numer
				$id=($this->_current + 1);
				
				$url = $this->_url."&amp;".self::$_key."=".$id;
				$out[] = "<a href=\"{$url}\">Next</a>";
			}else{
				$out[] = "<span>Next</span>";
			}
			
			//last link
			
			if($this->_current != $this->_numb_of_pages){
				$url = $this->_url."&amp;".self::$_key."=".$this->_numb_of_pages;
				$out[] = "<a href=\"{$url}\">Last</a>";
				
			}else{
				$out[] = "<span>Last</span>";
			}
			return "<li>".implode("</li><li>",$out)."</li>";
		}
	}
	
	public function getPaging(){
		$links = $this->getLinks();
		if(!empty($links)){
			$out = "<ul class=\"paging\">";
			$out .= $links;
			$out .= "</ul>";
			echo $out;
		}
	}
	
	public function currentPosition($num, $totalRows){
		$currentPositions  =  $num * $this->_current;
	    $end = $currentPositions > $totalRows? $totalRows: $currentPositions;
		
		$start = $end - $num + 1;
		
		if($end == $totalRows)
			$start = ($num*ceil($totalRows/$num)) - $num + 1;
		
		echo '<p class="amountPositions">'.$start.'-'.$end.' of '.$totalRows.'</p>';
	}
	
	public function getRifrences($num, $totalRows){
		$ref = "<div class='pages'><ul id='refLink'>";
		$totalPages  = ceil($totalRows/$num);
		$i = $this->_current;
		$j = $i==1?-1:0;
		$c = $totalPages>2? 2 : 1;
		$arrowRight = "";
		
		if($i != 1)
		{
				$url = $this->_url."&amp;".self::$_key."=".($i - 1);
				$ref .= "<li><a href=".$url." class='arrow Left' title='Previous'></a></li>";
				$ref .= "<li><a href=".$url.">". ($i-1) ."</a></li>";
		}
		
		while( $j < $c)
		{
			
			if($this->_current == $i)
			{
				$ref .= "<li><a class='currentPage'>".$i."</a></li>";
				$i++;
				$j++;
				$url = $this->_url."&amp;".self::$_key."=".($i);
				$arrowRight = "<li><a href=".$url." class='arrow Right' title='Next'></a></li>";
				continue;
			}
				if($totalPages == $this->_current)
				{
						break;
				}	
				
				$url =  $this->_url."&amp;".self::$_key."=".$i;
				$ref .= "<li><a href=".$url.">".$i."</a></li>";
				$i++;
				$j++;
			}
			if($totalPages != $this->_current)
			{
				$ref .= $arrowRight;
			}
			
		$ref .= "</ul></div>";
		echo $ref;
	}
	
	
	
	
	
	public function dropBoxLimitPerPage(){
			$drop = '<div class="limiter"><label id="labelLimit">Show:</label>';
		    if($this->_numb_of_records<=6){
				$drop .= '<select onchange="setLimit(this.value)" title="Result per page" id="limitPerPage" class="disabledLimitPerPage" disabled="disabled">';
			}else{
				$drop .= '<select onchange="setLimit(this.value)" title="Result per page" id="limitPerPage">';
			}
			for($i=6;$i<=18;$i+=6){
				if(Url::limintPerPage() == $i){
					$drop .= '<option value="'.$i.'" selected="selected">'.$i.'</option>';
				}else{
					$drop .= '<option value="'.$i.'">'.$i.'</option>';
				}
				if($this->_numb_of_records<=6){
					break;
				}
				if($this->_numb_of_records<=12 && $i == 12){
					break;
				}
			}
			$drop .="</select></div>";
			echo $drop;
	}
	
	public function bropBoxSortBy(){
		$value = array('position','name','price');
		$drop = '<label>Sort by:</label><select onchange="sortBy(this.value)" title="Sort By" >';
		for($i = 0; $i < count($value); $i++){
			if($value[$i] == Url::orderBy()[0]){
				$drop .= '<option value="'.$value[$i].'" selected="selected">'.$value[$i].'</option>';
			}else{
				$drop .= '<option value="'.$value[$i].'" >'.$value[$i].'</option>';
			}
		}
		$drop .="</select>";
		if(Url::orderBy()[1] == 'ASC'){
			$drop .= '<spam data-input="DESC" id="ASDDESC" onclick="ASEorDESC()" title="Set Descending Direction">&#8659;</spam>';
		}else{
			$drop .= '<spam data-input="ASC" id="ASDDESC" onclick="ASEorDESC()" title="Set Ascending Direction">&#8657;</spam>';
		}
		echo $drop;
	}
	
}
?>