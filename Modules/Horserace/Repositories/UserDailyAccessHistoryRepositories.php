<?php

namespace Modules\Horserace\Repositories;

use DB;
use Modules\Horserace\Entities\Media;
use Modules\Horserace\Entities\MediaAccess;
use Modules\Horserace\Entities\TransactionDeposit;
use Modules\Horserace\Entities\UserDailyAccessHistory;
use Modules\Horserace\Entities\User;
use Modules\Horserace\Entities\UserDailyLoginHistory;

class UserDailyAccessHistoryRepositories
{
  public function createUserDailyAccessHistory($input)
  {
    $obj_user_daily_access_history = new UserDailyAccessHistory();
    $data = [
      'login_id' => $input['login_id'],
      'user_agent' => $input['user_agent'],
      'ip' => $input['ip'],
      'access_date' => $input['access_date'],
      'number_access' => $input['number_access'],
    ];
    // insert 
    $obj_user_daily_access_history->insertUserDailyAccessHistory($data);
  }

  public function updateUserDailyAccessHistory($id, $input)
  {
    $obj_user_daily_access_history = new UserDailyAccessHistory();
    // update
    $obj_user_daily_access_history->updateUserDailyAccessHistory($id, $input);
  }

  public function getUserDailyAccessHistoryByDateAndLoginId($login_id, $access_date)
  {
    $obj_user_daily_access_history = new UserDailyAccessHistory();
    $data = $obj_user_daily_access_history->getUserDailyAccessHistoryByLoginIdAndAccessDate($login_id, $access_date);
    return $data;
  }

  public function summaryUserAccessDaily($year, $month)
  {
    $obj_user_daily_access = new UserDailyAccessHistory();
    $data = $obj_user_daily_access->getSummaryUserAccessDaily($year, $month);
    return $data;
  }

  public function summaryUserAccessWeekly($start_week, $end_week)
  {
    $obj_user_daily_access = new UserDailyAccessHistory();
    $data = $obj_user_daily_access->getSummaryUserAccessWeekly($start_week, $end_week);
    return $data;
  }

