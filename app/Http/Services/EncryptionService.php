<?php
namespace App\Http\Services;

use App\Http\Controllers\Controller;
use Config;

class EncryptionService extends Controller
{
	private $key;
	private $encryption_key;
	private $iv;
	
	public function __construct()
	{
		$this->key            = Config::get('config.key_secret_encrypt_url');
		$this->encryption_key = base64_decode($this->key);
		$this->iv             = substr(hash('sha256', $this->key), 0, 16);
	}
	
	/**
     * @param $plaintext
     * @return string
     */
    public function encrypt($plaintext)
    {
	    $encrypted = openssl_encrypt($plaintext, 'aes-256-cbc', $this->encryption_key, 0, $this->iv);
	    
	    return $this->base32_encode($encrypted);
    }

    /**
     * @param $ciphertext
     * @return string
     */
    public function decrypt($ciphertext)
    {
	    return openssl_decrypt($this->base32_decode($ciphertext), 'aes-256-cbc', $this->encryption_key, 0, $this->iv);
    }
	
	/**
	 * @param $d
	 * @return mixed|string
	 */
	public function base32_decode($d)
	{
		list($t, $b, $r) = array("abcdefghijklmnopqrstuvwxyz345769", "", "");
		
		foreach(str_split($d) as $c) {
			$b = $b . sprintf("%05b", strpos($t, $c));
		}
		
		foreach(str_split($b, 8) as $c) {
			$r = $r . chr(bindec($c));
		}
		
		return($r);
	}
	
	/**
	 * @param $d
	 * @return mixed|string
	 */
	public function base32_encode($d)
	{
		list($t, $b, $r) = array("abcdefghijklmnopqrstuvwxyz345769", "", "");
		
		foreach(str_split($d) as $c) {
			$b = $b . sprintf("%08b", ord($c));
		}
		
		foreach(str_split($b, 5) as $c) {
			$r = $r . $t[bindec($c)];
		}
		
		return($r);
	}
}