<?php

namespace Modules\Horserace\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Horserace\Entities\TransactionDeposit;
use Modules\Horserace\Entities\TransactionPayment;
use Modules\Horserace\Entities\User;
use Modules\Horserace\Entities\UserDailyAccessHistory;
use Modules\Horserace\Entities\UserDailyLoginHistory;
use Modules\Horserace\Repositories\MailContactRepositories;
use Modules\Horserace\Repositories\MailReplaceRepositories;

class DashboardController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth:admin');
    $this->middleware('admin');
  }

  public function dashboardView(Request $request,
                                MailReplaceRepositories $mailReplaceRepositories,
                                MailContactRepositories $mailContactRepositories)
  {
    // Replace
    $list_mail_replace = $mailReplaceRepositories->getListMailReplace();
    $request->session()->put('mail_replace', $list_mail_replace);

    // Mail unread
    $mail_unread = $mailContactRepositories->numberMailContactUnread();
    $request->session()->put('number_mail_unread', $mail_unread);

    // Get info system
    $obj_user = new User();
    $obj_user_daily_login = new UserDailyLoginHistory();
    $obj_trans_payment = new TransactionPayment();
    $obj_trans_deposit = new TransactionDeposit();

    $date = \Carbon\Carbon::now()->toDateTimeString();
    $date_format = date("Y-m-d", strtotime($date));

    // Total user
    $total_user = $obj_user->countUser();
    // User login today
    $user_login = $obj_user_daily_login->countUserLoginToday($date_format);
    $rate_user = $total_user == 0 ? 0 : number_format(((float)($user_login / $total_user) * 100), 2, '.', '');

    // Total user access
    $obj_user_daily_access = new UserDailyAccessHistory();
    $user_access = $obj_user_daily_access->countUserAccessToday($date_format);
    $rate_access = $total_user == 0 ? 0 : number_format(((float)($user_access / $total_user) * 100), 2, '.', '');

    // Payment
    $payment = $obj_trans_payment->paymentToday($date_format);

    // Deposit
    $deposit = $obj_trans_deposit->depositToday($date_format);

    $data["number_payment"] = $payment["number_payment"];
    $data["payment_point"] = $payment["total_point"];
    $data["deposit_amount"] = $deposit["total_amount"];
    $data["deposit_point"] = $deposit["total_point"];
    $data["rate_user"] = $rate_user;
    $data["user_login"] = $user_login;
    $data["total_user"] = $total_user;
    $data["rate_access"] = $rate_access;
    $data["user_access"] = $user_access;
    return view('horserace::backend.home.dashboard', compact("data"));

  }

  public function holiday(Request $request)
  {
    $contents = file_get_contents(public_path('holiday.sh'));
    $contents = shell_exec($contents);
    $arr_holiday = explode("\r\n", $contents);
    $result = array();
    foreach ($arr_holiday as $item) {
      if (strlen($item) > 0) {
        $holiday = explode(" ", $item);
        $year = substr($holiday[0], 0, 4);
        $month = substr($holiday[0], 4, 2);
        $day = substr($holiday[0], 6, 2);
        $result[] = [
          'title' => $holiday[1],
          'start' => $year . '-' . $month . '-' . $day,
        ];
      }
    }

    return json_encode($result);

  }

}
