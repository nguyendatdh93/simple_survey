<?php
namespace App\Http\Services;

use App\Http\Controllers\Controller;
use Config;
use Illuminate\Support\Facades\Crypt;

class EncryptionService extends Controller
{
    /**
     * @param $plaintext
     * @return string
     */
    public function encrypt($plaintext)
    {
        return Crypt::encrypt($plaintext);
    }

    /**
     * @param $ciphertext
     * @return string
     */
    public function decrypt($ciphertext)
    {
        return Crypt::decrypt($ciphertext);
    }
}