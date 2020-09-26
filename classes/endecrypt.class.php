<?php 

// Class EnDeCrypt - Created On: 2020-02-23 at 23:02:43

 if(!class_exists('EnDeCrypt')){
  class EnDeCrypt{

      private $propertyName;
      private $propertValue;
      private $dbOps;
      private $ret;
      private $today;

      private $Plaintext;
      private $Method;
      private $ConvertToHex;
      private $VariableDate;
      private $Password;
      private $PasswordExtension;
      private $ObjectPrefix;

      function __construct(){
          $this::Initialize();
      } 

      private function Initialize(){
            $this->today                = date('Y-m-d');
            $this->propertyName         = '';
            $this->propertValue         = '';
            $this->dbOps                = new clsDBOps();
            $this->ret                  = new clsRetval();
            $this->Plaintext            = '';
            $this->Method               = 'aes-128-cbc-hmac-sha256';
            $this->ConvertToHex         = false;
            $this->VariableDate         = '';
            $this->Password             = '';
            $this->PasswordExtension    = 'r1nG5r';
            $this->ObjectPrefix         = array( 
                1=>'3x27_', 
                2=>'0P0x_', 
                3=>'11ii_', 
                4=>'keP4_', 
                5=>'Aamu_', 
                6=>'9yvW_', 
                7=>'sEo0_' );
            
      }

      public function  __destruct() {
      
      }

      private function strToHex( $string ){
		$hex = '';
		for ( $i=0; $i<strlen( $string ); $i++ ){
			$ord = ord( $string[$i] );
			$hexCode = dechex( $ord );
			$hex .= substr( '0'.$hexCode, -2 );
		}
		return strToUpper( $hex );
	}
	
	private function hexToStr( $hex ){
		$string = '';
		for ( $i=0; $i < strlen( $hex )-1; $i+=2 ){
			$string .= chr( hexdec( $hex[$i].$hex[$i+1] ) );
		}
		return $string;
	}

	public function decrypt( $encrypted ){
        $encrypted = ( $this->ConvertToHex === true ) ? $this::hexToStr( $encrypted ) : $encrypted;
        
		$ivlen = openssl_cipher_iv_length($this->Method);
		$iv = openssl_random_pseudo_bytes($ivlen);
		$iv = substr($this::get_Password().$iv,0,16);

        $decrypted = openssl_decrypt( $encrypted, $this->Method, $this::get_Password(), OPENSSL_RAW_DATA, $iv );
        
		return $decrypted;
	}

	public function encrypt( $plaintext ){
		$ivlen = openssl_cipher_iv_length($this->Method);
		$iv = openssl_random_pseudo_bytes($ivlen);
		$iv = substr($this::get_Password().$iv,0,16);
		
        $encrypted = openssl_encrypt( $plaintext, $this->Method, $this::get_Password(), OPENSSL_RAW_DATA, $iv );
        $encrypted = ( $this->ConvertToHex === true ) ? $this::strToHex( $encrypted ) : $encrypted;
		return $encrypted;
    }
          
    // GETTER / SETTER Functions

       // ObjectPrefix - ObjectPrefix is array of form object name prefixes. The key is the weekday number.
       public function get_ObjectPrefix(){
            return $this->ObjectPrefix[date('N', strtotime( $this->today ))];
       }

     // Password
        public function set_Password( $m_password ){
            $this->Password = $m_password.$this->PasswordExtension;
        }

        public function get_Password(){
                return $this->Password;
        }

     // VariableDate
        public function set_VariableDate( $m_variabledate ){
            $this->VariableDate = $m_variabledate;
        }

        public function get_VariableDate(){
            return $this->VariableDate;
        }

      // Plaintext
      public function set_Plaintext( $m_plaintext ){
            $this->Plaintext = $m_plaintext;
      }

      public function get_Plaintext(){
            return $this->Plaintext;
      }
      
      // Method
      public function set_Method( $m_method ){
            $this->Method = $m_method;
      }

      public function get_Method(){
            return $this->Method;
      }
      
      // ConvertToHex
      public function set_ConvertToHex( $m_converttohex ){
            $this->ConvertToHex = $m_converttohex;
      }

      public function get_ConvertToHex(){
            return $this->ConvertToHex;
      }

      // Magic methods for private properties
      public function __set( $propertyName, $propertyValue )
      {
            $this->propertyName = $propertyValue;
      }

      public function __get( $propertyName ){
            return $this->propertyName;    
      }

  }  // Class EnDeCrypt()
} // if(!class_exists('EnDeCrypt')

?>