<?php 
if(!class_exists('HtmlObjectConstants')){
	class HtmlObjectConstants {
	var $today;

    	function __construct() {
    		$this->today = date( 'Y-m-d' );
			$this->initializeConstants();
    	}
		
		public static function initializeConstants(){
			define ("__HTML_AS_SELECT", 0);
			define ("__HTML_AS_CHECKBOXES", 1);
			define ("__HTML_AS_RADIOS", 2);
			define ("__HTML_AS_DIV", 3);
			define ("__HTML_AS_SPAN", 4);
		}
		
		static function getConstants() {
			$oClass = new ReflectionClass(__CLASS__);
			return $oClass->getConstants();
		}
		
	 }
}

?>