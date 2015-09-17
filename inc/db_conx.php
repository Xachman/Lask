<?php

$db_conx = mysqli_connect(
	HOST,//host
	USER,//user
	PASS,//pass
	DB//DB name
	);
//var_dump($db_conx);
if(mysqli_connect_errno()){
	echo mysqli_connect_error();
	echo ":-(";
	exit();
}

if(!class_exists('Db')){
	class Db {
		public $conx;
		public $debug = true;
		public function __construct() {
	        $arguments = func_get_args();

	        if(!empty($arguments))
	            foreach($arguments[0] as $key => $property)
	                if(property_exists($this, $key))
	                    $this->{$key} = $property;

	        $this->sanitizeData();

	    }

		public function select_row($sqlstr) {
			$sql = $sqlstr;
			$query = mysqli_query($this->conx, $sql);
			if($this->debug && mysqli_error ($this->conx)){
				echo mysqli_error($this->conx);
			}
			return mysqli_fetch_row($query);
		}
		public function insert_row($sqlstr) {
			$sql = $sqlstr;
			mysqli_query($this->conx, $sql);
			return mysqli_insert_id($this->conx);
		}
		public function resultsToArray($query) {
			$rows = array();
			while($row = mysqli_fetch_assoc($query)) {
				$rows[] = $row;
			}
			return $rows;
		}
		private function sanitizeData() {
			if(isset($_POST['i'])) {
				foreach ($_POST['i'] as $key => $val) {
					$key = preg_replace('#[^a-zA-Z-_]#', '', $key);
					$this->post['i_'.$key] = preg_replace('#[^0-9]#', '', $val);
				}
			}
			if(isset($_POST['s'])) {
				foreach ($_POST['s'] as $key => $val) {
					$key = preg_replace('#[^a-zA-Z-_]#', '', $key);
					$this->post['s_'.$key] = preg_replace('#[^a-zA-Z0-9-_ ]#', '', $val);
				}
			}
			if(isset($_POST['t'])) {
				foreach ($_POST['t'] as $key => $val) {
					$key = preg_replace('#[^a-zA-Z-_]#', '', $key);
					$this->post['t_'.$key] = mysqli_real_escape_string($this->conx, $val);
				}
			}
			if(isset($_POST['d'])) {
				foreach ($_POST['d'] as $key => $val) {
					$key = preg_replace('#[^a-zA-Z-_]#', '', $key);
					//$val = strtotime($val);
					$this->post['d_'.$key] = strtotime($val);
					if(!$this->post['d_'.$key]) $this->post['d_'.$key] = '0';
					// var_dump($this->post['d_'.$key]);
					// exit();
					//if($this->post['d_'.$key])
				}
			}
		}
		public function select_rows( $sqlstr ) {
			$sql = $sqlstr ;
			$query = mysqli_query($this->conx, $sql);
			return $this->resultsToArray($query);
		}
		public function query_row( $sqlstr ) {
			$sql = $sqlstr ;
			$query = mysqli_query($this->conx, $sql);
			if($this->debug && mysqli_error ($this->conx)){
				echo mysqli_error($this->conx);
			}
			return mysqli_affected_rows($this->conx);
		}
		public function return_query($sql){
			return mysqli_query($this->conx, $sql);
		}
		public function escape($str) {
			return mysqli_real_escape_string($this->conx, $str);
		}
		public function tableExists($table) {
		    $res = $this->return_query("SELECT 1 FROM `$table`");
		    if(isset($res->field_count)) {
		        return $res->field_count > 0 ? true : false;
		    } else return false;
		}

	}
	$db = new Db(array('conx'=>$db_conx));
}
