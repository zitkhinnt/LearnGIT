<?php

namespace Modules\Horserace\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Auth;
use Cookie;
use GuzzleHttp\Client;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Modules\Horserace\Entities\FrontendImage;
use Modules\Horserace\Entities\User;
use Modules\Horserace\Entities\Users;
use Modules\Horserace\Http\Requests\UserLoginRequest;
use Modules\Horserace\Repositories\MailBanRepositories;
use Modules\Horserace\Repositories\MediaAccessRepositories;
use Modules\Horserace\Repositories\ResultRepositories;
use Modules\Horserace\Repositories\UserActivityRepositories;
use Modules\Horserace\Repositories\UserDailyLoginHistoryRepositories;
use Modules\Horserace\Repositories\UserRepositories;
use Socialite;

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

    use AuthenticatesUsers;

    /**
     * Max number login if wrong.
     *
     * @var integer
     */
    public $maxAttempts = 5;

    /**
     * Max time off if input login wrong.
     *
     * @var integer
     */
    public $decayMinutes = 1;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout', 'userLogout');
    }

    public function redirectToProvider($provider)
    {
        khanh_log('social login redirect to provider:::' . $provider);

        if ($provider == 'yahoo') {
            // manual change to yahoo japan
            $clientId = env('YAHOO_ID');
            $clientSecret = env('YAHOO_SECRET');
            $redirectUrl = env('YAHOO_URL');

            $yahoo_auth_url = 'https://auth.login.yahoo.co.jp/yconnect/v2/authorization?client_id='
                . $clientId . '&redirect_uri=' . $redirectUrl . '&scope=openid%20email%20profile&response_type=code';

            return redirect($yahoo_auth_url);
        }

        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from Facebook.
     *
     * @return Response
     */
    public function handleProviderCallback(Request $request,
        UserRepositories $userRepositories,
        MailBanRepositories $mailBanRepositories,
        UserDailyLoginHistoryRepositories $userDailyLoginHistoryRepositories,
        UserActivityRepositories $userActivityRepositories,
        $provider) {
        $input = $request->all();

        khanh_log('provider call back:::' . print_r($input, true));

        //get ip address
        $ip = $_SERVER['REMOTE_ADDR'];
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }

        $ref = $request->cookie('ref');
        khanh_log('social login ref:::' . $ref);

        // Get user socialite
        switch ($provider) {
            case "google":
                $user = Socialite::driver("google")->stateless()->user();
                // Check have account
                $email = $user->email;
                $provider_user_id = $provider . '-' . $user->id;
                $user_name = $user->name;
                break;

            case "facebook":
                $user = Socialite::driver("facebook")->stateless()->user();
                $email = $user->email ?? '';
                $provider_user_id = $provider . '-' . $user->id;
                $user_name = $user->name;
                break;

            case "yahoo":
                // manual get user profile from yahoo japan

                if (isset($input['code'])) {
                    // step1: get access token from authorization_code
                    $yahoo_token_url = 'https://auth.login.yahoo.co.jp/yconnect/v2/token';
                    $authorization_code = $input['code'];

                    $http_client = new Client();

                    $token_response = $http_client->post($yahoo_token_url, [
                        'headers' => [
                            'Connection' => 'keep-alive',
                            'Content-Type' => 'application/x-www-form-urlencoded',
                            'Accept-Charset' => 'UTF-8',
                        ],
                        'form_params' => [
                            'code' => $authorization_code,
                            'client_id' => env('YAHOO_ID'),
                            'client_secret' => env('YAHOO_SECRET'),
                            'redirect_uri' => env('YAHOO_URL'),
                            'grant_type' => 'authorization_code',
                        ],
                    ]);

                    $access_token = json_decode($token_response->getBody(), true)['access_token'];

                    // step2: get user from access_token
                    $yahoo_info_url = 'https://userinfo.yahooapis.jp/yconnect/v2/attribute';
                    $user_response = $http_client->get($yahoo_info_url, [
                        'headers' => [
                            'Authorization: Bearer ' . $access_token,
                        ],
                        'query' => [
                            'access_token' => $access_token,
                        ],
                    ]);

                    $user = json_decode($user_response->getBody(), true);

                    $email = $user['email'] ?? '';
                    $provider_user_id = $provider . '-' . $user['sub'];
                    $user_name = $user['nickname'] ?? '';
                }

                break;

            case "twitter":
                $user = Socialite::driver("twitter")->user();
                $email = $user->email ?? '';
                $provider_user_id = $provider . '-' . $user->id;
                $user_name = $user->name ?? '';
                break;

            default:
                // $user = Socialite::driver($provider)->stateless()->user();
                khanh_log('social login user not support:::' . $provider);
                abort(404);
                break;
        }

        if (!isset($provider_user_id) || !$provider_user_id) {
            abort(404);
        }

        // Check mail ban
        if (!empty($email)) {
            $result = $mailBanRepositories->checkMailBan(trim($email));
            if ($result["status"] == "danger") {
                khanh_log('social login user ban mail:::' . $email);
                $data["status"] = $result;
                return view('horserace::frontend.before_login.entry', compact('data'));
            }
        }

        // Data create user
        $data = [
            "mail_pc" => $email,
            "nickname" => $user_name,
            "provider_user_id" => $provider_user_id,
            "ip" => $ip,
            "user_agent" => $_SERVER['HTTP_USER_AGENT'],
            "media_code" => isset($ref) ? trim($ref) : MEDIA_DEFAULT,
        ];
        $result = $userRepositories->feRegisterUserBySocialite($data);

        if ( $result['member_level'] == MEMBER_LEVEL_EXCEPT) {
            $data["status"] == "level_except";
            return view('horserace::frontend.before_login.entry', compact('data'));
        }

        // User activity
        $arr_user_activity = [
            "ip" => $data['ip'],
            "user_agent" => $data['user_agent'],
            "user_id" => $result['id'],
        ];
        $userActivityRepositories->addLoginUser($arr_user_activity);

        // User daily login activity
        $arr_user_daily_login = [
            "ip" => $data['ip'],
            "login_id" => $result['login_id'],
            "user_agent" => $data['user_agent'],
            'user_id' => $result['id'],
        ];
        $userDailyLoginHistoryRepositories->addDailyLoginUser($arr_user_daily_login);

        // login frontend
        if (Auth::guard('web')->attempt(['login_id' => $result["login_id"], 'password' => $result["password_text"], 'deleted_flg' => 0])) {
            khanh_log('social login user authen ok');
            return $this->sendLoginResponse($request);
        } else {
            khanh_log('social login user authen not ok');
            return view('horserace::frontend.before_login.entry', compact('data'));
        }
    }

    public function loginByAdmin($user, $request)
    { 
        if (Auth::guard('web')->attempt(['login_id' => $user->login_id, 'password' => $user->password_text], $request->remember)) {
         // return $this->sendLoginResponse($request);
        }
    }

    /**
     * Show page login
     * @return [type] [description]
     */
    public function showLoginForm(Request $request,
        MediaAccessRepositories $mediaAccessRepositories,
        FrontendImage $frontendImage,
        ResultRepositories $resultRepositories) {
        $input = $request->all();
        
        $data = $resultRepositories->getListResultPublic(['page' => 0]);

        $data["ref"] = isset($input["ref"]) ? trim($input["ref"]) : MEDIA_DEFAULT;

        $input = [
            "media_code" => $data["ref"],
        ];

        // get fronend image
        $frontendimages = $frontendImage->getAllImage();

        foreach ($frontendimages as $value) {
            $data['frontendimages'][$value->code] = (array) $value;
        }

        $mediaAccessRepositories->addMediaAccess($input);

        // set ref cookie
        Cookie::queue('ref', $data["ref"], 30);

        return view('horserace::frontend.login.login', compact("data"));
    }