  public function partnerSummaryAccess($year, $month, $media_code, $billing_flg = BILLING_FLG_DISABLE)
  {
    $obj_media = new Media();
    $obj_media_access = new MediaAccess();
    $obj_user = new User();
    $obj_user_daily_access = new UserDailyAccessHistory();
    $obj_user_login_daily = new UserDailyLoginHistory();
    $obj_trans_deposit = new TransactionDeposit();

    // $summary = $obj_user_daily_access->partnerGetSummaryUserAccess($year, $month, $media_code);

    // Summary media access
    $summary_media_access = $obj_media_access->partnerGetSummaryMediaAccess($year, $month, $media_code);
    $list_media = $obj_media->partnerGetMedia($media_code);

    // List media
    $arr_summary = array();
    $arr_summary["summary"] = [
      "user_register" => 0,
      "user_interim" => 0,
      "user_interim" => 0,
//      "unique_number" => 0,
      "number_access" => 0,
//      "average_login_count" => 0,
      "rate_login" => number_format((float)(0), 2, '.', ''),
      "payment_total" => 0,
      "payment_month" => 0,
      "number_user_login" => 0,
      "total_number_login" => 0,
    ];

    // User register
    foreach ($list_media as $item) {
      $user_register = $obj_user->countUserByMediaCodeAndTime($year, $month, $item->code);
      $user_interim = $obj_user->countUserInterimByMediaCodeAndTime($year, $month, $item->code);
      $arr_summary[$item->code] = [
        "media_id" => $item->id,
        "media_code" => $item->code,
        "user_register" => $user_register,
        "name" => $item->name,
        "link" => $item->link,
        "link_media_code" => route("partner.summary.access_detail", $item->code),
        "user_interim" => $user_interim,
//        "unique_number" => 0,
        "number_access" => 0,
//        "average_login_count" => 0,
        "rate_login" => number_format((float)(0), 2, '.', ''),
        "payment_total" => 0,
        "payment_month" => 0,
        "number_user_login" => 0,
        "total_number_login" => 0,
      ];
      $arr_summary["summary"]["user_register"] += $user_register;
      $arr_summary["summary"]["user_interim"] += $user_interim;

      // Summary buy point
      if ($billing_flg == BILLING_FLG_ENABLE) {
        $deposit_month = $obj_trans_deposit->reportTransDepositByDayInMonthByMediaCode($year, $month, $item->code);
        $deposit_total = $obj_trans_deposit->reportTransDepositTotalByMediaCode($item->code);
        $arr_summary[$item->code]["payment_month"] = is_null($deposit_month->total_amount) ? 0 :
          number_format($deposit_month->total_amount);
        $arr_summary[$item->code]["payment_total"] = is_null($deposit_total->total_amount) ? 0 :
          number_format($deposit_total->total_amount);

        $arr_summary["summary"]["payment_total"] += $deposit_total->total_amount;
        $arr_summary["summary"]["payment_month"] += $deposit_month->total_amount;
      } else {
        $arr_summary[$item->code]["payment_month"] = "_";
        $arr_summary[$item->code]["payment_total"] = "_";
      }
    }

    // Check billing flg
    if ($billing_flg == BILLING_FLG_ENABLE) {
      $arr_summary["summary"]["payment_total"] = number_format($arr_summary["summary"]["payment_total"]);
      $arr_summary["summary"]["payment_month"] = number_format($arr_summary["summary"]["payment_month"]);
    } else {
      $arr_summary["summary"]["payment_total"] = "_";
      $arr_summary["summary"]["payment_month"] = "_";
    }

    // User login
    $number_login = $obj_user_login_daily->summaryMediaNumberLoginTotal($year, $month);
    foreach ($number_login as $item) {
      $media_code = remove2ByteSpace($item->media_code);
      if (isset($arr_summary[$media_code])) {
        $arr_summary[$media_code]["number_user_login"] = $item->number_user;
        $arr_summary[$media_code]["total_number_login"] = $item->total_number_login;
        $total_user_register = $arr_summary[$media_code]["user_register"];
        $arr_summary[$media_code]["rate_login"] = $total_user_register == 0 ?
          number_format((float)(0), 2, '.', '') :
          number_format(((float)($item->total_number_login / $total_user_register)), 2, '.', '');
        // Summary
        $arr_summary["summary"]["number_user_login"] += $item->number_user;
        $arr_summary["summary"]["total_number_login"] += $item->total_number_login;
      }
    }

    // rate login
    $total_user_register = $arr_summary["summary"]["user_register"];
    $arr_summary["summary"]["rate_login"] = $total_user_register == 0 ?
      number_format((float)(0), 2, '.', '') :
      number_format(((float)($arr_summary["summary"]["total_number_login"] / $total_user_register)), 2, '.', '');

    // Summary media access
    foreach ($summary_media_access as $item) {
      $arr_summary[$item->media_code]["number_access"] = $item->number_access;
      $arr_summary["summary"]["number_access"] += $item->number_access;
    }

    return $arr_summary;
  }

