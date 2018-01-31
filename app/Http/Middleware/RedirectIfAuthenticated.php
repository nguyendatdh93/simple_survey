<?php

namespace App\Http\Middleware;

use App\Http\Services\AuthService;
use App\Http\Services\SurveyService;
use Closure;
use Illuminate\Support\Facades\Auth;
use App\Survey;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            $survey_service = new SurveyService();
	        $url_redirect   = $survey_service->redirectIfAuthenticated($request);
	        
	        return redirect()->route($url_redirect);
        }

        return $next($request);
    }
}
