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
}
