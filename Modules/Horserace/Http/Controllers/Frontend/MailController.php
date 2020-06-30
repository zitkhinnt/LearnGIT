<?php
/**
 * Date: 2018-10-09
 */

namespace Modules\Horserace\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controller;
use Modules\Horserace\Repositories\MailContactRepositories;
use Modules\Horserace\Repositories\MailRepositories;
use Session;
use Auth;

class MailController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth:web');
    $this->middleware('user_activity');
  }

  public function mailBox(Request $request,
                          MailRepositories $mailRepositories)
  {
    $input = $request->all();
    $user_id = Auth::user()->id;
    $data = $mailRepositories->mailBox($user_id, $input);
    return view('horserace::frontend.mail.mail_box', compact("data"));
  }

  public function getMailInfo(Request $request,
                              MailRepositories $mailRepositories,
                              $type, $id_mail)
  {
    $user_id = Auth::user()->id;
    $data["mail"] = $mailRepositories->getMailInfo($type, $id_mail, $user_id);
    return view('horserace::frontend.mail.mail_info', compact("data"));
  }


  public function getContact(Request $request)
  {
    return view('horserace::frontend.mail.contact');
  }

  public function storeContact(Request $request,
                               MailContactRepositories $mailContactRepositories)
  {
    $input = $request->all();
    $input['user_id'] = Auth::user()->id;
    $input['mail_from_address'] = Auth::user()->mail_pc;
    $input['mail_from_name'] = Auth::user()->nickname;
    $input['mail_to_address'] = MAIL_FROM_ADDRESS;
    $input['mail_to_name'] = MAIL_FROM_NAME;
    $input['mail_title'] = MAIL_TITLE_CONTACT;
    $input['mail_body'] = trim($input["message"]);
    $input['user_read_at'] = \Carbon\Carbon::now()->toDateTimeString();

    //save mail contact
    $mailContactRepositories->mailContactStore($input);
    return view('horserace::frontend.mail.contact_comp');
  }

  public function deletedMail(Request $request,
                              MailRepositories $mailRepositories)
  {
    $input = $request->all();
    $user_id = Auth::user()->id;
    $result = $mailRepositories->feDeletedMail($user_id, $input);
    return redirect()->route("mail_box")->with([
      'flash_level' => $result["status"],
      'flash_message' => $result["message"],
    ]);
  }


}
