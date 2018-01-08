<?php

namespace App\Http\Middleware;

use App\Http\Services\AuthService;
use App\Survey;
use Closure;
use Config;

class SecureDownloadSurvey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $prefix       =  trim($request->route()->getPrefix(),"/");
        $auth_service = new AuthService();
        if ($auth_service->isSecurePrivateRange($request->ip())) {
            if ($prefix == '' || $prefix == 'home') {
                return redirect()->route(Survey::NAME_URL_DOWNLOAD_LIST);
            }

            if (!in_array($prefix,array('download'))) {
                return redirect('404');
            }
        } else {
            if ($prefix == '' || $prefix == 'home') {
                return redirect()->route(Survey::NAME_URL_SURVEY_LIST);
            }

            if (in_array($prefix,array('download'))) {
                return redirect('404');
            }
        }

        return $next($request);
    }

    public function isSecurePrivateRange($ip)
    {
        $ip_privates    = Config::get('config.ip_private');

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
            $ip_decimal = ip2long($ip);
            $range_decimal = ip2long($range);
            $wildcard_decimal = pow(2, (32 - $netmask)) - 1;
            $netmask_decimal = ~ $wildcard_decimal;
            if (($ip_decimal & $netmask_decimal) == ($range_decimal & $netmask_decimal)) {
                return true;
            }
        }

        return false;
    }
}
