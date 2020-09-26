<?php
if(!class_exists('clsDBOps')){
	class clsDBOps{
		
		//var $retval;
		var $today;
		public $queryType='';
		public $mp = 'PASSWORD_HERE';
		
		function __construct(){
			$this->today = date( 'Y-m-d' );
			$this->mp = "PASSWORD_HERE";
			//$this->retval = array('status'=>'notOK', 'msg'=>'', 'kev'=>'hey there','record_set'=>array(), 'insert_id'=>0, 'affected_rows'=>0);
		}		
		




		










		public function ExecuteInsertQuery( $cnnprops, $sqlInsert ){ // returns array of settings
			$retval = new clsRetval();
			$obj_query			= '';
			$obj_conn			= '';
			
			mysqli_report(MYSQLI_REPORT_STRICT); 
			
			// Create connection
			try{
				$obj_conn = new mysqli( $cnnprops->servername, $cnnprops->username, $cnnprops->password, $cnnprops->dbname);
			}
			catch(mysqli_sql_exception $exConnect)
			{
				$retval->retval['msg'] = "Fatal connection error.";
				return $retval;
			}
			
			
			
			
			// Create connection
			//$obj_conn = new mysqli( $cnnprops->servername, $cnnprops->username, $cnnprops->password, $cnnprops->dbname);
			
			// Check connection
			if ($obj_conn->connect_error) {
				$retval->retval['msg'] = 'Connection failed: ' . $obj_conn->connect_error;
			} 
			
			// Execute sql statement
			if ( $obj_conn->query($sqlInsert) === TRUE ){
				$retval->retval['msg'] = "Record inserted.";
				$retval->retval['status'] = "OK";
				$retval->retval['insert_id'] = $obj_conn->insert_id;
			}else{
				$retval->retval['msg'] = $obj_conn->error;
			}
			$obj_conn->close();
			
			unset($cnnprops, $obj_conn, $obj_query);			
			
			return $retval;
		}

		public function ExecuteUpdateQuery( $cnnprops, $sqlUpdate ){ // returns array of settings
			$retval = new clsRetval();
			$obj_query			= '';
			$obj_conn			= '';
			
			mysqli_report(MYSQLI_REPORT_STRICT); 
			
			// Create connection
			try{
				$obj_conn = new mysqli( $cnnprops->servername, $cnnprops->username, $cnnprops->password, $cnnprops->dbname);
			}
			catch(mysqli_sql_exception $exConnect)
			{
				$retval->retval['msg'] = "Fatal connection error.";
				return $retval;
			}

			// Create connection
//			$obj_conn = new mysqli( $cnnprops->servername, $cnnprops->username, $cnnprops->password, $cnnprops->dbname);
			
			// Check connection
			if ($obj_conn->connect_error) {
				$retval->retval['msg'] = "Connection failed: " . $obj_conn->connect_error;
			} 
			
			// Execute sql statement
			if ( $obj_conn->query($sqlUpdate) === TRUE ){
				$retval->retval['status'] = "OK";
				$retval->retval['affected_rows'] = $obj_conn->affected_rows;
				$retval->retval['msg'] = $retval->retval['affected_rows']." Record(s) Updated.";
			}else{
				$retval->retval['msg'] = $obj_conn->error;
			}
			
			$obj_conn->close();
			
			unset($cnnprops, $obj_conn, $obj_query);			
			
			return $retval;
		}

		public function ExecuteSelectQuery( $cnnprops, $sqlSelect, $includeFieldNames = false, $prettyFieldNames = false){ // returns array of data
			$retval = new clsRetval();
			$obj_query			= '';
			$obj_conn			= '';
			$row				= '';
			$num_rows			= 0;
			$aryFieldNames		= array();
			
			mysqli_report(MYSQLI_REPORT_STRICT); 
			
			// Create connection
			try{
				$obj_conn = new mysqli( $cnnprops->servername, $cnnprops->username, $cnnprops->password, $cnnprops->dbname);
			}
			catch(mysqli_sql_exception $exConnect)
			{
				$retval->retval['msg'] = "Fatal connection error.";
				return $retval;
			}
			
			// Check connection
			if ($obj_conn->connect_error) {
				$retval->retval['msg'] = "Connection failed: " . $obj_conn->connect_error;
			} 
			
			// Execute sql statement
			$obj_query = $obj_conn->query($sqlSelect);
			
			if(is_object($obj_query)){
				$num_rows = $obj_query->num_rows;
				
				if ( $num_rows > 0){
					$retval->retval['msg'] .= $num_rows." Records retrieved.";
					$retval->retval['status'] = "OK";
					$retval->retval['num_rows'] = $num_rows;
					
					while( $row = $obj_query->fetch_array(MYSQLI_ASSOC)){
						$ary_fetched[] = $row;
					}
					
					// Build array to return
					$retval->retval['record_set']= $ary_fetched;				
				}
				
				// Add sql field names to return array
				if($includeFieldNames){
					$finfo = $obj_query->fetch_fields();
					$fct=0;
				
					foreach ($finfo as $val) {
						$aryFieldNames['fields'][$fct] = $val->name;
						$fct++;
					}
				
					$retval->retval['field_names'] = $aryFieldNames;
				}
				
				
				// Make pretty field names out of those returned by sql
				$prettyArray = array();
				if($prettyFieldNames && is_array($retval->retval['field_names'])){
					foreach($retval->retval['field_names']['fields'] as $k=>$v){
						$prettyArray['pretyfields'][$v] = $this->make_pretty_fieldnames($v);
					}
						$retval->retval['pretty_field_names'] = $prettyArray;
				}
				
			}else{
				$retval->retval['msg'] .= $obj_conn->error;
			}
			
			$obj_conn->close();
			
			unset($cnnprops, $obj_conn, $obj_query);			
			
			return $retval;
		}
		
		
		
		private function strip_quotes($strIn,$aryMoreToStrip=false){
			$strIn = str_replace("'","",$strIn);
			$strIn = str_replace('"',"",$strIn);
			if(is_array($aryMoreToStrip)){
				foreach($aryMoreToStrip as $symbol){
					$strIn = str_replace($symbol,"",$strIn);
				}
			}
			return $strIn;
		}
		
		private function make_pretty_fieldnames($strIn){
			$strIn = str_replace("_"," ",$strIn);
			return ucwords(strToLower($strIn));
		}
}
}
