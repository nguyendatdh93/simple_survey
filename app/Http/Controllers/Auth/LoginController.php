<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Services\AuthService;
use App\Models\User;
use App\Survey;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Repositories\Contracts\UserRepositoryInterface;
use Config;
use Auth;

class LoginController extends AuthService
{
    const ERROR_IP           = 'error_ip';
    const ERROR_PERMISSION   = 'error_permission';
    const ERROR_UNAUTHORIZED = 'error_unauthorized';
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers {
        attemptLogin as attemptLoginAtAuthenticatesUsers;
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('admin::auth.login');
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';
    protected $userRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->middleware('guest', ['except' => 'logout']);
        $this->userRepository = $userRepository;
    }

    /**
     * Returns field name to use at login.
     *
     * @return string
     */
    public function username()
    {
        return config('auth.providers.users.field','email');
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        if ($this->username() === 'email') return $this->attemptLoginAtAuthenticatesUsers($request);
        if ( ! $this->attemptLoginAtAuthenticatesUsers($request)) {
            return $this->attempLoginUsingUsernameAsAnEmail($request);
        }
        return false;
    }

    /**
     * Attempt to log the user into application using username as an email.
     *
     * @param \Illuminate\Http\Request $request
     * @return bool
     */
    protected function attempLoginUsingUsernameAsAnEmail(Request $request)
    {
        return $this->guard()->attempt(
            ['email' => $request->input('username'), 'password' => $request->input('password')],
            $request->has('remember'));
    }

    /*
    * @var Request $request
    */
    public function loginWithGoogle(Request $request) {
        session_save_path(config('session.files'));

        $code          = $request->get('code');
        $googleService = \OAuth::consumer('Google');
        if (!is_null($code)) {
            try {
                $token  = $googleService->requestAccessToken($code);
                $result = json_decode($googleService->request('https://www.googleapis.com/oauth2/v1/userinfo'), true);
            } catch (Exception $e) {
                return redirect('/login')->with('error', $e->getMessage());
            }
        } else {
            return redirect((string)$googleService->getAuthorizationUri());
        }

        $domain_name = substr(strrchr($result['email'], "@"), 1);
        if ($domain_name != Config::get('config.domain')) {
            $this->revolkeAccessTokenGoogle($token);
            
            return redirect('/login')->with('error', Config::get('config.domain') .' '. trans("adminlte_lang::survey.error_sign_google"));
        }

        $user_info = $this->userRepository->getUserInfoByEmail($result['email']);
        if (!$user_info) {
            $user_info = $this->userRepository->saveUser($result['email']);
        }

        Auth::login($user_info);

        if ($this->isSecurePrivateRange($request->ip())) {
            return redirect()->route(Survey::NAME_URL_DOWNLOAD_LIST);
        } else {
            return redirect()->route(Survey::NAME_URL_SURVEY_LIST);
        }
    }

    public function revolkeAccessTokenGoogle($token)
    {
        $reflector = new \ReflectionClass($token);
        $classProperty = $reflector->getProperty('accessToken');
        $classProperty->setAccessible(true);
        $accessToken = $classProperty->getValue($token);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, Config::get('config.url_sign_out_google') ."=". $accessToken);
        curl_exec($ch);
        curl_close($ch);
    }

    public function loginByEmployeePlf(Request $request)
    {
        try {
            $query = http_build_query([
                'client_id'     => Config::get('config.client_id'),
                'client_secret' => Config::get('config.client_secret'),
                'redirect_uri'  => route(User::NAME_URL_AUTH_BY_EMPLOYEE_PLF_CALLBACK),
                'response_type' => 'code',
                'scope'         => '',
                'ip'            => $request->ip()
            ]);

            return redirect(Config::get('config.domain_auth').'/oauth/authorize?'.$query);
        } catch (\GuzzleHttp\Exception\GuzzleException $exception) {
            return redirect('/login')->with('error', trans("adminlte_lang::survey.error_sign_employee"));
        }
    }

    public function loginByEmployeePlfCallback(Request $request)
    {
        if ($request->get('code') && $request->get('code') == 403) {
            if ($request->get('state') == Self::ERROR_IP) {
                return redirect('/login')->with('error', trans("adminlte_lang::survey.error_ip_not_matching"));
            }

            if ($request->get('state') == Self::ERROR_PERMISSION) {
                return redirect('/login')->with('error', trans("adminlte_lang::survey.error_permission_use_app"));
            }
        }

        if ($request->get('code') && $request->get('code') == 401) {
            if ($request->get('state') == Self::ERROR_UNAUTHORIZED) {
                return redirect('/login')->with('error', trans("adminlte_lang::survey.error_unauthorized"));
            }
        }

        $http = new \GuzzleHttp\Client;
        try {
            $response = $http->post(Config::get('config.domain_auth').'/oauth/token', [
                'form_params' => [
                    'grant_type'    => 'authorization_code',
                    'client_id'     => Config::get('config.client_id'),
                    'client_secret' => Config::get('config.client_secret'),
                    'redirect_uri'  => route(User::NAME_URL_AUTH_BY_EMPLOYEE_PLF_CALLBACK),
                    'code'          => $request->code
                ],
            ]);

            $response = json_decode((string) $response->getBody(), true);
            $response = $http->request('GET', Config::get('config.domain_auth').'/api/user', [
                'headers' => [
                    'Accept'        => 'application/json',
                    'Authorization' => 'Bearer '.$response['access_token'],
                ],
            ]);

            $response  = json_decode((string) $response->getBody(), true);
            $user_info = $this->userRepository->getUserInfoByEmail($response['email']);
            if (!$user_info) {
                $user_info = $this->userRepository->saveUser($response['email']);
            }

            Auth::login($user_info);

            if ($this->isSecurePrivateRange($request->ip())) {
                return redirect()->route(Survey::NAME_URL_DOWNLOAD_LIST);
            } else {
                return redirect()->route(Survey::NAME_URL_SURVEY_LIST);
            }
        } catch (\GuzzleHttp\Exception\GuzzleException $exception) {
            $response = json_decode((string) $exception, true);
            if ($response['error']) {
                return redirect('/login')->with('error', $response['error']);
            }
            return redirect('/login')->with('error', trans("adminlte_lang::survey.error_sign_employee"));
        }
    }
}