  public function partnerSummaryAccessSort($input)
  {
    // Period time
    $year_start = $input["year_start"];
    $month_start = $input["month_start"];
    $day_start = $input["day_start"];

    $year_end = $input["year_end"];
    $month_end = $input["month_end"];
    $day_end = $input["day_end"];

    $time_start = $year_start . "-" . $month_start . "-" . $day_start. " 00:00:00";
    $time_end = $year_end . "-" . $month_end . "-" . $day_end. " 23:59:59";

    $media_code = $input["media_code"];
    $billing_flg = $input["billing_flg"];

    //
    $obj_media = new Media();
    $obj_media_access = new MediaAccess();
    $obj_user = new User();
    $obj_user_daily_access = new UserDailyAccessHistory();
    $obj_user_login_daily = new UserDailyLoginHistory();
    $obj_trans_deposit = new TransactionDeposit();

    $list_media = $obj_media->partnerGetMedia($media_code);

    // Summary media access
    $summary_media_access = $obj_media_access->partnerGetSummaryMediaAccessPeriod($time_start, $time_end, $media_code);

    // List media
    $arr_summary = array();
    $arr_summary["summary"] = [
      "user_register" => 0,
      "user_interim" => 0,
      "user_interim" => 0,
//      "unique_number" => 0,
      "number_access" => 0,
//      "average_login_count" => 0,
      "rate_login" => number_format((float)(0), 2, '.', ''),
      "payment_total" => 0,
      "payment_month" => 0,
      "number_user_login" => 0,
      "total_number_login" => 0,
    ];

    // User register
    foreach ($list_media as $item) {
      $user_register = $obj_user->countUserByMediaCodePeriod($time_start, $time_end, $item->code);
      $user_interim = $obj_user->countUserInterimByMediaCodePeriodTime($time_start, $time_end, $item->code);
      $arr_summary[$item->code] = [
        "media_id" => $item->id,
        "media_code" => $item->code,
        "user_register" => $user_register,
        "name" => $item->name,
        "link" => $item->link,
        "link_media_code" => route("partner.summary.access_detail", $item->code),
        "user_interim" => $user_interim,
//        "unique_number" => 0,
        "number_access" => 0,
//        "average_login_count" => 0,
        "rate_login" => number_format((float)(0), 2, '.', ''),
        "payment_total" => 0,
        "payment_month" => 0,
        "number_user_login" => 0,
        "total_number_login" => 0,
      ];
      $arr_summary["summary"]["user_register"] += $user_register;
      $arr_summary["summary"]["user_interim"] += $user_interim;

      // Summary buy point
      if ($billing_flg == BILLING_FLG_ENABLE) {
        $deposit_month = $obj_trans_deposit->reportTransDepositByMediaCodePeriod($time_start, $time_end, $item->code);
        $deposit_total = $obj_trans_deposit->reportTransDepositTotalByMediaCode($item->code);
        $arr_summary[$item->code]["payment_month"] = is_null($deposit_month->total_amount) ? 0 :
          number_format($deposit_month->total_amount);
        $arr_summary[$item->code]["payment_total"] = is_null($deposit_total->total_amount) ? 0 :
          number_format($deposit_total->total_amount);

        $arr_summary["summary"]["payment_total"] += $deposit_total->total_amount;
        $arr_summary["summary"]["payment_month"] += $deposit_month->total_amount;
      } else {
        $arr_summary[$item->code]["payment_month"] = "_";
        $arr_summary[$item->code]["payment_total"] = "_";
      }
    }

    // Check billing flg
    if ($billing_flg == BILLING_FLG_ENABLE) {
      $arr_summary["summary"]["payment_total"] = number_format($arr_summary["summary"]["payment_total"]);
      $arr_summary["summary"]["payment_month"] = number_format($arr_summary["summary"]["payment_month"]);
    } else {
      $arr_summary["summary"]["payment_total"] = "_";
      $arr_summary["summary"]["payment_month"] = "_";
    }

    // User login
    $number_login = $obj_user_login_daily->summaryMediaNumberLoginTotalPeriod($time_start, $time_end);
    foreach ($number_login as $item) {
      $media_code = remove2ByteSpace($item->media_code);
      if (isset($arr_summary[$media_code])) {
        $arr_summary[$media_code]["number_user_login"] = $item->number_user;
        $arr_summary[$media_code]["total_number_login"] = $item->total_number_login;
        $total_user_register = $arr_summary[$media_code]["user_register"];
        $arr_summary[$media_code]["rate_login"] = $total_user_register == 0 ?
          number_format((float)(0), 2, '.', '') :
          number_format(((float)($item->total_number_login / $total_user_register)), 2, '.', '');
        // Summary
        $arr_summary["summary"]["number_user_login"] += $item->number_user;
        $arr_summary["summary"]["total_number_login"] += $item->total_number_login;
      }
    }

    // rate login
    $total_user_register = $arr_summary["summary"]["user_register"];
    $arr_summary["summary"]["rate_login"] = $total_user_register == 0 ?
      number_format((float)(0), 2, '.', '') :
      number_format(((float)($arr_summary["summary"]["total_number_login"] / $total_user_register)), 2, '.', '');

    // Summary media access
    foreach ($summary_media_access as $item) {
      $arr_summary[$item->media_code]["number_access"] = $item->number_access;
      $arr_summary["summary"]["number_access"] += $item->number_access;
    }

    return $arr_summary;
  }

