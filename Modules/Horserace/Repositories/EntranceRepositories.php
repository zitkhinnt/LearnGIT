<?php
/**
 * Date 2018-09-10
 */

namespace Modules\Horserace\Repositories;

use File, DB;
use Modules\Horserace\Entities\Entrance;
use Modules\Horserace\Entities\User;
use Modules\Horserace\Entities\UserDailyAccessHistory;

class EntranceRepositories
{
  public function entranceStore($input)
  {
    $obj_entrance = new Entrance();
    $arr_entrance = [
      'name' => trim($input['name']),
      'default_point' => trim($input['default_point']),
      'default_user_stage' => trim($input['default_user_stage']),
      'default_flg' => isset($input["default_flg"]) ? ENTRANCE_DEFAULT_ENABLE : ENTRANCE_DEFAULT_DISABLE,
    ];

    if (trim($input['id']) == 0) {
      $obj_entrance->insertEntrance($arr_entrance);
      $result = [
        "status" => "success",
        "message" => __("horserace::be_msg.add_entrance_success"),
      ];
    } else {
      $obj_entrance->updateEntrance(trim($input['id']), $arr_entrance);
      $result = [
        'status' => 'success',
        'message' => __("horserace::be_msg.edit_entrance_success"),
      ];
    }

    return $result;
  }

  public function getEditEntrance($id)
  {
    $obj_entrance = new Entrance();
    $data_edit_entrance = $obj_entrance->getEntranceById($id);
    return $data_edit_entrance;
  }

  public function getListEntrance()
  {
    $obj_entrance = new Entrance();
    $list_entrance = $obj_entrance->getEntrance();
    return $list_entrance;
  }

  public function entranceDelete($id)
  {
    $obj_entrance = new Entrance();
    $obj_entrance->deleteEntrance($id);
    $result = [
      "status" => "success",
      "message" => __("horserace::be_msg.deleted_entrance_success"),
    ];
    return $result;
  }

  public function userRegisterEntrance($user_id)
  {
    $obj_user = new User();
    $obj_entrance = new Entrance();
    $user = $obj_user->getUserById($user_id);
    $obj_trans_gift_repositories = new TransactionGiftRepositories();
    $obj_user_activity_repositories = new UserActivityRepositories();

    // Get entrance
    $entrance = $obj_entrance->getEntranceById($user->entrance_id);

    // Add default point
    $arr_trans_gift = [
      "id" => 0,
      "user_id" => $user->id,
      "login_id" => $user->login_id,
      "member_level" => $user->member_level,
      "type" => TRANSACTION_GIFT_TYPE_ENTRANCE,
      "gift_id" => 0,
      "gift_name" => NAME_GIFT_ENTRANCE,
      "point" => $entrance->default_point,
      "status" => TRANSACTION_STATUS_SUCCESS,
      "send_mail" => SEND_MAIL_YET,
      "note" => null,
    ];
    $obj_trans_gift_repositories->storeTransactionGift($arr_trans_gift);

    // Add point for user
    $obj_user_activity_repositories->giftPoint($user->id, $entrance->default_point);

    // User stage
    $user_stage = explode(",", $user->user_stage_id);

    $arr_user_stage = array();
    foreach ($user_stage as $item) {
      $arr_user_stage[$item] = $item;
    }

    if (!isset($arr_user_stage[$entrance->default_user_stage])) {
      $arr_user_stage[$entrance->default_user_stage] = $entrance->default_user_stage;
      $str_user_stage = "";
      foreach ($arr_user_stage as $id) {
        $str_user_stage = $str_user_stage . $id . ',';
      }
      $arr_user["user_stage_id"] = $str_user_stage;
      $obj_user->updateUser($user->id, $arr_user);
    }
  }

