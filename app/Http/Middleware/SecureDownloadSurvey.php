<?php

namespace App\Http\Middleware;

use App\Http\Services\AuthService;
use App\Http\Services\SurveyService;
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
	    $survey_service = new SurveyService();
	    $url_redirect   = $survey_service->redirectIfAuthenticated($request);
	    
	    if ($url_redirect != '') {
		    return redirect()->route($url_redirect);
	    }

        return $next($request);
    }
}
