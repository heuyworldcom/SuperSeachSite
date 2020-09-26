<?php 
 if(!class_exists('SHA256EM')){
  class SHA256EM{
      var $today;

      function __construct(){
          $this->today = date( 'Y-m-d' );
      }
	  
	public function decrypt( $encrypted, $password )
	{
		$method = 'aes-256-cbc';
		$key = substr(hash('sha256', $password, true), 0, 32);
		$iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);
		$decrypted = openssl_decrypt(base64_decode($encrypted), $method, $key, OPENSSL_RAW_DATA, $iv);
		return $decrypted;
	}

	public function encrypt( $plaintext, $password )
	{
		$method = 'aes-256-cbc';
		$key = substr(hash('sha256', $password, true), 0, 32);
		$iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);
		$encrypted = base64_encode(openssl_encrypt($plaintext, $method, $key, OPENSSL_RAW_DATA, $iv));
		return $encrypted;
	}

  }
};
?>
