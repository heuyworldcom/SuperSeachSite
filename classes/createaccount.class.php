<?php 

// Class CreateAccount - Created On: 2019-12-27 at 07:12:16

 if(!class_exists('CreateAccount')){
  class CreateAccount{
    private $ID;
    private $created_date;
    private $user_name;
    private $user_email;
    private $user_pswd;
    private $user_hash;
    private $last_login;
    private $user_login;
    private $num_logins;
    private $user_class_id;
    private $consent_store_email;
    private $failed_logins;
    private $active;

      function __construct(){
          $this::Initialize();
      } 

      private function Initialize(){
            $this->ID='';
            $this->created_date='';
            $this->user_name='';
            $this->user_email='';
            $this->user_pswd='';
            $this->user_hash='';
            $this->last_login='';
            $this->user_login='';
            $this->num_logins='';
            $this->user_class_id='';
            $this->consent_store_email='';
            $this->failed_logins='';
            $this->active='';
      }

      public function  __destruct() {
      
      }

      
      // ID
      public function set_ID( $m_id ){
            $this->ID = $m_id;
      }
      public function get_ID(){
            return $this->ID;
      }
      
      // created_date
      public function set_created_date( $m_created_date ){
            $this->created_date = $m_created_date;
      }
      public function get_created_date(){
            return $this->created_date;
      }
      
      // user_name
      public function set_user_name( $m_user_name ){
            $this->user_name = $m_user_name;
      }
      public function get_user_name(){
            return $this->user_name;
      }
      
      // user_email
      public function set_user_email( $m_user_email ){
            $this->user_email = $m_user_email;
      }
      public function get_user_email(){
            return $this->user_email;
      }
      
      // user_pswd
      public function set_user_pswd( $m_user_pswd ){
            $this->user_pswd = $m_user_pswd;
      }
      public function get_user_pswd(){
            return $this->user_pswd;
      }
      
      // user_hash
      public function set_user_hash( $m_user_hash ){
            $this->user_hash = $m_user_hash;
      }
      public function get_user_hash(){
            return $this->user_hash;
      }
      
      // last_login
      public function set_last_login( $m_last_login ){
            $this->last_login = $m_last_login;
      }
      public function get_last_login(){
            return $this->last_login;
      }
      
      // user_login
      public function set_user_login( $m_user_login ){
            $this->user_login = $m_user_login;
      }
      public function get_user_login(){
            return $this->user_login;
      }
      
      // num_logins
      public function set_num_logins( $m_num_logins ){
            $this->num_logins = $m_num_logins;
      }
      public function get_num_logins(){
            return $this->num_logins;
      }
      
      // user_class_id
      public function set_user_class_id( $m_user_class_id ){
            $this->user_class_id = $m_user_class_id;
      }
      public function get_user_class_id(){
            return $this->user_class_id;
      }
      
      // consent_store_email
      public function set_consent_store_email( $m_consent_store_email ){
            $this->consent_store_email = $m_consent_store_email;
      }
      public function get_consent_store_email(){
            return $this->consent_store_email;
      }
      
      // failed_logins
      public function set_failed_logins( $m_failed_logins ){
            $this->failed_logins = $m_failed_logins;
      }
      public function get_failed_logins(){
            return $this->failed_logins;
      }
      
      // active
      public function set_active( $m_active ){
            $this->active = $m_active;
      }
      public function get_active(){
            return $this->active;
      }

      // Magic methods for private properties
      public function __set( $propertyName, $propertyValue )
      {
            $this->propertyName = $propertyValue;
      }

      public function __get( $propertyName ){
            return $this->propertyName;    
      }

  }  // Class CreateAccount()
} // if(!class_exists('CreateAccount')

?>