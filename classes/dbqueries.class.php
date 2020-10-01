

<?php 

// Class DBQueries - Created On: 2019-12-26 at 21:12:14

 if(!class_exists('DBQueries')){
  class DBQueries{
      private $sql;
      private $UserId;
      private $Active;

      function __construct(){
          $this::Initialize();
      } 

      private function Initialize(){
            $this->sql    = '';
            $this->UserId  = false;
            $this->Active  = false;
      }

      public function  __destruct() {
      
      }

     

      private function GetAhash(){
            $currentNanoSecond = (int) (microtime(true) * 1000000000);
            $randomHash = hash('ripemd160', $currentNanoSecond.date('Y-m-d H:m:s').$currentNanoSecond);
            return $randomHash;
      }

      private function ExtractVariable( $aryParams, $variable ){
            $retVal=false;
            foreach($aryParams AS $k){
                  if(isset($k[$variable])){
                        $retVal = $k[$variable];
                  }
            }
            return $retVal;
      }
      public function DoesUserExistSql( $aryParams ){
            $user_name = $this::ExtractVariable( $aryParams , 'user_name' );
            $password = $this::ExtractVariable( $aryParams , 'user_pswd' );
            $user_login = hash('ripemd160', $user_name."|n|".$password."|n|PASSWORD_HERE"); // NEVER CHANGE THIS LINE
            $sql = "SELECT ID FROM users WHERE user_login='".$user_login."';";
            return $sql;
      }

      public function GetInsertNewAccountSql( $aryParams ){
            
            $sql = "INSERT INTO `users`(`created_date`, `user_hash`, `last_login`, `user_login`, `num_logins`, `user_class_id`, `consent_store_email`, `failed_logins`, `active`, `user_name` ";
            $user_name = $this::ExtractVariable( $aryParams , 'user_name' );
            $password = $this::ExtractVariable( $aryParams , 'user_pswd' );
            $user_login = hash('ripemd160', $user_name."|n|".$password."|n|PASSWORD_HERE"); // NEVER CHANGE THIS LINE
            $sql = substr($sql,0,strlen($sql)-1);
            $sql .= ") VALUES('".date('Y-m-d H:m:s')."','".$this::GetAhash()."','".date('Y-m-d H:m:s')."','".$user_login."','1','1','1','0','1','".$user_name."');";
            return $sql;
      }

      public function GetMainMenu(){
            $sql = "
            SELECT 
                  mm.main_menu_id, 
                  mm.main_menu_name,
                  mm.main_menu_url,
                  REPLACE(LOWER(CONCAT(mp.menu_prefix,mm.main_menu_name)),' ','_') AS div_id
            FROM `main_menu` AS mm
            INNER JOIN menu_prefixes AS mp ON mm.menu_prefix_id = mp.menu_prefix_id
            ORDER BY mm.sort_ord ASC;
            ";
            return $sql;
      }

      public function GetSubMenues( $main_menu_id ){
            $sql ="SELECT mm.main_menu_id, sm.sub_menu_id, sm.sub_menu_name,
            REPLACE(LOWER(CONCAT(mm_mp.menu_prefix,mm.main_menu_name)),' ','_') AS 'main_id',
            REPLACE(LOWER(CONCAT(sm_mp.menu_prefix,sm.sub_menu_name)),' ','_') AS 'sub_id'
            FROM main_menu AS mm
            INNER JOIN sub_menus AS sm ON mm.main_menu_id = sm.main_menu_id
            LEFT JOIN menu_prefixes AS mm_mp ON mm_mp.menu_prefix_id = mm.menu_prefix_id
            LEFT JOIN menu_prefixes AS sm_mp ON sm_mp.menu_prefix_id = sm.sub_menu_prefix_id
            WHERE mm.main_menu_id=".$main_menu_id." AND sm.active=1
            ORDER BY mm.main_menu_id ASC, sm.sub_menu_id ASC
            ";
            return $sql;
      }

      public function GetSuperSearchs(){
            $sql = false;
            if($this::get_UserId()!=false && $this::get_Active()!=false){
                  $sql = "SELECT * FROM `supersearch` WHERE user_id=".$this->UserId." AND active=".$this->Active." ORDER BY name ASC;";
            }
            
            return $sql;
      }

      // UserId
      public function set_UserId( $m_userid ){
            $this->UserId = $m_userid;
      }
      public function get_UserId(){
            return $this->UserId;
      }

      // Active
      public function set_Active( $m_active ){
            $this->Active = $m_active;
      }
      public function get_Active(){
            return $this->Active;
      }

      // sql
      public function set_sql( $m_sql ){
            $this->sql = $m_sql;
      }

      public function get_sql(){
            return $this->sql;
      }

      // Magic methods for private properties
      public function __set( $propertyName, $propertyValue )
      {
            $this->propertyName = $propertyValue;
      }

      public function __get( $propertyName ){
            return $this->propertyName;    
      }

  }  // Class DBQueries()
} // if(!class_exists('DBQueries')

?>