  public function summaryEntrance($year, $month)
  {
    $obj_entrance = new Entrance();
    $obj_user_access_daily = new UserDailyAccessHistory();
    $list_entrance = $obj_entrance->getEntrance();
    $obj_user = new User();

    // List media
    $arr_summary = array();
    $arr_summary["summary"] = [
      "number_access" => 0,
      "user_interim" => 0,
      "user_register" => 0,
      "total_amount_0" => 0,
      "total_deposit_0" => 0,
      "total_user_deposit_0" => 0,
      "total_user_deposit_1" => 0,
      "total_amount_1" => 0,
      "total_deposit_1" => 0,
      "total_user_deposit_2" => 0,
      "total_amount_2" => 0,
      "total_deposit_2" => 0,
      "total_user_deposit_3" => 0,
      "total_amount_3" => 0,
      "total_deposit_3" => 0,
      "user_deposit" => 0,
      "amount" => 0,
      "deposit" => 0,
      "deposit_unit_price" => 0,
    ];

    foreach ($list_entrance as $item) {
      $user_register = $obj_user->countUserByEntrance($year, $month, $item->id);
      $user_interim = $obj_user->countUserInterimByEntrance($year, $month, $item->id);
      $number_access = $obj_user_access_daily->numberUserAccessMonthByEntrance($year, $month, $item->id);
      $arr_summary[$item->id] = [
        "entrance_id" => $item->id,
        "entrance_name" => $item->name,
        "user_register" => $user_register,
        "user_interim" => $user_interim,
        "link_entrance_detail" => route("admin.summary.entrance_detail", $item->id . "?year=" . $year . "&month=" . $month),
        "number_access" => $number_access,
        "total_user_deposit_0" => 0,
        "total_amount_0" => 0,
        "total_deposit_0" => 0,
        "total_user_deposit_1" => 0,
        "total_amount_1" => 0,
        "total_deposit_1" => 0,
        "total_user_deposit_2" => 0,
        "total_amount_2" => 0,
        "total_deposit_2" => 0,
        "total_user_deposit_3" => 0,
        "total_amount_3" => 0,
        "total_deposit_3" => 0,
        "user_deposit" => 0,
        "amount" => 0,
        "deposit" => 0,
        "deposit_unit_price" => number_format((integer)(0)),
      ];
      $arr_summary["summary"]["number_access"] += $number_access;
      $arr_summary["summary"]["user_interim"] += $user_interim;
      $arr_summary["summary"]["user_register"] += $user_register;
    }

    // Summary 0
    $month_0 = subMonth($year, $month, 0);
    $summary = $obj_entrance->summaryDepositDistanceMonth((integer)$month_0["year"], $year, (integer)$month_0["month"], $month);
    foreach ($summary as $item) {
      $arr_summary[$item->entrance_id]["total_user_deposit_0"] = $item->total_user_deposit;
      $arr_summary[$item->entrance_id]["total_amount_0"] = $item->total_amount;
      $arr_summary[$item->entrance_id]["total_deposit_0"] = $item->total_deposit;
      // Summary
      $arr_summary["summary"]["total_user_deposit_0"] += $item->total_user_deposit;
      $arr_summary["summary"]["total_amount_0"] += $item->total_amount;
      $arr_summary["summary"]["total_deposit_0"] += $item->total_deposit;
    }

    // Summary 1
    $month_1 = subMonth($year, $month, 1);
    $summary_1 = $obj_entrance->summaryDepositDistanceMonth((integer)$month_1["year"], $year, (integer)$month_1["month"], $month);
    foreach ($summary_1 as $item) {
      $arr_summary[$item->entrance_id]["total_user_deposit_1"] = $item->total_user_deposit;
      $arr_summary[$item->entrance_id]["total_amount_1"] = $item->total_amount;
      $arr_summary[$item->entrance_id]["total_deposit_1"] = $item->total_deposit;
      // Summary
      $arr_summary["summary"]["total_user_deposit_1"] += $item->total_user_deposit;
      $arr_summary["summary"]["total_amount_1"] += $item->total_amount;
      $arr_summary["summary"]["total_deposit_1"] += $item->total_deposit;
    }

    // Summary 2
    $month_2 = subMonth($year, $month, 2);
    $summary_2 = $obj_entrance->summaryDepositDistanceMonth((integer)$month_2["year"], $year, (integer)$month_2["month"], $month);
    foreach ($summary_2 as $item) {
      $arr_summary[$item->entrance_id]["total_user_deposit_2"] = $item->total_user_deposit;
      $arr_summary[$item->entrance_id]["total_amount_2"] = $item->total_amount;
      $arr_summary[$item->entrance_id]["total_deposit_2"] = $item->total_deposit;
      // Summary
      $arr_summary["summary"]["total_user_deposit_2"] += $item->total_user_deposit;
      $arr_summary["summary"]["total_amount_2"] += $item->total_amount;
      $arr_summary["summary"]["total_deposit_2"] += $item->total_deposit;
    }

    // Summary 3
    $month_3 = subMonth($year, $month, 3);
    $summary_3 = $obj_entrance->summaryDepositDistanceOver3Month((integer)$month_3["year"], $year, (integer)$month_3["month"], $month);
    foreach ($summary_3 as $item) {
      $arr_summary[$item->entrance_id]["total_user_deposit_3"] = $item->total_user_deposit;
      $arr_summary[$item->entrance_id]["total_amount_3"] = $item->total_amount;
      $arr_summary[$item->entrance_id]["total_deposit_3"] = $item->total_deposit;
      // Summary
      $arr_summary["summary"]["total_user_deposit_3"] += $item->total_user_deposit;
      $arr_summary["summary"]["total_amount_3"] += $item->total_amount;
      $arr_summary["summary"]["total_deposit_3"] += $item->total_deposit;
    }

    // Summary total all
    $summary_total = $obj_entrance->summaryEntranceDepositTotal($year, $month);
    foreach ($summary_total as $item) {
      $arr_summary[$item->entrance_id]["user_deposit"] = $item->total_user_deposit;
      $arr_summary[$item->entrance_id]["amount"] = $item->total_amount;
      $arr_summary[$item->entrance_id]["deposit"] = $item->total_deposit;
      $arr_summary[$item->entrance_id]["deposit_unit_price"] = $item->total_deposit == 0 ?
        number_format((integer)(0)) :
        number_format(((integer)($item->total_amount / $item->total_deposit)));
      // Summary
      $arr_summary["summary"]["user_deposit"] += $item->total_user_deposit;
      $arr_summary["summary"]["amount"] += $item->total_amount;
      $arr_summary["summary"]["deposit"] += $item->total_deposit;
    }

    // deposit_unit_price
    $arr_summary["summary"]["deposit_unit_price"] = $arr_summary["summary"]["deposit"] == 0 ?
      number_format((integer)(0)) :
      number_format(((integer)($arr_summary["summary"]["amount"] / $arr_summary["summary"]["deposit"])));

    return $arr_summary;
  }

