<?php

namespace Modules\Horserace\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Modules\Horserace\Http\Requests\AdminLoginRequest;
use Session;

class AdminLoginController extends Controller
{
  protected $redirectTo = '/admin/dashboard';

  public function __construct()
  {
    // $this->middleware('guest:admin')->except('logout');
  }

  public function showLoginForm()
  {
    return view('horserace::backend.login.login');
  }

  public function login(AdminLoginRequest $request)
  {
    // Attemp to log the user in
    if (Auth::guard('admin')->attempt(['login_id' => $request->login_id, 'password' => $request->password, 'deleted_flg' => 0], $request->remember)) {
      // If successful, then redirect to there intend location

      switch (Auth::guard('admin')->user()->role_code) {
        case ROLE_ADMIN:
        case ROLE_STAFF:
          return redirect()->intended(route('admin.dashboard'));
          break;

        case ROLE_PARTNER:
          return redirect()->intended(route('partner.summary.access'));
          break;
      }

    } else {
      return redirect()->route("admin.login")->with([
        'flash_level' => "danger",
        'flash_message' => __('horserace::be_msg.account_fail_user_name_or_password')
      ]);
    }

    // if unsuccessful,, then redirect back to the login with the form data.
    // return redirect()->back()->withInput($request->only('email', 'remember'));
  }

  public function logout()
  {
    Auth::guard('admin')->logout();
    return redirect()->intended(route('admin.login'));
  }
}
