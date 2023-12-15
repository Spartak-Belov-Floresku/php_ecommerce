<?php

class Dbase{

		private static $_instance = null;

		private $_host = "localhost",
				$_user = "Qecommerce",
				$_password = "5sPy3*p",
				$_name = "qecommerce",
				$_results = null,
				$_count = null,
				$_query = null,
				$_conndb = false;
				
		public $_last_query = null,
			   $_affected_rows = 0,
			   $_insert_keys = array(),
			   $_insert_values = array(),
			   $_update_sets = array(),
			   $_id,
			   $_error = false;

			   

			private function __construct(){
			    try{
					$this->_conndb = new PDO('mysql:host='.$this->_host.';dbname='.$this->_name,$this->_user,$this->_password); 
				}catch(PDOException $e){
					$message  = "<h1 style=\"font-size:350%;color:red;text-align:center;padding-top:5%;\">The database of website temporarily is not available...</h1>"; 
					//die($e->getMessage());
					die($message);
				} 				
			}

			

			public static function getInstance(){
				if(!isset(self::$_instance)){
					self::$_instance = new Dbase();
				}
				return self::$_instance;
			}

			

			public function close(){
				$this->_query->closeCursor();
			}
			
			public function escape($value){
				return htmlentities($value,ENT_QUOTES,'UTF-8');
			}
		
			public function query($sql,$params = array()){
				$this->_error = false;
				if($this->_query = $this->_conndb->prepare($sql)){
					
					$x=1;
					if(count($params)){
						foreach($params as $param){
							$this->_query->bindValue($x,$param);
							$x++;
						}
					}
					if($this->_query->execute()){
						$this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);// fetchAll() is method PDO, (PDO::FETCH_OBJ)//return object
						$this->_count = $this->_query->rowCount();// method PDO
						$this->close();
					}else{
						// Error request DB
						print_r($this->_query->errorInfo());
						$message  = "<h1 style=\"font-size:350%;color:red;text-align:center;padding-top:5%;\">Website temporarily not available.</h1>"; 
						die($message);
					}
				}
				return $this;	
			}
			

			public function prepareInsert($array = null){
				if(!empty($array)){
					foreach($array as $key => $value){
						$this->_insert_keys[]  = $key;
						$this->_insert_values[] = $this->escape($value);
					}
				}
			}
			
			public function insert($table){
				if(!empty($table) && !empty($this->_insert_keys) && !empty($this->_insert_values)){
					$values = '';
					$i=1;
					foreach ($this->_insert_values as $field){
						$values .='?';
						if($i<count($this->_insert_values)){
							$values .=',';
						}
						$i++;
					}
					$sql = "INSERT INTO {$table}(`".implode('`, `', $this->_insert_keys)."`) VALUES({$values})";
					if(!$this->query($sql, $this->_insert_values)->_error){
						//last inser id
						$this->_id = $this->_conndb->lastInsertId();
						
						$this->_insert_keys   = array();
						$this->_insert_values = array();
						
						return true;
					}
					return false;
				}
				return false;
			}
			
			public function update($table = null, $id = null){
				if(!empty($table) && !empty($id) && !empty($this->_insert_keys) && !empty($this->_insert_values)){
					$values = '';
						$i=1;
						foreach ($this->_insert_keys as $field){
							$values .= "{$field} = ?";
							if($i<count($this->_insert_keys)){
								$values .=', ';
							}
							$i++;
						}
					$sql  = "UPDATE `{$table}` SET ";
					$sql .= $values;
					$sql .= " WHERE id = ".IntegerFilter::filter($id)."";
					return !$this->query($sql, $this->_insert_values)->_error ? true: false;
				}
			}

			// allows to perform specific operation using the query method
		
			public function action($action,$table,$where = array()){
				if(count($where)===3){
					$operators = array('=','>','<','>=','<=');
					
					$field 		= $where[0];
					$operator 	= $where[1];
					$value 		= $where[2];
					
					if(in_array($operator, $operators)){
						$sql = "{$action} FROM {$table} WHERE {$field} {$operator} ?";
						if(!$this->query($sql,array($value))->_error){
							return $this;
						}
					}
				}
				return false;
			
			}
			public function delete($table, $where){
				return $this->action('DELETE',$table, $where);
			}
			

			public function results(){
				if($this->count_() != 0)
					return $this->_results;
				else 
					return null;
			}

			public function first(){
			if($this->count_() != 0){
					return $this->results()[0];
			}else{ 
					return null;			
			}}

			public function count_(){
				return $this->_count;
			}
			
			public function lastId(){
				return $this->_id;
			}

}

?>