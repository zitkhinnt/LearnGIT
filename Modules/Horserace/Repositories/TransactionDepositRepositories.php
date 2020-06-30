<?php

namespace Modules\Horserace\Repositories;

use DB;
use DateTime;
use hasFile;
use Modules\Horserace\Entities\TransactionDeposit;
use Modules\Horserace\Entities\User;

class TransactionDepositRepositories
{
  public function transactionDepositStore($input)
  {
    $obj_transaction_deposit = new TransactionDeposit();
    $arr_transaction_deposit = [
      'user_id' => trim($input['user_id']),
      'login_id' => trim($input['login_id']),
      'method' => trim($input['method']),
      'member_level' => trim($input['member_level']),
      'point' => trim($input['point']),
      'amount' => trim($input['amount']),
    ];

    $obj_transaction_deposit->insertTransactionDeposit($arr_transaction_deposit);
    $result = [
      "status" => "success",
      "message" => __("horserace::be_msg.add_transaction_deposit_success"),
    ];
    return $result;
  }

  public function transDepositStoreGetId($input)
  {
    $obj_transaction_deposit = new TransactionDeposit();
    $arr_transaction_deposit = [
      'user_id' => trim($input['user_id']),
      'login_id' => trim($input['login_id']),
      'method' => trim($input['method']),
      'member_level' => trim($input['member_level']),
      'point' => trim($input['point']),
      'amount' => trim($input['amount']),
    ];

    $trans_id = $obj_transaction_deposit->insertTransactionDepositGetId($arr_transaction_deposit);
    return $trans_id;
  }

  public function getListTransactionDeposit()
  {
    $obj_transaction_deposit = new TransactionDeposit();
    $list_transaction_deposit = $obj_transaction_deposit->getTransactionDeposit();
    return $list_transaction_deposit;
  }

  public function getListTransactionDepositAjax($input)
  {
    $obj_transaction_deposit = new TransactionDeposit();
    $list_transaction_deposit = $obj_transaction_deposit->getSearchTransactionDeposit($input);
    return $list_transaction_deposit;
  }

  public function transactionDepositDelete($id)
  {
    $obj_transaction_deposit = new TransactionDeposit();
    $obj_transaction_deposit->deleteTransactionDeposit($id);
    $result = [
      "status" => "success",
      "message" => __("horserace::be_msg.deleted_transaction_deposit_success"),
    ];
    return $result;
  }

  public function changeStatusTransDeposit($input)
  {

    $obj_transaction_deposit = new TransactionDeposit();
    $obj_user_activity_repositories = new UserActivityRepositories();

    // Deleted transaction deposit
    if (isset($input["deleted_flg"])) {
      $obj_transaction_deposit->deleteTransactionDeposit(trim($input["id"]));
      $result = [
        "status" => "success",
        "message" => __("horserace::be_msg.deleted_transaction_deposit_success"),
      ];
      return $result;
    }

    // Update status
    $arr_trans_deposit = [
      "amount_pay" => trim($input["amount"]),
      "status" => trim($input["status"]),
      "payment_at" => \Carbon\Carbon::now()->toDateTimeString()
    ];
    $obj_transaction_deposit->updateTransactionDeposit(trim($input["id"]), $arr_trans_deposit);

    // Add point for user
    if (trim($input["status"]) == APPLY) {
      $obj_user_activity_repositories->depositPoint(trim($input["user_id"]), trim($input["point"]), trim($input["amount"]));
    }

    $result = [
      "status" => "success",
      "message" => __("horserace::be_msg.change_status_deposit_success"),
    ];
    return $result;
  }

  public function getDataSummaryDepositDatetime($year, $month, $input)
  {
    $obj_transaction_deposit = new TransactionDeposit();
    $data = $obj_transaction_deposit->reportTransactionDepositByDayInMonth($year, $month, $input);
    return $data;
  }

  public function getDataSummaryDepositWeekly($start_week, $end_week, $input)
  {
    $obj_transaction_deposit = new TransactionDeposit();
    $data = $obj_transaction_deposit->reportTransactionDepositByWeek($start_week, $end_week, $input);
    return $data;
  }

