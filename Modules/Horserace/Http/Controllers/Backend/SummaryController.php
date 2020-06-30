<?php

namespace Modules\Horserace\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Horserace\Entities\TransactionDeposit;
use Modules\Horserace\Entities\UserDailyAccessHistory;
use Modules\Horserace\Repositories\EntranceRepositories;
use Modules\Horserace\Repositories\TransactionGiftRepositories;
use Modules\Horserace\Repositories\TransactionPaymentRepositories;
use Modules\Horserace\Repositories\TransactionDepositRepositories;
use Modules\Horserace\Repositories\UserDailyAccessHistoryRepositories;
use Modules\Horserace\Repositories\UserDailyLoginHistoryRepositories;
use Modules\Horserace\Repositories\MediaRepositories;
use Modules\Horserace\Repositories\UserRepositories;
use Modules\Horserace\Repositories\UserStageRepositories;

class SummaryController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth:admin');
    $this->middleware('admin');
  }

  public function summaryPayment(Request $request,
                                 TransactionPaymentRepositories $transactionPaymentRepositories)
  {
    return view('horserace::backend.summary.summary_payment');
  }

  public function ajaxSummaryPayment(Request $request,
                                     TransactionPaymentRepositories $transactionPaymentRepositories)
  {
    $data = $request->all();
    $timestamp = strtotime($data['start_month']);

    $month = date('m', $timestamp);
    $year = date('Y', $timestamp);
    $day = date('d', $timestamp);

    // Daily in month
    $day_in_month = listDayInMonth($year, $month);
    $data['datetime'] = $transactionPaymentRepositories->summaryPaymentDaily($year, $month);

    $datetime = array();
    foreach ($data["datetime"] as $item) {
      $datetime[$item->date] = (array)$item;
    }
    // Set data
    foreach ($day_in_month as $item) {
      if (!isset($datetime[$item])) {
        $datetime[$item] = [
          "date" => $item,
          "total_point" => '0',
          "number_user_payment" => '0',
          "number_payment" => '0',
        ];
      }
    }
    asort($datetime);

    // Weekly
    $week_in_month = weeksInMonth($year, $month);
    $data['weekly'] = $transactionPaymentRepositories->summaryPaymentWeekly($week_in_month['start_week'], $week_in_month['end_week']);
    $weekly = array();
    $weekly["summary"] = [
      "total_point" => 0,
      "number_user_payment" => 0,
      "number_payment" => 0,
    ];

    foreach ($data["weekly"] as $item) {
      $weekly[$item->week_of_year] = (array)$item;
    }
    // Set data weekly
    foreach ($week_in_month["list_week"] as $key => $item) {
      if (isset($weekly[$key])) {
        $weekly[$key]["from"] = $item["from"];
        $weekly[$key]["to"] = $item["to"];
      } else {
        $weekly[$key]["total_point"] = 0;
        $weekly[$key]["number_user_payment"] = 0;
        $weekly[$key]["number_payment"] = 0;
        $weekly[$key]["from"] = $item["from"];
        $weekly[$key]["to"] = $item["to"];
      }
      // Summary
      $weekly["summary"]["total_point"] += $weekly[$key]["total_point"];
      $weekly["summary"]["number_user_payment"] += $weekly[$key]["number_user_payment"];
      $weekly["summary"]["number_payment"] += $weekly[$key]["number_payment"];
    }

    asort($weekly);

    // Set result
    $result['date'] = $day_in_month;
    $result['datetime'] = $datetime;
    $result['weekly'] = $weekly;
    $result['month'] = $month;
    $result['year'] = $year;
    $result['day'] = $day;

    return json_encode($result);
  }

  public function summaryDeposit(Request $request,
                                 TransactionDepositRepositories $transactionDepositRepositories)
  {
    return view('horserace::backend.summary.summary_deposit');
  }
  
  public function ajaxSummaryDeposit(
    Request $request,
    TransactionDepositRepositories $transactionDepositRepositories,
    UserDailyLoginHistoryRepositories $userDailyLoginHistoryRepositories,
    UserRepositories $userRepositories
  ) {
    $data = $request->all();
    $timestamp = strtotime($data['start_month']);
    $input['method'] = $data['method'];

    $month = date('m', $timestamp);
    $year = date('Y', $timestamp);
    $day = date('d', $timestamp);

    // Datetime in month
    $day_in_month = listDayInMonth($year, $month);
    $data['datetime'] = $transactionDepositRepositories->getDataSummaryDepositDatetime($year, $month, $input);

    $datetime = array();
    foreach ($data["datetime"] as $item) {
      $datetime[$item->date] = (array) $item;
    }
    // Set data
    foreach ($day_in_month as $item) {
      if (!isset($datetime[$item])) {
        $datetime[$item] = [
          "date" => $item,
          "total_amount" => '0',
          "total_point" => '0',
          "number_user_deposit" => '0',
          "number_deposit" => '0',
          "unit_deposit" => '0',
        ];
      } else {
        $datetime[$item]["unit_deposit"] = $datetime[$item]["number_user_deposit"] != 0 ? $datetime[$item]["total_amount"] / $datetime[$item]["number_user_deposit"] : 0;
      }
      $datetime[$item]["number_user_login"] = 0;
      $datetime[$item]["new_depositor"] = 0;
      $datetime[$item]["new_registered"] = 0;
    }

    // Set user login datetime
    $number_user_login["datetime"] = $userDailyLoginHistoryRepositories->summaryUserLoginDaily($year, $month);
    foreach ($number_user_login["datetime"] as $item) {
      $datetime[$item->date]["number_user_login"] = $item->number_user_login;
    }

    $number_user_register["datetime"] = $userRepositories->getDataSummaryRegisterDatetime($year, $month);
    foreach ($number_user_register["datetime"] as $item) {
      $datetime[$item->date]["new_registered"] = $item->number_register_user;
    }

    $number_new_depositor["datetime"] = $transactionDepositRepositories->getDataSummaryNewDepositor($year, $month);
    foreach ($number_new_depositor["datetime"] as $item) {
      $datetime[$item->date]["new_depositor"] = $item->number_user_new_deposit;
    }

    asort($datetime);

    // Weekly
    $week_in_month = weeksInMonth($year, $month);
    $data['weekly'] = $transactionDepositRepositories->getDataSummaryDepositWeekly($week_in_month['start_week'], $week_in_month['end_week'], $input);

    $weekly = array();
    $weekly["summary"] = [
      "total_amount" => 0,
      "number_user_deposit" => 0,
      "number_deposit" => 0,
      "unit_deposit" => 0,
      "number_user_login" => 0,
    ];
    foreach ($data["weekly"] as $item) {
      $weekly[$item->week_of_year] = (array) $item;
    }

    // Set data weekly
    foreach ($week_in_month["list_week"] as $key => $item) {
      if (isset($weekly[$key])) {
        $weekly[$key]["from"] = $item["from"];
        $weekly[$key]["to"] = $item["to"];
        $weekly[$key]["unit_deposit"] = $weekly[$key]["number_user_deposit"] != 0 ? $weekly[$key]["total_amount"] / $weekly[$key]["number_user_deposit"] : 0;
      } else {
        $weekly[$key]["total_amount"] = 0;
        $weekly[$key]["number_user_deposit"] = 0;
        $weekly[$key]["number_deposit"] = 0;
        $weekly[$key]["unit_deposit"] = 0;
        $weekly[$key]["from"] = $item["from"];
        $weekly[$key]["to"] = $item["to"];
      }
      // Summary
      $weekly["summary"]["total_amount"] += $weekly[$key]["total_amount"];
      $weekly["summary"]["number_user_deposit"] += $weekly[$key]["number_user_deposit"];
      $weekly["summary"]["number_deposit"] += $weekly[$key]["number_deposit"];
      $weekly["summary"]["unit_deposit"] = ($weekly["summary"]["number_user_deposit"] == 0) ? 0 : $weekly["summary"]["total_amount"] / $weekly["summary"]["number_user_deposit"];
      $weekly[$key]["number_user_login"] = 0;
    }

    // Set user login week
    $number_user_login["weekly"] = $userDailyLoginHistoryRepositories->summaryUserLoginWeekly($week_in_month['start_week'], $week_in_month['end_week']);
    foreach ($number_user_login["weekly"] as $item) {
      $weekly[$item->week_of_year]["number_user_login"] = $item->number_user_login;
      $weekly["summary"]["number_user_login"] += $item->number_user_login;
    }
    asort($weekly);

    // Set result
    $result['date'] = $day_in_month;
    $result['datetime'] = $datetime;
    $result['weekly'] = $weekly;
    $result['month'] = $month;
    $result['year'] = $year;
    $result['day'] = $day;

    return json_encode($result);
  }


  public function summaryGift(Request $request,
                              TransactionGiftRepositories $transactionGiftRepositories)
  {
    return view('horserace::backend.summary.summary_gift');
  }

  public function ajaxSummaryGift(Request $request,
                                  TransactionGiftRepositories $transactionGiftRepositories)
  {
    $data = $request->all();
    $timestamp = strtotime($data['start_month']);

    $month = date('m', $timestamp);
    $year = date('Y', $timestamp);
    $day = date('d', $timestamp);

    // Daily in month
    $day_in_month = listDayInMonth($year, $month);
    $data['datetime'] = $transactionGiftRepositories->summaryGiftDaily($year, $month);

    $datetime = array();
    foreach ($data["datetime"] as $item) {
      $datetime[$item->date] = (array)$item;
    }
    // Set data
    foreach ($day_in_month as $item) {
      if (!isset($datetime[$item])) {
        $datetime[$item] = [
          "date" => $item,
          "total_point" => '0',
          "number_user_gift" => '0',
          "number_gift" => '0',
        ];
      }
    }
    asort($datetime);

    // Weekly
    $week_in_month = weeksInMonth($year, $month);
    $data['weekly'] = $transactionGiftRepositories->summaryGiftWeekly($week_in_month['start_week'], $week_in_month['end_week']);
    $weekly = array();
    $weekly["summary"] = [
      "total_point" => 0,
      "number_user_gift" => 0,
      "number_gift" => 0,
    ];

    foreach ($data["weekly"] as $item) {
      $weekly[$item->week_of_year] = (array)$item;
    }
    // Set data weekly
    foreach ($week_in_month["list_week"] as $key => $item) {
      if (isset($weekly[$key])) {
        $weekly[$key]["from"] = $item["from"];
        $weekly[$key]["to"] = $item["to"];
      } else {
        $weekly[$key]["total_point"] = 0;
        $weekly[$key]["number_user_gift"] = 0;
        $weekly[$key]["number_gift"] = 0;
        $weekly[$key]["from"] = $item["from"];
        $weekly[$key]["to"] = $item["to"];
      }
      // Summary
      $weekly["summary"]["total_point"] += $weekly[$key]["total_point"];
      $weekly["summary"]["number_user_gift"] += $weekly[$key]["number_user_gift"];
      $weekly["summary"]["number_gift"] += $weekly[$key]["number_gift"];
    }

    asort($weekly);

    // Set result
    $result['date'] = $day_in_month;
    $result['datetime'] = $datetime;
    $result['weekly'] = $weekly;
    $result['month'] = $month;
    $result['year'] = $year;
    $result['day'] = $day;

    return json_encode($result);
  }


  public function summaryAccess(Request $request,
                                UserDailyAccessHistoryRepositories $userDailyAccessHistoryRepositories,
                                UserDailyLoginHistoryRepositories $userDailyLoginHistoryRepositories)
  {
    return view('horserace::backend.summary.summary_access');
  }

  public function ajaxSummaryAccess(Request $request,
                                    UserDailyAccessHistoryRepositories $userDailyAccessHistoryRepositories,
                                    UserDailyLoginHistoryRepositories $userDailyLoginHistoryRepositories)
  {
    $data = $request->all();
    $timestamp = strtotime($data['start_month']);

    $month = date('m', $timestamp);
    $year = date('Y', $timestamp);
    $day = date('d', $timestamp);

    $day_in_month = listDayInMonth($year, $month);
    $week_in_month = weeksInMonth($year, $month);

    /* User Login */
    // Daily in month user login
    $user_login['datetime'] = $userDailyLoginHistoryRepositories->summaryUserLoginDaily($year, $month);

    $datetime = array();
    foreach ($user_login["datetime"] as $item) {
      $datetime[$item->date] = (array)$item;
    }
    // Set data
    foreach ($day_in_month as $item) {
      if (!isset($datetime[$item])) {
        $datetime[$item] = [
          "date" => $item,
          "number_user_login" => '0',
        ];
      }
    }

    // Weekly user login
    $user_login['weekly'] = $userDailyLoginHistoryRepositories->summaryUserLoginWeekly($week_in_month['start_week'], $week_in_month['end_week']);
    $weekly = array();
    $weekly["summary"] = [
      "number_user_login" => 0,
      "number_access" => 0,
    ];

    foreach ($user_login["weekly"] as $item) {
      $weekly[$item->week_of_year] = (array)$item;
    }
    // Set data weekly
    foreach ($week_in_month["list_week"] as $key => $item) {
      if (isset($weekly[$key])) {
        $weekly[$key]["from"] = $item["from"];
        $weekly[$key]["to"] = $item["to"];
      } else {
        $weekly[$key]["number_user_login"] = 0;
        $weekly[$key]["from"] = $item["from"];
        $weekly[$key]["to"] = $item["to"];
      }
      // Summary
      $weekly["summary"]["number_user_login"] += $weekly[$key]["number_user_login"];
    }


    /* User access */
    // Daily in month user access
    $user_access['datetime'] = $userDailyAccessHistoryRepositories->summaryUserAccessDaily($year, $month);
    foreach ($user_access["datetime"] as $item) {
      $datetime[$item->date]["number_access"] = $item->number_access;
    }
    // Set data user access
    foreach ($datetime as $date => $item) {
      if (!isset($item["number_access"])) {
        $datetime[$date]["number_access"] = 0;
      }
    }

    // Weekly
    $user_access['weekly'] = $userDailyAccessHistoryRepositories->summaryUserAccessWeekly($week_in_month['start_week'], $week_in_month['end_week']);
    foreach ($user_access["weekly"] as $item) {
      $weekly[$item->week_of_year]["number_access"] = $item->number_access;
    }
    // Set data user access
    foreach ($weekly as $index => $item) {
      if (!isset($item["number_access"])) {
        $weekly[$index]["number_access"] = 0;
      }
      $weekly["summary"]["number_access"] += $weekly[$index]["number_access"];
    }

    // Result
    asort($datetime);
    asort($weekly);
    $result['date'] = $day_in_month;
    $result['datetime'] = $datetime;
    $result['weekly'] = $weekly;
    $result['month'] = $month;
    $result['year'] = $year;
    $result['day'] = $day;

    return json_encode($result);
  }

  public function summaryMedia(Request $request,
                               MediaRepositories $mediaRepositories)
  {
//    $month = 1;
//    $year = 2019;
//    $result["media"] = $mediaRepositories->summaryMedia($year, $month);
//    dd($result);
    return view('horserace::backend.summary.summary_media');
  }

  public function summaryMediaAjax(Request $request,
                                   MediaRepositories $mediaRepositories)
  {
    $data = $request->all();
    $timestamp = strtotime($data['start_month']);

    $month = date('m', $timestamp);
    $year = date('Y', $timestamp);
    $day = date('d', $timestamp);

    // Summary
    $result["media"] = $mediaRepositories->summaryMedia($year, $month);

    $result['month'] = $month;
    $result['year'] = $year;
    $result['day'] = $day;

    // Last day of month
    $last_day = date("Y-m-t", strtotime($data['start_month']));
    $result['month_end'] = date('m', strtotime($last_day));
    $result['year_end'] = date('Y', strtotime($last_day));
    $result['day_end'] = date('d', strtotime($last_day));

    return json_encode($result);
  }

  public function summaryMediaSortAjax(Request $request,
                                       MediaRepositories $mediaRepositories)
  {
    $data = $request->all();
    // Media
    if (is_null($data["media_code"]) || strlen($data["media_code"]) <= 0) {
      $media_code = null;
    } else {
      $media_code = trim($data["media_code"]);
    }

    $sort = [
      "year_start" => $data["year_start"],
      "month_start" => $data["month_start"],
      "day_start" => $data["day_start"],
      "year_end" => $data["year_end"],
      "month_end" => $data["month_end"],
      "day_end" => $data["day_end"],
      "media_code" => $media_code,
    ];

    $result["media"] = $mediaRepositories->summaryMediaSort($sort);

    $result['month'] = $data["month_start"];
    $result['year'] = $data["year_start"];
    $result['day'] = $data["day_start"];

    // Last day of month
    $result['month_end'] = $data["month_end"];
    $result['year_end'] = $data["year_end"];
    $result['day_end'] = $data["day_end"];

    return json_encode($result);
  }


  public function summaryMediaCode(Request $request,
                                   MediaRepositories $mediaRepositories,
                                   $media_code)
  {
    $input = $request->all();
    $data["default_date"] = isset($input["year"]) ?
      $input["year"] . "-" . $input["month"] . "-" . "01" : date("Y-m-d");
    $data["media_code"] = $media_code;
    $data["media"] = $mediaRepositories->getMediaByCode($media_code);

//    $result["datetime"] = $mediaRepositories->summaryMediaCode($input["year"], $input["month"], $media_code);
//    dd($result);

    return view('horserace::backend.summary.summary_media_code', compact("data"));
  }

  public function summaryMediaCodeAjax(Request $request,
                                       MediaRepositories $mediaRepositories)
  {
    $data = $request->all();
    $timestamp = strtotime($data['start_month']);

    $month = date('m', $timestamp);
    $year = date('Y', $timestamp);
    $day = date('d', $timestamp);

    $media_code = $data["media_code"];

    // Summary
    $result["datetime"] = $mediaRepositories->summaryMediaCode($year, $month, $media_code);

    $result['month'] = $month;
    $result['year'] = $year;
    $result['day'] = $day;

    return json_encode($result);
  }

  public function summaryUserStage(Request $request,
                                   UserStageRepositories $userStageRepositories)
  {
    $data["number_people"] = $userStageRepositories->summaryNumberPeople();
    return view('horserace::backend.summary.summary_user_stage', compact("data"));
  }

  public function summaryBilling(Request $request,
                                 TransactionDepositRepositories $transactionDepositRepositories)
  {
    $input = $request->all();
    $year = isset($input["year"]) ? $input["year"] : date("Y");
    $data["summary"] = $transactionDepositRepositories->summaryDepositByYear($year);
    $data["year"] = $year;
    return view('horserace::backend.summary.summary_billing', compact("data"));
  }

  public function summaryMediaRank(Request $request,
                                   MediaRepositories $mediaRepositories)
  {
    $input = $request->all();
    $type = 0;
    $data["summary"] = $mediaRepositories->summaryMediaRank($type);
    return view('horserace::backend.summary.summary_media_rank', compact("data"));
  }

  public function summaryEntrance(Request $request,
                                  EntranceRepositories $entranceRepositories)
  {
//    $year = 2018;
//    $month = 10;
//    $result["entrance"] = $entranceRepositories->summaryEntrance($year, $month);
//    dd($result);
    return view('horserace::backend.summary.summary_entrance');
  }

  public function summaryEntranceAjax(Request $request,
                                      EntranceRepositories $entranceRepositories)
  {
    $data = $request->all();
    $timestamp = strtotime($data['start_month']);

    $month = date('m', $timestamp);
    $year = date('Y', $timestamp);
    $day = date('d', $timestamp);

    // Summary
    $result["entrance"] = $entranceRepositories->summaryEntrance($year, $month);

    $result['month'] = $month;
    $result['year'] = $year;
    $result['day'] = $day;

    return json_encode($result);
  }

  public function summaryEntranceDetail(Request $request,
                                        EntranceRepositories $entranceRepositories,
                                        $entrance_id)
  {
    $input = $request->all();
    $data["default_date"] = isset($input["year"]) ?
      $input["year"] . "-" . $input["month"] . "-" . "01" : date("Y-m-d");
    $data["entrance_id"] = $entrance_id;
    $data["entrance"] = $entranceRepositories->getEditEntrance($entrance_id);

//    $result["datetime"] = $entranceRepositories->summaryEntranceDetail($input["year"], $input["month"], $entrance_id);
//    dd($result);

    return view('horserace::backend.summary.summary_entrance_detail', compact("data"));
  }

  public function summaryEntranceDetailAjax(Request $request,
                                            EntranceRepositories $entranceRepositories)
  {
    $data = $request->all();
    $timestamp = strtotime($data['start_month']);

    $month = date('m', $timestamp);
    $year = date('Y', $timestamp);
    $day = date('d', $timestamp);

    $entrance_id = $data["entrance_id"];

    // Summary
    $result["datetime"] = $entranceRepositories->summaryEntranceDetail($year, $month, $entrance_id);

    $result['month'] = $month;
    $result['year'] = $year;
    $result['day'] = $day;

    return json_encode($result);
  }

}
