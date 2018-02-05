<?php
namespace App\Http\Services;

use App\Http\Controllers\Controller;
use Config;

class AuthService extends Controller
{
    public function isSecurePrivateRange($ip)
    {
        $ip_privates = Config::get('config.ip_private');

        return $this->checkIpRange($ip_privates, $ip);
    }

    public function checkIpRange($ip_ranges, $ip)
    {
        foreach ($ip_ranges as $range) {
            if (strpos($range, '/') == false) {
                $range .= '/32';
            }
            // $range is in IP/CIDR format eg 127.0.0.1/24
            list($range, $netmask) = explode('/', $range, 2);
            $ip_decimal       = ip2long($ip);
            $range_decimal    = ip2long($range);
            $wildcard_decimal = pow(2, (32 - $netmask)) - 1;
            $netmask_decimal  = ~ $wildcard_decimal;
            if (($ip_decimal & $netmask_decimal) == ($range_decimal & $netmask_decimal)) {
                return true;
            }
        }

        return false;
    }
}