  public function summaryDepositByYear($year)
  {
    $obj_transaction_deposit = new TransactionDeposit();
    $obj_user = new User();

    // Month
    $arr_summary_month = array();
    for ($i = 1; $i <= 12; $i++) {
      $arr_summary_month[$i] = [
        "month" => $i,
        "number_amount" => 0,
        "number_trans" => 0,
        "user_deposit" => 0,
        "user_deposit_1" => 0,
        "user_deposit_rate_1" => 0,
        "user_deposit_2" => 0,
        "user_deposit_rate_2" => 0,
        "user_deposit_3" => 0,
        "user_deposit_rate_3" => 0,
        "user_deposit_4" => 0,
        "user_deposit_rate_4" => 0,
        "user_register" => $obj_user->countUserRegisterTime($year, $i),
        "new_deposit" => 0,
        "user_deposit_first" => 0,
        "charging_rate" => 0,
      ];
    }

    $user_deposit = array();
    $amount = array();
    $trans = array();
    $user_deposit_first = array();
    $user_deposit_1 = array();
    $user_deposit_2 = array();
    $user_deposit_3 = array();
    $user_deposit_4 = array();

    $user_deposit_temp = array();

    // Summary trans
    $trans_deposit = $obj_transaction_deposit->summaryDepositByYear($year);

    // User deposit
    foreach ($trans_deposit as $item) {
      $user = $obj_user->getDetailUserById($item->user_id);

      if(!$user) continue;

      $month = date("m", strtotime($item->updated_at));
      // User deposit
      if (!isset($user_deposit[(integer)$month][$item->user_id])) {
        $user_deposit[(integer)$month][$item->user_id] = $item->user_id;
      }

      // Amount user
      if (!isset($user_deposit_temp[(integer)$month][$item->user_id])) {
        $user_deposit_temp[(integer)$month][$item->user_id] = [
          "user_id" => $item->user_id,
          "total_amount" => $item->amount_pay,
        ];
      } else {
        $user_deposit_temp[(integer)$month][$item->user_id]["total_amount"] += $item->amount_pay;
      }

      // Amount
      if (!isset($amount[(integer)$month])) {
        $amount[(integer)$month] = $item->amount_pay;
      } else {
        $amount[(integer)$month] += $item->amount_pay;
      }

      // Deposit
      if (!isset($trans[(integer)$month])) {
        $trans[(integer)$month] = 1;
      } else {
        $trans[(integer)$month] += 1;
      }

      // User deposit first
      $datetime1 = new DateTime($user->first_deposit_time);
      $datetime2 = new DateTime($item->updated_at);
      $interval = $datetime1->diff($datetime2);
      if ((integer)$interval->d == 0 &&
        (!isset($user_deposit_first[(integer)$month][$item->user_id]))) {
        $user_deposit_first[(integer)$month][$item->user_id] = $item->user_id;
      }
    }

    foreach ($user_deposit_temp as $month => $info_user) {
      foreach ($info_user as $item) {
        // User deposit rate 1
        if (!isset($user_deposit_1[(integer)$month][$item["user_id"]]) &&
          ($item["total_amount"] > 0 && $item["total_amount"] <= 30000)) {
          $user_deposit_1[(integer)$month][$item["user_id"]] = $item["user_id"];
        }

        // User deposit rate 2
        if (!isset($user_deposit_2[(integer)$month]["user_id"]) &&
          ($item["total_amount"] > 30000 && $item["total_amount"] <= 60000)) {
          $user_deposit_2[(integer)$month][$item["user_id"]] = $item["user_id"];
        }

        // User deposit rate 3
        if (!isset($user_deposit_3[(integer)$month]["user_id"]) &&
          ($item["total_amount"] > 60000 && $item["total_amount"] <= 100000)) {
          $user_deposit_3[(integer)$month][$item["user_id"]] = $item["user_id"];
        }

        // User deposit rate 4
        if (!isset($user_deposit_4[(integer)$month]["user_id"]) &&
          ($item["total_amount"] > 100000)) {
          $user_deposit_4[(integer)$month][$item["user_id"]] = $item["user_id"];
        }
      }
    }

    // Calculate rate
    foreach ($arr_summary_month as $month => $item) {
      $arr_summary_month[$month]["number_amount"] = isset($amount[(integer)$month]) ?
        $amount[(integer)$month] : 0;
      $arr_summary_month[$month]["number_trans"] = isset($trans [(integer)$month]) ?
        $trans[(integer)$month] : 0;

      // User deposit
      $number_user_deposit = isset($user_deposit[(integer)$month]) ?
        count($user_deposit[(integer)$month]) : 0;
      $arr_summary_month[$month]["user_deposit"] = $number_user_deposit;

      // User deposit 1
      $number_user_deposit_1 = isset($user_deposit_1[(integer)$month]) ?
        count($user_deposit_1[(integer)$month]) : 0;
      $arr_summary_month[$month]["user_deposit_1"] = $number_user_deposit_1;
      $arr_summary_month[$month]["user_deposit_rate_1"] = $number_user_deposit == 0 ?
        number_format((float)(0), 2, '.', '') :
        number_format(((float)($number_user_deposit_1 / $number_user_deposit) * 100), 2, '.', '');

      // User deposit 2
      $number_user_deposit_2 = isset($user_deposit_2[(integer)$month]) ?
        count($user_deposit_2[(integer)$month]) : 0;
      $arr_summary_month[$month]["user_deposit_2"] = $number_user_deposit_2;
      $arr_summary_month[$month]["user_deposit_rate_2"] = $number_user_deposit == 0 ?
        number_format((float)(0), 2, '.', '') :
        number_format(((float)($number_user_deposit_2 / $number_user_deposit) * 100), 2, '.', '');

      // User deposit 3
      $number_user_deposit_3 = isset($user_deposit_3[(integer)$month]) ?
        count($user_deposit_3[(integer)$month]) : 0;
      $arr_summary_month[$month]["user_deposit_3"] = $number_user_deposit_3;
      $arr_summary_month[$month]["user_deposit_rate_3"] = $number_user_deposit == 0 ?
        number_format((float)(0), 2, '.', '') :
        number_format(((float)($number_user_deposit_3 / $number_user_deposit) * 100), 2, '.', '');

      // User deposit 4
      $number_user_deposit_4 = isset($user_deposit_4[(integer)$month]) ?
        count($user_deposit_4[(integer)$month]) : 0;
      $arr_summary_month[$month]["user_deposit_4"] = $number_user_deposit_4;
      $arr_summary_month[$month]["user_deposit_rate_4"] = $number_user_deposit == 0 ?
        number_format((float)(0), 2, '.', '') :
        number_format(((float)($number_user_deposit_4 / $number_user_deposit) * 100), 2, '.', '');

      // User deposit first
      $arr_summary_month[$month]["user_deposit_first"] = isset($user_deposit_first[(integer)$month]) ?
        count($user_deposit_first[(integer)$month]) : 0;

      // Charging rate
      $total_user_first_deposit = $arr_summary_month[$month]["user_deposit_first"];
      $total_user = $arr_summary_month[$month]["user_register"];
      $arr_summary_month[$month]["charging_rate"] =
        $total_user == 0 ? number_format((float)(0), 2, '.', '') :
          number_format(((float)($total_user_first_deposit / $total_user) * 100), 2, '.', '');
    }

    // Summary
    foreach ($arr_summary_month as $month => $item) {
      // number_amount
      if (!isset($arr_summary_month["summary"]["number_amount"])) {
        $arr_summary_month["summary"]["number_amount"] = $item["number_amount"];
      } else {
        $arr_summary_month["summary"]["number_amount"] += $item["number_amount"];
      }
      // number_trans
      if (!isset($arr_summary_month["summary"]["number_trans"])) {
        $arr_summary_month["summary"]["number_trans"] = $item["number_trans"];
      } else {
        $arr_summary_month["summary"]["number_trans"] += $item["number_trans"];
      }
      // user_deposit
      if (!isset($arr_summary_month["summary"]["user_deposit"])) {
        $arr_summary_month["summary"]["user_deposit"] = $item["user_deposit"];
      } else {
        $arr_summary_month["summary"]["user_deposit"] += $item["user_deposit"];
      }
      // user_deposit_1
      if (!isset($arr_summary_month["summary"]["user_deposit_1"])) {
        $arr_summary_month["summary"]["user_deposit_1"] = $item["user_deposit_1"];
      } else {
        $arr_summary_month["summary"]["user_deposit_1"] += $item["user_deposit_1"];
      }
      // user_deposit_2
      if (!isset($arr_summary_month["summary"]["user_deposit_2"])) {
        $arr_summary_month["summary"]["user_deposit_2"] = $item["user_deposit_2"];
      } else {
        $arr_summary_month["summary"]["user_deposit_2"] += $item["user_deposit_2"];
      }
      // user_deposit_3
      if (!isset($arr_summary_month["summary"]["user_deposit_3"])) {
        $arr_summary_month["summary"]["user_deposit_3"] = $item["user_deposit_3"];
      } else {
        $arr_summary_month["summary"]["user_deposit_3"] += $item["user_deposit_3"];
      }
      // user_deposit_4
      if (!isset($arr_summary_month["summary"]["user_deposit_4"])) {
        $arr_summary_month["summary"]["user_deposit_4"] = $item["user_deposit_4"];
      } else {
        $arr_summary_month["summary"]["user_deposit_4"] += $item["user_deposit_4"];
      }
      // user_deposit_first
      if (!isset($arr_summary_month["summary"]["user_deposit_first"])) {
        $arr_summary_month["summary"]["user_deposit_first"] = $item["user_deposit_first"];
      } else {
        $arr_summary_month["summary"]["user_deposit_first"] += $item["user_deposit_first"];
      }
      // user_register
      if (!isset($arr_summary_month["summary"]["user_register"])) {
        $arr_summary_month["summary"]["user_register"] = $item["user_register"];
      } else {
        $arr_summary_month["summary"]["user_register"] += $item["user_register"];
      }
    }

    // Calculate rate summary
    $summary_user_deposit = $arr_summary_month["summary"]["user_deposit"];
    // user deposit 1
    $summary_user_deposit_1 = $arr_summary_month["summary"]["user_deposit_1"];
    $arr_summary_month["summary"]["user_deposit_rate_1"] = $summary_user_deposit == 0 ?
      number_format((float)(0), 2, '.', '') :
      number_format(((float)($summary_user_deposit_1 / $summary_user_deposit) * 100), 2, '.', '');

    // user deposit 2
    $summary_user_deposit_2 = $arr_summary_month["summary"]["user_deposit_2"];
    $arr_summary_month["summary"]["user_deposit_rate_2"] = $summary_user_deposit == 0 ?
      number_format((float)(0), 2, '.', '') :
      number_format(((float)($summary_user_deposit_2 / $summary_user_deposit) * 100), 2, '.', '');

    // user deposit 3
    $summary_user_deposit_3 = $arr_summary_month["summary"]["user_deposit_3"];
    $arr_summary_month["summary"]["user_deposit_rate_3"] = $summary_user_deposit == 0 ?
      number_format((float)(0), 2, '.', '') :
      number_format(((float)($summary_user_deposit_3 / $summary_user_deposit) * 100), 2, '.', '');

    // user deposit 4
    $summary_user_deposit_4 = $arr_summary_month["summary"]["user_deposit_4"];
    $arr_summary_month["summary"]["user_deposit_rate_4"] = $summary_user_deposit == 0 ?
      number_format((float)(0), 2, '.', '') :
      number_format(((float)($summary_user_deposit_4 / $summary_user_deposit) * 100), 2, '.', '');

    // summary Charging rate
    $summary_user_first_deposit = $arr_summary_month["summary"]["user_deposit_first"];
    $summary_user_register = $arr_summary_month["summary"]["user_register"];
    $arr_summary_month["summary"]["charging_rate"] =
      $summary_user_register == 0 ? number_format((float)(0), 2, '.', '') :
        number_format(((float)($summary_user_first_deposit / $summary_user_register) * 100), 2, '.', '');

    return $arr_summary_month;
  }

