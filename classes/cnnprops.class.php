<?php
/**
 *
 * class ConnectionProperties
 *    Connection properties needed to access several MySQL databases.
 *
 *    Author: Kevin J Brosnahan
 *    Date: July 2019
 */
if(!class_exists('ConnectionProperties')){
	class ConnectionProperties{
		var $servername;
		var $username;
		var $password;
		var $dbname;

		function __construct(){
			$args = func_get_args(); 
			$num_args = func_num_args();

			/*
			$this->dbname = 'supersearchdb';
			$this->servername = 'localhost';
			$this->username = 'nikasweetie';
			$this->password = 'ismellskunk';
			*/
				
			/**/
			$this->dbname = 'supersearchdb';
			$this->servername = 'localhost';
			$this->username = 'root';
			$this->password = '';
				
		}
	}
}
?>