<?php
if(!class_exists('clsCrypto')){
	class clsCrypto {
	var $today;
	var $user_hash;
	
    	function __construct() {
    		$this->today = date( 'Y-m-d' );
    	}
		
   Public Function EnDeCrypt($plaintxt, $psw){
   /*
   ':::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
   ':::  This routine does all the work. Call it both to ENcrypt    :::
   ':::  and to DEcrypt your data.                                  :::
   ':::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
	*/
	
	
		$temp = "";
		$a = 0;
		$i = 0;
		$j = 0;
		$k = 0;
		$cipherby="";
		$cipher="";
	
		$i = 0
		$j = 0

		$this->RC4Initialize($psw);

		For ($a=0; $x<strlen($plaintext); $a++){
			$i = ($i + 1) Mod 255
			$j = ($j + $sbox($i)) Mod 255
			$temp = $sbox($i)
			$sbox($i) = $sbox($j)
			$sbox($j) = $temp

			$k = $sbox(($sbox($i) + $sbox($j)) Mod 255)

			$cipherby = substr($plaintxt, $a, 1)) Xor $k
		
			If $cipherby = 0 Then 
				$cipherby = substr($plaintxt, $a, 1)
				$cipher = $cipher & Chr($cipherby)
			}

		$EnDeCrypt = $cipher
      
   //End Function
   }
   
   private function RC4Initialize($strPwd){
   /*
	'::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
	':::  This routine called by EnDeCrypt function. Initializes the
	':::  sbox and the key array)
	'::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
	*/
	
	$tempSwap = "";
	$a = 0;
	$b = array();
	$intLength=0;
	$key = array();
	$sbox = array();
	
   $intLength = strlen(strPwd);
   For ($a=0; $a<256; $a++){
      $key($a) = substr($strpwd, ($a mod $intLength)+1, 1)
      $sbox($a) = $a
   }

   $b = 0
   For ($a=0; $a<256; $a++){
      $b = ($b + $sbox($a) + $key($a)) Mod 256
      $tempSwap = $sbox($a)
      $sbox($a) = $sbox($b)
      $sbox($b) = $tempSwap
   }
}
?>