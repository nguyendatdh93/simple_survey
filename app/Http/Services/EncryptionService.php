<?php
namespace App\Http\Services;

use App\Http\Controllers\Controller;
use Config;

class EncryptionService extends Controller
{
	private $key;
	
	public function __construct()
	{
		$this->key = Config::get('config.key_secret_encrypt_url');
	}
	
	/**
     * @param $plaintext
     * @return string
     */
    public function encrypt($plaintext)
    {
	    $encryption_key = base64_decode($this->key);
	    
	    $iv = substr(hash('sha256', $this->key), 0, 16);
	    
	    $encrypted = openssl_encrypt($plaintext, 'aes-256-cbc', $encryption_key, 0, $iv);
	    
	    return $this->base32_encode($encrypted);
    }

    /**
     * @param $ciphertext
     * @return string
     */
    public function decrypt($ciphertext)
    {
	    $encryption_key = base64_decode($this->key);
	    $iv = substr(hash('sha256', $this->key), 0, 16);
	    
	    return openssl_decrypt($this->base32_decode($ciphertext), 'aes-256-cbc', $encryption_key, 0, $iv);
    }
	
	/**
	 * @param $d
	 * @return mixed|string
	 */
	public function base32_decode($d)
	{
		list($t, $b, $r) = array("ABCDEFGHIJKLMNOPQRSTUVWXYZ234567", "", "");
		
		foreach(str_split($d) as $c)
			$b = $b . sprintf("%05b", strpos($t, $c));
		
		foreach(str_split($b, 8) as $c)
			$r = $r . chr(bindec($c));
		
		return($r);
	}
	
	/**
	 * @param $d
	 * @return mixed|string
	 */
	public function base32_encode($d)
	{
		list($t, $b, $r) = array("ABCDEFGHIJKLMNOPQRSTUVWXYZ234567", "", "");
		
		foreach(str_split($d) as $c)
			$b = $b . sprintf("%08b", ord($c));
		
		foreach(str_split($b, 5) as $c)
			$r = $r . $t[bindec($c)];
		
		return($r);
	}
}