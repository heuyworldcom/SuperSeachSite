<?php 

/**
 *
 * class clsUser
 *    Performs routines that have to do with the site user.
 *
 *    Author: Kevin J Brosnahan
 *    Date: July 2019
 */

if(!class_exists('clsUser')){
	class clsUser {
	var $today;
	var $user_hash;
	var $secret;
	
    	function __construct() {
    		$this->today = date( 'Y-m-d' );
			$this->secret = "nGDhmyzsawm5efc";
    	}
 
 		public function loginUser( $user_name, $password ){

    		$exec = array();
    		$san_email = '';
			$users_hash = '';
    		$cnnprops = new ConnectionProperties();
			$ret = new clsRetval();
			$ret2 = new clsRetval();
			$user_login = hash('ripemd160', $user_name."|n|".$password."|n|nGDhmyzsawm5efc"); // NEVER CHANGE THIS LINE
			$mySql = '';
	    	$san_email = filter_var( $user_name, FILTER_SANITIZE_EMAIL );
			$updateSql = "";
			$err = new clsErrors();
 
			
			if ( filter_var( $san_email, FILTER_VALIDATE_EMAIL ) ) {
				//$mySql = "SELECT ID, user_name AS greeting, num_logins, DATE(last_login) AS last_login FROM users WHERE user_email='".$user_name."' AND user_login='".$user_login."'";
				$mySql = "SELECT ID, user_name AS greeting, num_logins, DATE(last_login) AS last_login FROM users WHERE user_login='".$user_login."'";
				$dbops = new clsDBOps();
				
				$ret = $dbops->ExecuteSelectQuery( $cnnprops, $mySql );

				if( $ret->retval['status']=='OK' ){
					if( $ret->retval['record_set'][0]['ID']>0 ){
						$users_hash = hash('ripemd160', $user_name."|n|".$password."|n|".date('Y-m-d H:m:s'));
						
						$updateSql = "UPDATE users SET user_hash='".$users_hash."', last_login='".date('Y-m-d H:m:s')."', user_login='".$user_login."', num_logins = num_logins + 1 WHERE ID=".$ret->retval['record_set'][0]['ID']." LIMIT 1;";
						$ret2 = $dbops->ExecuteUpdateQuery( $cnnprops, $updateSql );
						if($ret2->retval['status']=='OK'){
							$ret2->retval['msg'] = 'You have successfully logged in.';
							$ret2->retval['user_id'] = $ret->retval['record_set'][0]['ID'];
							$ret2->retval['user_hash'] = $users_hash;
							$rets->retval['user_login']= $user_login;
							$ret2->retval['greeting'] = $ret->retval['record_set'][0]['greeting'];
							$ret2->retval['num_logins'] = $ret->retval['num_logins'];
							$ret2->retval['last_login'] = $ret->retval['last_login'];
						}
					}
				}else{
					$ret2->retval['msg'] = 'Could not login. Passwords are Case Sensative.';
					$err = new clsErrors();
					$err->AddError( __CLASS__.'->'.__FUNCTION__, __LINE__, 'Could not login. Passwords are Case Sensative.', 0, $user_name.'-'.$user_login);
					unset( $err );

				}
			}else
			{
				$err->AddError(__CLASS__.'->'.__FUNCTION__,__LINE__,'SANITIZE EMAIL FAIL',0, $user_name.'-'.$user_login);
				$ret->retval['msg'] = 'Invalid email or password.';
			}

			
			unset( $cnnprops, $dbops, $err );
			
			//$ret2->retval['sql'] = $mySql.' - '.$updateSql;
			
			return $ret2;
		}
		
		public function updateUserRef( $user_id, $user_ref ){
    		$cnnprops = new ConnectionProperties();
			$dbops = new clsDBOps();
			$ret = new clsRetval();
			$users_hash = hash('ripemd160', $user_id."|n|".$user_ref."|n|".date('Y-m-d H:m:s'));
			$mySql = "UPDATE users SET user_hash='".$users_hash."' WHERE ID=".$user_id." AND user_hash='".$user_ref."' LIMIT 1;";
			$ret = $dbops->ExecuteUpdateQuery( $cnnprops, $mySql );
			
			unset( $cnnprops, $dbops );
			
			if( $ret->retval['status']=='OK' ){
				return $users_hash;
			}else{
				return $user_ref;
			}
			
		}
 
	 }
}

?>