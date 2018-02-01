<?php
namespace App\Http\Services;

use App\Http\Controllers\Controller;
use Config;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

class EncryptionService extends Controller
{
	private $key;
	
	public function __construct()
	{
		$this->key = "MTVzaW1wbGVfc3VydmV5X2tleV9zY3JldGU";
	}
	
	/**
     * @param $plaintext
     * @return string
     */
    public function encrypt($plaintext)
    {
	    $encryption_key = base64_decode($this->key);
	    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
	    $encrypted = openssl_encrypt($plaintext, 'aes-256-cbc', $encryption_key, 0, $iv);
	    
	    return base64_encode($encrypted . '::' . $iv);
    }

    /**
     * @param $ciphertext
     * @return string
     */
    public function decrypt($ciphertext)
    {
	    $encryption_key = base64_decode($this->key);
	    list($encrypted_data, $iv) = explode('::', base64_decode($ciphertext), 2);
	    
	    return openssl_decrypt($encrypted_data, 'aes-256-cbc', $encryption_key, 0, $iv);
    }
}