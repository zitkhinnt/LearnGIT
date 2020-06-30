<?php

namespace Modules\Horserace\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Horserace\Emails\VerifyEmail;
use Modules\Horserace\Entities\Gift;
use Modules\Horserace\Entities\MailRegisterDetail;
use Modules\Horserace\Entities\MailSchedule;
use Modules\Horserace\Entities\MailTemplate;
use Modules\Horserace\Entities\Prediction;
use Modules\Horserace\Entities\TransactionDeposit;
use Modules\Horserace\Entities\TransactionPayment;
use Modules\Horserace\Entities\User;
use Modules\Horserace\Entities\UserStage;
use Modules\Horserace\Http\Controllers\Frontend\RegisterController;
use Modules\Horserace\Http\Requests\MailBanRequest;
use Modules\Horserace\Http\Requests\MailBulkRequest;
use Modules\Horserace\Http\Requests\MailScheduleRequest;
use Modules\Horserace\Http\Requests\MailTemplateRequest;
use Modules\Horserace\Repositories\EntranceRepositories;
use Modules\Horserace\Repositories\GiftRepositories;
use Modules\Horserace\Repositories\MailBanRepositories;
use Modules\Horserace\Repositories\MailBulkDetailRepositories;
use Modules\Horserace\Repositories\MailBulkRepositories;
use Modules\Horserace\Repositories\MailDepositRepositories;
use Modules\Horserace\Repositories\MailGiftRepositories;
use Modules\Horserace\Repositories\MailInterimRepositories;
use Modules\Horserace\Repositories\MailPaymentRepositories;
use Modules\Horserace\Repositories\MailPredictionOpenRepositories;
use Modules\Horserace\Repositories\MailPredictionResultRepositories;
use Modules\Horserace\Repositories\MailRegisterRepositories;
use Modules\Horserace\Repositories\MailScheduleDetailRepositories;
use Modules\Horserace\Repositories\MailScheduleRepositories;
use Modules\Horserace\Repositories\MailTemplateRepositories;
use Modules\Horserace\Repositories\MailContactRepositories;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Horserace\Repositories\MediaRepositories;
use Modules\Horserace\Repositories\PredictionTypeRepositories;
use Modules\Horserace\Repositories\UserStageRepositories;

class MailBanController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth:admin');
    $this->middleware('admin');
  }

  public function MailBan(MailBanRepositories $MailBanRepositories)
  {
    $data['list'] = $MailBanRepositories->getListMailBan();
    return view('horserace::backend.mail_ban.list_mail_ban', compact('data'));
  }

  public function editMailBan(Request $request,
                              MailBanRepositories $MailBanRepositories, $id)
  {
    $data['edit'] = $MailBanRepositories->getEditMailBan($id);
    $data['list'] = $MailBanRepositories->getListMailBan();
    return view('horserace::backend.mail_ban.edit_mail_ban', compact('data'));
  }

  public function storeMailBan(MailBanRequest $request,
                               MailBanRepositories $MailBanRepositories)
  {
    $input = $request->all();
    $result = $MailBanRepositories->MailBanStore($input);
    return redirect()->route('admin.mail_ban')->with([
      'flash_level' => $result["status"],
      'flash_message' => $result["message"],
    ]);
  }

  public function deleteMailBan(Request $request,
                                MailBanRepositories $MailBanRepositories)
  {
    $mail_ban_id = $request->id_delete;
    $result = $MailBanRepositories->MailBanDelete($mail_ban_id);
    return redirect()->route('admin.mail_ban')->with([
      'flash_level' => $result["status"],
      'flash_message' => $result["message"],
    ]);
  }

  public function mailContactToMailBan(Request $request,
                                       MailBanRepositories $MailBanRepositories)
  {
    $input = $request->all();
    $data["mail"] = trim($input["mail_pc"]);
    $data["id"] = 0;
    $result = $MailBanRepositories->MailBanStore($data);
    return redirect()->back()->with([
      'flash_level' => $result["status"],
      'flash_message' => $result["message"],
    ]);
  }

}