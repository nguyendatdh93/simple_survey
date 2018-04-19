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

    const HTTP_CODE_UNAUTHORIZED = 401;
    const HTTP_CODE_FORBIDDEN    = 403;
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

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function loginByEmployeePlf(Request $request)
    {
        try {
            $query = http_build_query([
                'client_id'     => Config::get('config.client_id'),
                'client_secret' => Config::get('config.client_secret'),
                'redirect_uri'  => route(User::NAME_URL_AUTH_BY_EMPLOYEE_PLF_CALLBACK),
                'response_type' => 'code',
                'scope'         => ''
            ]);

            return redirect(Config::get('config.domain_auth').'/oauth/authorize?'.$query);
        } catch (\Exception $exception) {
            return redirect('/login')->with('error', $exception->getMessage());
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function loginByEmployeePlfCallback(Request $request)
    {
        if ($request->get('code') && $request->get('code') == self::HTTP_CODE_FORBIDDEN) {
            if ($request->get('state') == Self::ERROR_PERMISSION) {
                return redirect('/login')->with('error', trans("adminlte_lang::survey.error_permission_use_app"));
            }
        } elseif ($request->get('code') && $request->get('code') == self::HTTP_CODE_UNAUTHORIZED) {
            if ($request->get('state') == Self::ERROR_UNAUTHORIZED) {
                return redirect('/login')->with('error', trans("adminlte_lang::survey.error_unauthorized"));
            }
        } elseif ($request->code && $request->code == '') {
            return redirect('/login')->with('error', trans("adminlte_lang::survey.error_auth_code_not_available"));
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

            if (!empty($response['code']) && $response['code'] == self::HTTP_CODE_UNAUTHORIZED) {
                if ($response['state'] == self::ERROR_UNAUTHORIZED) {
                    return redirect('/login')->with('error', trans("adminlte_lang::survey.error_unauthorized"));
                }
            } elseif (!empty($response['code']) && $response['code'] == self::HTTP_CODE_FORBIDDEN) {
                if ($response['state'] == self::ERROR_IP) {
                    return redirect('/login')->with('error', trans("adminlte_lang::survey.error_service_not_available"));
                }
            } elseif (empty($response['access_token'])) {
                return redirect('/login')->with('error', trans("adminlte_lang::survey.error_token_not_available"));
            }

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
        } catch (\Exception $exception) {
            return redirect('/login')->with('error', $exception->getMessage());
        }
    }
}