  public function summaryDepositPeriodTime($time_reg_start, $time_deposit_start, $time_reg_end, $time_deposit_end)
  {
    return DB::table('users')
    ->select(DB::raw('count(DISTINCT td.user_id) as total_user_deposit,
      users.media_code,
      SUM(td.amount_pay) as total_amount,
      count(td.id) as total_deposit '))
    ->join('transaction_deposit as td', 'users.id', '=', 'td.user_id')
    ->where('td.deleted_flg', DELETED_DISABLE)
      ->where('td.status', APPLY)
      ->where('td.updated_at', '>=', $time_deposit_start)
      ->where('td.updated_at', '<=', $time_deposit_end)
      ->where('users.register_time', '>=', $time_reg_start)
      ->where('users.register_time', '<=', $time_reg_end)
      ->where('users.deleted_flg', DELETED_DISABLE)
      ->groupBy('users.media_code')
      ->get()
      ->toArray();
  }

  public function summaryDepositPeriodOver3Month($time_reg_start, $time_deposit_start, $time_reg_end, $time_deposit_end)
  {
    return DB::table('users')
    ->select(DB::raw('count(DISTINCT td.user_id) as total_user_deposit,
      users.media_code,
      SUM(td.amount_pay) as total_amount,
      count(td.id) as total_deposit '))
      ->join('transaction_deposit as td', 'users.id', '=', 'td.user_id')
      ->where('td.deleted_flg', DELETED_DISABLE)
      ->where('td.status', APPLY)
      ->where('td.updated_at', '>=', $time_deposit_start)
      ->where('td.updated_at', '<=', $time_deposit_end)
      ->where('users.register_time', '<=', $time_reg_end)
      ->where('users.deleted_flg', DELETED_DISABLE)
      ->groupBy('users.media_code')
      ->get()
      ->toArray();
  }

  public function summaryMediaDepositTotalPeriod($time_start, $time_end)
  {
    return DB::table('users')
    ->select(DB::raw('count(DISTINCT td.user_id) as total_user_deposit,
      users.media_code,
      SUM(td.amount_pay) as total_amount,
      count(td.id) as total_deposit '))
    ->join('transaction_deposit as td', 'users.id', '=', 'td.user_id')
    ->where('td.deleted_flg', DELETED_DISABLE)
      ->where('td.status', APPLY)
      ->where('td.updated_at', '>=', $time_start)
      ->where('td.updated_at', '<=', $time_end)
      ->where('users.deleted_flg', DELETED_DISABLE)
      ->groupBy('users.media_code')
      ->get()
      ->toArray();
  }

  public function getDataSummaryNewDepositor($year, $month)
  {
    $obj_transaction_deposit = new TransactionDeposit();
    $data = $obj_transaction_deposit->summaryNewPaymentUserByDate($year, $month);
    return $data;
  }

  public function summaryDepositDistanceMonthGroupByMedia($year_register, $year_deposit, $month_register, $month_deposit)
  {
    return DB::table('users')
    ->select(DB::raw('count(DISTINCT td.user_id) as total_user_deposit,
      users.media_code,
      SUM(td.amount_pay) as total_amount,
      count(td.id) as total_deposit '))
    ->join('transaction_deposit as td', 'users.id', '=', 'td.user_id')
    ->where('td.status', APPLY)
      ->where('td.deleted_flg', DELETED_DISABLE)
      ->whereRaw('YEAR(td.updated_at) =' . $year_deposit . ' AND MONTH(td.updated_at) =' . $month_deposit)
      ->whereRaw('YEAR(users.register_time) =' . $year_register . ' AND MONTH(users.register_time) =' . $month_register)
      ->where('users.deleted_flg', DELETED_DISABLE)
      ->groupBy('users.media_code')
      ->get()
      ->toArray();
  }

  public function summaryDepositDistanceOver3MonthGroupByMedia($year_register, $year_deposit, $month_register, $month_deposit)
  {
    return DB::table('users')
    ->select(DB::raw('count(DISTINCT td.user_id) as total_user_deposit,
      users.media_code,
      SUM(td.amount_pay) as total_amount,
      count(td.id) as total_deposit '))
    ->join('transaction_deposit as td', 'users.id', '=', 'td.user_id')
    ->where('td.status', APPLY)
      ->where('td.deleted_flg', DELETED_DISABLE)
      ->whereRaw('YEAR(td.updated_at) =' . $year_deposit . ' AND MONTH(td.updated_at) =' . $month_deposit)
      ->whereRaw('YEAR(users.register_time) <=' . $year_register . ' AND MONTH(users.register_time) <=' . $month_register)
      ->where('users.deleted_flg', DELETED_DISABLE)
      ->groupBy('users.media_code')
      ->get()
      ->toArray();
  }


  public function summaryMediaDepositTotal($year, $month)
  {
    return DB::table('users')
    ->select(DB::raw('count(DISTINCT td.user_id) as total_user_deposit,
      users.media_code,
      SUM(td.amount_pay) as total_amount,
      count(td.id) as total_deposit '))
    ->join('transaction_deposit as td', 'users.id', '=', 'td.user_id')
    ->where('td.status', APPLY)
      ->where('td.deleted_flg', DELETED_DISABLE)
      ->whereRaw('YEAR(td.updated_at) =' . $year . ' AND MONTH(td.updated_at)=' . $month)
      ->where('users.deleted_flg', DELETED_DISABLE)
      ->groupBy('users.media_code')
      ->get()
      ->toArray();
  }

}