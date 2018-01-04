<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Repositories\Contracts\UserRepositoryInterface;
use Config;
use Auth;

class LoginController extends Controller
{
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
            return redirect('/login')->with('error', Config::get('config.domain') . ' ドメインの Google アカウントでログインしてください。');
        }

        $user_info = $this->userRepository->getUserInfoByEmail($result['email']);
        if (!$user_info) {
            $user_info = $this->userRepository->saveUser($result['email']);
        }

        Auth::login($user_info);

        return redirect('/home');
    }

    public function revolkeAccessTokenGoogle($token)
    {
        $reflector = new \ReflectionClass($token);
        $classProperty = $reflector->getProperty('accessToken');
        $classProperty->setAccessible(true);
        $accessToken = $classProperty->getValue($token);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://accounts.google.com/o/oauth2/revoke?token=". $accessToken);
        curl_exec($ch);
        curl_close($ch);
    }
}
