<?php 

/*****
 **
 ** Author: Kevin J Brosnahan
 ** Date: October 15, 2019
 **
 ** Class ValueChanged
 ** Function: ValueDidChange() - Compares 2 values in a loop and detects when the values change.
 ** Returns: True/False
 **
 ** Function: ToggleValues() - Returns alternating values. Can be used separately or in conjunction with ValueDidChange()
 ** Returns: 1 of 2 given values
 **
 ****/

 if(!class_exists('ValueChanged')){
  class ValueChanged{
      var $today;
      private $firstValue='';
      private $newValue='';
      private $toggleValue1="";
      private $toggleValue2="";

      function __construct( ){
          $this->today = date( 'Y-m-d' );
      }

      public function set_firstValue( $newFirstValue ){
        $this->firstValue = $newFirstValue;
      }

      public function get_firstValue(){
        return $this->firstValue;
      }

      public function set_toggleValue1( $tv1 ){
        $this->toggleValue1 = $tv1;
      }

      public function set_toggleValue2( $tv2 ){
        $this->toggleValue2 = $tv2;
      }

      public function set_newValue( $newNewValue ){
        $this->newValue = $newNewValue;
      }

      public function get_newValue(){
          return $this->newValue;
      }

      public function ToggleValues(){
        $tempValue = $this->toggleValue1;
        $this->toggleValue1 = $this->toggleValue2;
        $this->toggleValue2 = $tempValue;
        return $this->toggleValue2;
      }

      public function ValueDidChange(){
        if ( $this->firstValue == $this->newValue ){
              return false;
        }
        else{
            $this->firstValue = $this->newValue;
            return true;
        } 
      }

  }
};
?>