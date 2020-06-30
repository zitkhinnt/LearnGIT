<?php

namespace Modules\Horserace\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class AdminLoginController extends Controller
{

  public function loginView(Request $request)
  {
    return view('horserace::backend.login.login');
  }

  public function registerView()
  {
    return view('horserace::backend.login.register');
  }

  public function forgotPasswordView(Request $request)
  {
    return view('horserace::backend.login.forgot_password');
  }

}
