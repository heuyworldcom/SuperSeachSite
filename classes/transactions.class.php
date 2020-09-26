<?php 
 if(!class_exists('clsTransactions')){
  class clsTransactions{
      var $today;

      function __construct(){
          $this->today = date( 'Y-m-d' );
      }
	  
	  public function CreateTransaction()
	  {
		//INSERT INTO `transactions`(`transaction_id`, `trans_type`, `trans_name`, `trans_key`, `trans_date`, `user_id`, `user_ref`, `active`) VALUES ([value-1],[value-2],[value-3],[value-4],[value-5],[value-6],[value-7],[value-8])
	  }
  }
};
?>