// bicycle-race
    public function showLoginSMPForm(Request $request,
        MediaAccessRepositories $mediaAccessRepositories) {
        $input = $request->all();
        $data["ref"] = isset($input["ref"]) ? trim($input["ref"]) : MEDIA_DEFAULT;

        $input = [
            "media_code" => $data["ref"],
        ];

        $mediaAccessRepositories->addMediaAccess($input);
        return view('horserace::frontend.login.login_smp', compact("data"));
    }

    public function LoginForm(){
        return view('horserace::frontend.login.login_form');
    }

    public function login(UserLoginRequest $request,
        UserDailyLoginHistoryRepositories $userDailyLoginHistoryRepositories,
        UserActivityRepositories $userActivityRepositories) {
        if (Auth::guard('web')->attempt(['login_id' => $request->login_id, 'password' => $request->password, 'deleted_flg' => 0], $request->remember)) {
            // return $this->sendLoginResponse($request);            

            // check member_level except
            if (Auth::user()->member_level == MEMBER_LEVEL_EXCEPT) {
                Auth::guard('web')->logout();
                return redirect()->route('login', '#a02')->with([
                    'flash_level' => "danger",
                    'flash_message' => __('horserace::be_msg.account_fail_member_level_except'),
                ]);
            }

            //get ip address
            $ip = $_SERVER['REMOTE_ADDR'];

            if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            } else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            }

            // User activity
            $arr_user_activity = [
                "ip" => $ip,
                "user_agent" => $_SERVER['HTTP_USER_AGENT'],
                'user_id' => Auth::user()->id,
            ];
            $userActivityRepositories->addLoginUser($arr_user_activity);

            // User daily login
            $arr_user_daily_login = [
                "ip" => $ip,
                "login_id" => Auth::user()->login_id,
                "user_agent" => $_SERVER['HTTP_USER_AGENT'],
                'user_id' => Auth::user()->id,
            ];
            $userDailyLoginHistoryRepositories->addDailyLoginUser($arr_user_daily_login);

            // Check user register
            if (is_null(Auth::user()->register_time)) {
                $obj_user = new User();
                $arr_user["register_time"] = \Carbon\Carbon::now()->toDateTimeString();
                $obj_user->updateUser(Auth::user()->id, $arr_user);
                if (Auth::user()->media_code == MEDIA_CODE_NEW_GTAG) {
                    Cookie::queue('check_gtag', 1, 0.1);
                }
            }
           // \Auth::logoutOtherDevices(request('password'));

            return redirect()->intended(route('home'));
        } else {
            return redirect()->route("login", '#a02')->with([
                'flash_level' => "danger",
                'flash_message' => __('horserace::be_msg.account_fail_user_name_or_password'),
            ]);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        //    $this->incrementLoginAttempts($request);
        //
        //    return $this->sendFailedLoginResponse($request);
    }

    public function logout()
    {
        Auth::guard('web')->logout();
        return redirect()->route('login');
    }

    public function loginByUserKey(Request $request,
        UserDailyLoginHistoryRepositories $userDailyLoginHistoryRepositories,
        UserActivityRepositories $userActivityRepositories,
        $user_key) {
        $obj_user = new User();
        $user = $obj_user->getUserByUserKey($user_key);
dd();
        if (is_null($user)) {
            return redirect()->route("login", '#a02')->with([
                'flash_level' => "danger",
                'flash_message' => __('horserace::be_msg.account_fail_user_name_or_password'),
            ]);
        } else {
            if (Auth::guard('web')->attempt(['login_id' => $user->login_id, 'password' => $user->password_text, 'deleted_flg' => 0], $request->remember)) {
                // check member_level except
                if (Auth::user()->member_level == MEMBER_LEVEL_EXCEPT) {
                    Auth::guard('web')->logout();
                    return redirect()->route('login', '#a02')->with([
                        'flash_level' => "danger",
                        'flash_message' => __('horserace::be_msg.account_fail_member_level_except'),
                    ]);
                }

                //get ip address
                $ip = $_SERVER['REMOTE_ADDR'];

                if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                    $ip = $_SERVER['HTTP_CLIENT_IP'];
                } else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                }

                // User activity
                $arr_user_activity = [
                    "ip" => $ip,
                    "user_agent" => $_SERVER['HTTP_USER_AGENT'],
                    'user_id' => Auth::user()->id,
                ];
                $userActivityRepositories->addLoginUser($arr_user_activity);

                // User daily login
                $arr_user_daily_login = [
                    "ip" => $ip,
                    "login_id" => Auth::user()->login_id,
                    "user_agent" => $_SERVER['HTTP_USER_AGENT'],
                    'user_id' => Auth::user()->id,
                ];
                $userDailyLoginHistoryRepositories->addDailyLoginUser($arr_user_daily_login);

                // Check user register
                if (is_null(Auth::user()->register_time)) {
                    $obj_user = new User();
                    $arr_user["register_time"] = \Carbon\Carbon::now()->toDateTimeString();
                    $obj_user->updateUser(Auth::user()->id, $arr_user);
                    if (Auth::user()->media_code == MEDIA_CODE_NEW_GTAG) {
                        Cookie::queue('check_gtag', 1, 0.1);
                    }
                }
                //\Auth::logoutOtherDevices(request('password'));

                return redirect()->intended(route('home'));
//        return $this->sendLoginResponse($request);
            }
        }
    }

    public function userKeyLogin(Request $request,
        $user_key) {
        $input = $request->all();
        $obj_user = new User();
        $user = $obj_user->getUserByUserKey($user_key);
dd($user_key);
        if (Auth::guard('web')->attempt(['login_id' => $user->login_id, 'password' => $user->password_text, 'deleted_flg' => 0], $request->remember)) {
            // check member_level except
            if (Auth::user()->member_level == MEMBER_LEVEL_EXCEPT) {
                Auth::guard('web')->logout();
                return redirect()->route('login', '#a02')->with([
                    'flash_level' => "danger",
                    'flash_message' => __('horserace::be_msg.account_fail_member_level_except'),
                ]);
            }

            switch (trim($input["c"])) {
                case "prediction-detail":
                    // Prediction detail
                    $id = trim($input["id"]);
                    return redirect()->intended(route('prediction_detail', $id));
                    break;

                case "blog-detail":
                    // Blog detail
                    $id = trim($input["id"]);
                    return redirect()->intended(route('blog_detail', $id));
                    break;

                case "result":
                    // Blog detail
                    return redirect()->intended(route('result'));
                    break;

                case "column":
                    // Blog detail
                    return redirect()->intended(route('column'));
                    break;

                default:
                    // Home
                    return redirect()->intended(route('home'));
                    break;
            }
        } else {
            return redirect()->route("login", '#a02')->with([
                'flash_level' => "danger",
                'flash_message' => __('horserace::be_msg.account_fail_user_name_or_password'),
            ]);
        }
    }
}