  public function summaryEntranceDetail($year, $month, $entrance_id)
  {
    $obj_entrance = new Entrance();
    $obj_user = new User();
    $obj_user_access_daily = new UserDailyAccessHistory();
    $entrance = $obj_entrance->getEntranceById($entrance_id);
    $day_in_month = listDayInMonth($year, $month);

    $summary = array();

    $summary["summary"] = [
      "number_access" => 0,
      "user_interim" => 0,
      "user_register" => 0,
      "total_user_deposit_0" => 0,
      "total_amount_0" => 0,
      "total_deposit_0" => 0,
      "total_user_deposit_1" => 0,
      "total_amount_1" => 0,
      "total_deposit_1" => 0,
      "total_user_deposit_2" => 0,
      "total_amount_2" => 0,
      "total_deposit_2" => 0,
      "total_user_deposit_3" => 0,
      "total_amount_3" => 0,
      "total_deposit_3" => 0,
      "user_deposit" => 0,
      "amount" => 0,
      "deposit" => 0,
      "deposit_unit_price" => 0,
    ];

    // Set value
    foreach ($day_in_month as $item) {
      $summary[$item] = [
        "date" => $item,
        "number_access" => 0,
        "user_interim" => 0,
        "user_register" => 0,
        "total_ad_cost" => 0,
        "total_user_deposit_0" => 0,
        "total_amount_0" => 0,
        "total_deposit_0" => 0,
        "total_user_deposit_1" => 0,
        "total_amount_1" => 0,
        "total_deposit_1" => 0,
        "total_user_deposit_2" => 0,
        "total_amount_2" => 0,
        "total_deposit_2" => 0,
        "total_user_deposit_3" => 0,
        "total_amount_3" => 0,
        "total_deposit_3" => 0,
        "user_deposit" => 0,
        "amount" => 0,
        "deposit" => 0,
        "deposit_unit_price" => 0,
      ];
    }

    // Set data media access
    $number_access["datetime"] = $obj_user_access_daily->numberUserAccessDailyByEntrance($year, $month, $entrance_id);
    foreach ($number_access["datetime"] as $item) {
      $summary[$item->date]["number_access"] = (integer)$item->number_access;
      // Summary
      $summary["summary"]["number_access"] += (integer)$item->number_access;
    }

    // Set data user register
    $user_register["datetime"] = $obj_user->userByEntranceDetailDaily($year, $month, $entrance_id);
    foreach ($user_register["datetime"] as $item) {
      $summary[$item->date]["user_register"] = (integer)$item->user_register;
      // Summary
      $summary["summary"]["user_register"] += (integer)$item->user_register;
    }

    // Set data user interim
    $user_interim["datetime"] = $obj_user->userInterimByEntranceDetailDaily($year, $month, $entrance_id);
    foreach ($user_interim["datetime"] as $item) {
      $summary[$item->date]["user_interim"] = (integer)$item->user_register;
      // Summary
      $summary["summary"]["user_interim"] += (integer)$item->user_register;
    }

    // Set deposit month 0
    $month_0 = subMonth($year, $month, 0);
    $total_deposit_0['datetime'] = $obj_entrance->summaryEntranceDetailDailyDistanceMonth((integer)$month_0["year"], $year, (integer)$month_0["month"], $month, $entrance_id);
    foreach ($total_deposit_0["datetime"] as $item) {
      $summary[$item->date]["total_user_deposit_0"] = (integer)$item->total_user_deposit;
      $summary[$item->date]["total_amount_0"] = (integer)$item->total_amount;
      $summary[$item->date]["total_deposit_0"] = (integer)$item->total_deposit;
      // Summary
      $summary["summary"]["total_user_deposit_0"] += (integer)$item->total_user_deposit;
      $summary["summary"]["total_amount_0"] += (integer)$item->total_amount;
      $summary["summary"]["total_deposit_0"] += (integer)$item->total_deposit;
    }

    // Set deposit month 1
    $month_1 = subMonth($year, $month, 1);
    $total_deposit_1['datetime'] = $obj_entrance->summaryEntranceDetailDailyDistanceMonth((integer)$month_1["year"], $year, (integer)$month_1["month"], $month, $entrance_id);
    foreach ($total_deposit_1["datetime"] as $item) {
      $summary[$item->date]["total_user_deposit_1"] = (integer)$item->total_user_deposit;
      $summary[$item->date]["total_amount_1"] = (integer)$item->total_amount;
      $summary[$item->date]["total_deposit_1"] = (integer)$item->total_deposit;
      // Summary
      $summary["summary"]["total_user_deposit_1"] += (integer)$item->total_user_deposit;
      $summary["summary"]["total_amount_1"] += (integer)$item->total_amount;
      $summary["summary"]["total_deposit_1"] += (integer)$item->total_deposit;
    }

    // Set deposit month 2
    $month_2 = subMonth($year, $month, 2);
    $total_deposit_2['datetime'] = $obj_entrance->summaryEntranceDetailDailyDistanceMonth((integer)$month_2["year"], $year, (integer)$month_2["month"], $month, $entrance_id);
    foreach ($total_deposit_2["datetime"] as $item) {
      $summary[$item->date]["total_user_deposit_2"] = (integer)$item->total_user_deposit;
      $summary[$item->date]["total_amount_2"] = (integer)$item->total_amount;
      $summary[$item->date]["total_deposit_2"] = (integer)$item->total_deposit;
      // Summary
      $summary["summary"]["total_user_deposit_2"] += (integer)$item->total_user_deposit;
      $summary["summary"]["total_amount_2"] += (integer)$item->total_amount;
      $summary["summary"]["total_deposit_2"] += (integer)$item->total_deposit;
    }

    // Set deposit month 3
    $month_3 = subMonth($year, $month, 3);
    $total_deposit_3['datetime'] = $obj_entrance->summaryEntranceDetailDailyDistanceOver3Month((integer)$month_3["year"], $year, (integer)$month_3["month"], $month, $entrance_id);
    foreach ($total_deposit_3["datetime"] as $item) {
      $summary[$item->date]["total_user_deposit_3"] = (integer)$item->total_user_deposit;
      $summary[$item->date]["total_amount_3"] = (integer)$item->total_amount;
      $summary[$item->date]["total_deposit_3"] = (integer)$item->total_deposit;
      // Summary
      $summary["summary"]["total_user_deposit_3"] += (integer)$item->total_user_deposit;
      $summary["summary"]["total_amount_3"] += (integer)$item->total_amount;
      $summary["summary"]["total_deposit_3"] += (integer)$item->total_deposit;
    }

    // Summary total all
    $summary_total = $obj_entrance->summaryEntranceDetailDailyTotal($year, $month, $entrance_id);
    foreach ($summary_total as $item) {
      $summary[$item->date]["user_deposit"] = $item->total_user_deposit;
      $summary[$item->date]["amount"] = $item->total_amount;
      $summary[$item->date]["deposit"] = $item->total_deposit;
      $summary[$item->date]["deposit_unit_price"] = $item->total_deposit == 0 ?
        number_format((integer)(0)) :
        number_format(((integer)($item->total_amount / $item->total_deposit)));
      // Summary
      $summary["summary"]["user_deposit"] += $item->total_user_deposit;
      $summary["summary"]["amount"] += $item->total_amount;
      $summary["summary"]["deposit"] += $item->total_deposit;
    }

    // deposit_unit_price
    $summary["summary"]["deposit_unit_price"] = $summary["summary"]["deposit"] == 0 ?
      number_format((integer)(0)) :
      number_format(((integer)($summary["summary"]["amount"] / $summary["summary"]["deposit"])));

    ksort($summary);
    return $summary;
  }
}