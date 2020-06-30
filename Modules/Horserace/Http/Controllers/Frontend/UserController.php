<?php

namespace Modules\Horserace\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controller;
use Session, Auth;
use Modules\Horserace\Repositories\UserRepositories;
use Modules\Horserace\Http\Requests\frontend\ChangeInfoUserRequest;
use Modules\Horserace\Http\Requests\frontend\ChangeMailPCUserRequest;
use Modules\Horserace\Http\Requests\frontend\ChangeMailMobileUserRequest;
use Modules\Horserace\Http\Requests\frontend\ChangePasswordUserRequest;

class UserController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth:web');
    $this->middleware('user_activity');
  }

  public function getMyPage(Request $request)
  {
    return view('horserace::frontend.user.mypage');
  }

  public function changeInfo(ChangeInfoUserRequest $request,
                             UserRepositories $userRepositories)
  {
    $input = $request->all();
    $result = $userRepositories->updateInfo($input);
    return redirect()->route('mypage')->with([
      'flash_level' => $result["status"],
      'flash_message' => $result["message"],
    ]);
  }

  public function changeMailPC(ChangeMailPCUserRequest $request,
                               UserRepositories $userRepositories)
  {
    $input = $request->all();
    $obj_user_rep = new UserRepositories();
    $result = $obj_user_rep->sendMailChangePC($input);
    return redirect()->route('mypage')->with([
      'flash_level' => $result["status"],
      'flash_message' => $result["message"],
    ]);
  }
  public function verifychangeMailPC(ChangeMailPCUserRequest $request,
  UserRepositories $userRepositories)
  {
    $input=[
      'id' => $_GET['user_id'],
      'mail_pc'=>$_GET['new_mail_pc'],
    ];
    $result = $userRepositories->updateMailPC($input);
    return redirect()->route('mypage')->with([
      'flash_level' => $result["status"],
      'flash_message' => $result["message"],
    ]);
  }

  public function changeMailMobile(ChangeMailMobileUserRequest $request,
                                   UserRepositories $userRepositories)
  {
    $input = $request->all();
    $result = $userRepositories->updateMailMobile($input);
    return redirect()->route('mypage')->with([
      'flash_level' => $result["status"],
      'flash_message' => $result["message"],
    ]);
  }

  public function changePassword(ChangePasswordUserRequest $request,
                                 UserRepositories $userRepositories)
  {
    $input = $request->all();
    $result = $userRepositories->updatePassword($input);
    return redirect()->route('mypage')->with([
      'flash_level' => $result["status"],
      'flash_message' => $result["message"],
    ]);
  }

}