  public function partnerSummaryAccessDaily($year, $month, $media_code)
  {
    $obj_user_daily_access = new UserDailyAccessHistory();
    $obj_user = new User();
    $obj_media_access = new MediaAccess();
    $obj_user_login_daily = new UserDailyLoginHistory();
    $total_user_register = $obj_user->countUserByMediaCodeAndTime($year, $month, $media_code);
    $day_in_month = listDayInMonth($year, $month);

    $datetime = array();
    // Set data summary media
    foreach ($day_in_month as $item) {
      $datetime[$item] = [
        "date" => $item,
        "user_register" => 0,
        "user_interim" => 0,
        "number_access" => 0,
        "rate_login" => 0,
        "user_register" => 0,
        "number_user_login" => 0,
        "total_number_login" => 0,
      ];
    }

    $datetime["summary"] = [
      "user_register" => 0,
      "user_interim" => 0,
      "number_access" => 0,
      "rate_login" => 0,
      "user_register" => 0,
      "number_user_login" => 0,
      "total_number_login" => 0,
    ];

    // User register daily in month
    $list_user_daily = $obj_user->countUserByMediaCodeDaily($year, $month, $media_code);

    foreach ($list_user_daily as $item) {
      $datetime[$item->date]["user_register"] = $item->user_register;
      // Summary
      $datetime["summary"]["user_register"] += (integer)$item->user_register;
    }

    // User interim
    $list_interim_daily = $obj_user->userInterimByMediaCodeDaily($year, $month, $media_code);
    foreach ($list_interim_daily as $item) {
      $datetime[$item->date]["user_interim"] = (integer)$item->user_register;
      // Summary
      $datetime["summary"]["user_interim"] += (integer)$item->user_register;
    }

    // Summary number access
    $media_access["datetime"] = $obj_media_access->numberMediaAccessDaily($year, $month, $media_code);
    foreach ($media_access["datetime"] as $item) {
      $datetime[$item->date]["number_access"] = (integer)$item->number_access;
      // Summary
      $datetime["summary"]["number_access"] += (integer)$item->number_access;
    }

    // Number login
    $number_login = $obj_user_login_daily->summaryMediaCodeNumberLoginDailyTotal($year, $month, $media_code);
    foreach ($number_login as $item) {
      $datetime[$item->date]["number_user_login"] = $item->number_user;
      $datetime[$item->date]["total_number_login"] = number_format((float)($item->total_number_login), 2, '.', '');
      // Summary
      $datetime["summary"]["number_user_login"] += $item->number_user;
      $datetime["summary"]["total_number_login"] += $item->total_number_login;
    }

    // rate login
    $total_user_register = $datetime["summary"]["user_register"];
    $datetime["summary"]["rate_login"] = $total_user_register == 0 ?
      number_format((float)(0), 2, '.', '') :
      number_format(((float)($datetime["summary"]["total_number_login"] / $total_user_register)), 2, '.', '');

    ksort($datetime);

    return $datetime;
  }

  public function sumUserAccessHistorybyUser($id)
  {
    $results = DB::table('user_daily_access_history')->where('user_id', $id)->orderBy('access_date', 'DESC')->get();

    $last_access_date = $results[0]->updated_at ?? '';
    $total_number_access = 0;

    foreach ($results as $access) {
      $total_number_access += $access->number_access;
    }


    return[
      'last_access_date' => $last_access_date,
      'total_number_access' => $total_number_access
    ];
  }
}