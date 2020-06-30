<?php
/**
 * Date: 2018-10-09
 */

namespace Modules\Horserace\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controller;
use Modules\Horserace\Entities\User;
use Session;
use Auth;

class LoginController extends Controller
{
  public function __construct()
  {

  }

  public function userKeyLogin(Request $request,
                               $user_key)
  {
    $input = $request->all();
    $obj_user = new User();
    $user = $obj_user->getUserByUserKey($user_key);

    if ($user && Auth::guard('web')->attempt(['login_id' => $user->login_id, 'password' => $user->password_text, 'deleted_flg' => 0], $request->remember)) {
      $controller = isset($input["c"]) ? trim($input["c"]) : "";
      
      switch ($controller) {
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
        'flash_message' => __('horserace::be_msg.account_fail_user_name_or_password')
      ]);
    }
  }

  public function getLogin(Request $request)
  {
    return view('horserace::frontend.login.login');
  }


}
