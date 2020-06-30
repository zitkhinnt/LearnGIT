<?php
/**
 * Date: 2018-10-09
 */

namespace Modules\Horserace\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controller;
use Modules\Horserace\Repositories\MailBanRepositories;
use Modules\Horserace\Repositories\MailContactRepositories;
use Session;

class BeforeLoginController extends Controller
{
  public function __construct()
  {

  }

  public function about(Request $request)
  {
    return view('horserace::frontend.before_login.about');
  }

  public function result(Request $request)
  {
    return view('horserace::frontend.before_login.result');
  }

  public function privacy(Request $request)
  {
    return view('horserace::frontend.before_login.privacy');
  }

  public function trans(Request $request)
  {
    return view('horserace::frontend.before_login.trans');
  }

  public function service()
  {
    return view('horserace::frontend.before_login.service');
  }
  public function entry()
  {
    return view('horserace::frontend.before_login.entry');
  }

  public function contact(Request $request)
  {
    return view('horserace::frontend.before_login.mail.contact');
  }

 public function forgetPassword(Request $request)
  {
    return view('horserace::frontend.before_login.pass');
  }
  


  public function storeContact(Request $request,
                               MailContactRepositories $mailContactRepositories,
                               MailBanRepositories $mailBanRepositories)
  {
    $input = $request->all();

    // Check mail ban
    $result = $mailBanRepositories->checkMailBan(trim($input["mail"]));

    if ($result["status"] == "success") {
      $input['user_id'] = GUEST_0;
      $input['mail_from_address'] = $input["mail"];
      $input['mail_from_name'] = GUEST_NICKNAME;
      $input['mail_to_address'] = MAIL_FROM_ADDRESS;
      $input['mail_to_name'] = MAIL_FROM_NAME;
      $input['mail_title'] = MAIL_TITLE_CONTACT;
      $input['mail_body'] = trim($input["message"]);
      $input['user_read_at'] = \Carbon\Carbon::now()->toDateTimeString();

      //save mail contact
      $mailContactRepositories->mailContactStore($input);
      return view('horserace::frontend.before_login.mail.contact_comp');
    } else {
      return redirect()->back()->withInput($request->input())
        ->with([
          "flash_level" => $result["status"],
          "flash_message" => $result["message"],
        ]);
    }

  }

}
