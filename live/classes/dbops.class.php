<?php
if(!class_exists('clsDBOps')){
	class clsDBOps{
		
		//var $retval;
		var $today;
		public $queryType='';
		public $mp = 'npa8WsqCpN7';
		
		function __construct(){
			$this->today = date( 'Y-m-d' );
			$this->mp = "npa8WsqCpN7";
			//$this->retval = array('status'=>'notOK', 'msg'=>'', 'kev'=>'hey there','record_set'=>array(), 'insert_id'=>0, 'affected_rows'=>0);
		}		
		




		










		public function ExecuteInsertQuery( $cnnprops, $sqlInsert ){ // returns array of settings
			$retval = new clsRetval();
			$obj_query			= '';
			$obj_conn			= '';
			
			mysqli_report(MYSQLI_REPORT_STRICT); 
			
			// Create connection
			try{
				//$obj_conn = new mysqli("localhost","root","","sweetsDB");
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
		
		
		public function AddNarrative( $cnnprops, $user_id, $readings_id, $narrative, $action, $narration_id, $user_ref ){
			$retval = new clsRetval();
			$clsDBOps = new clsDBOps();
			$retvalReadingExists = new clsRetval();
			$retvalNarrationAlreadyExists = new clsRetval();
			
			
			
			
			
			// Validate user before anything!
			$retval = $this->ExecuteSelectQuery( $cnnprops, "SELECT ID FROM users WHERE user_hash='".$user_ref ."';" );
			if($retval->retval['status']=='OK'){
					//=@#%&*()-_ ]*$
					$narrative = $this->strip_quotes( $narrative, array( "<", ">", "`", "{", "}", "@", "(", ")", "//", "&", "=", "?", "+", ":", "[", "]", "$", "|" ) ); // Strips out single and double quotes + optional others
					
					if(strlen($narrative)>0){
						if($action=='Add'){
							$retvalReadingExists = $this->ExecuteSelectQuery( $cnnprops, "SELECT readings_id FROM readings WHERE readings_id=".$readings_id ); // 1. IS READING_ID BEING SUBMITTED AVAILABLE IN READINGS TABLE?
							$retvalNarrationAlreadyExists = $this->ExecuteSelectQuery( $cnnprops, "SELECT `narration_id`, `narration` FROM `reading_narrations` WHERE readings_id=".$readings_id.";");  // 2. DOES NARRATION ALREADY EXIST IN NARRATION TABLE?
							
							if($retvalReadingExists->retval['status'] == 'OK') // Yes. Valid readings_id
							{
								if($retvalNarrationAlreadyExists->retval['status'] == 'OK') // Yes. Narration already exists for this reading so Update it.
								{
									$mySql = "UPDATE `reading_narrations` SET `narration` = CONCAT(`narration`, '".$narrative."'),`last_updated`='".date('Y-m-d H:m:s')."' WHERE readings_id=".$readings_id." AND user_id=".$user_id;
									$retval = $this->ExecuteUpdateQuery( $cnnprops, $mySql );	
										if($retval->retval['affected_rows']==0){
											$retval->retval['msg']='DUPLICATE - Could not update record.';
										}
										else
										{
											$retval->retval['msg']='DUPLICATE - Narrative already existed so it was updated.';
										}
									
								}else { // No. Narration does not exist so we will add it.
									$mySql = "INSERT INTO `reading_narrations`(`created_date`, `readings_id`, `user_id`, `active`, `narration`) VALUES ('".date('Y-m-d H:m:s')."', '".$readings_id."','".$user_id."','1','".$narrative."')";	
									$retval = $this->ExecuteInsertQuery( $cnnprops, $mySql );

									if($retval->retval['status']=='OK'){
										$retval->retval['msg'] = 'Narrative added for your reading.';
									}
								}
							}else {
								$retval->retval['msg']='FATAL ERROR: Reading does not exist for this narrative.';
							}

						}
						
						
						if($action=='Update'){
							$mySql = "UPDATE `reading_narrations` SET `narration`='".$narrative."',`last_updated`='".date('Y-m-d H:m:s')."' WHERE readings_id=".$readings_id." AND narration_id=".$narration_id." AND user_id=".$user_id;
							$retval = $this->ExecuteUpdateQuery( $cnnprops, $mySql );	
							if($retval->retval['affected_rows']==0){
								$retval->retval['msg']='Could not update record.';
							}else{
								$retval->retval['msg']='Narrative was updated.';
							}
						}
						
					}else{
						$retval->retval['msg'] = 'No valid characters were found in Narrative.';
					}



				
			}else{
				$retval->retval['msg'] = 'FATAL ERROR: USER DOES NOT EXIST!';
				$err = new clsErrors();
				$err->AddError( __CLASS__.'->'.__FUNCTION__, __LINE__, 'FATAL ERROR: USER DOES NOT EXIST!', $user_id, $user_ref );
				unset( $err );
			}
			
			
			// Create and update user with new user_hash
			$user = new clsUser();
			$retval->retval['user_ref'] = $user->updateUserRef( $user_id, $user_ref );
			unset( $user );
			
			
			$retval->retval['inserted_narrative'] = $narrative;
			unset ( $cnnprops, $clsDBOps, $retvalReadingExists, $retvalNarrationAlreadyExists );
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