<?php 
if(!class_exists('DataFormatConstants')){
	class DataFormatConstants {
	var $today;

    	function __construct() {
    		$this->today = date( 'Y-m-d' );
    	}
    	
    	public static function initializeConstants(){
  	 	 	define ("_NON_INDEXED_ARRAY", 0);
		 	define ("_INDEXED_ARRAY", 1);
	 		define ("_DATA_RETURN_ARRAY", 2);
	 		define ("_DATA_RETURN_JAVASCRIPT_JSON_STRING", 3);
	 		define ("_DATA_RETURN_JAVASCRIPT_ARRAY", 4);
	 		define ("_DATA_RETURN_JSON", 5);
		 	define ("_DATA_RETURN_STRING", 6);
			define ("_DATA_RETURN_HTML", 7);
			define ("_DATA_RETURN_CSV", 8);
			define ("_DATA_RETURN_PDF", 9);
			define ("_DATA_RETURN_TSV", 10);
			
			define("_PHP_TAB1", "\t");
			define("_PHP_SPC4", "    ");
    	}
		
		static function getConstants() {
			$oClass = new ReflectionClass(__CLASS__);
			return $oClass->getConstants();
		}
		
	 }
}

?>