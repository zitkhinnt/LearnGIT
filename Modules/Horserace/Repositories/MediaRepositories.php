<?php
/**
 * Date 2018-09-10
 */

namespace Modules\Horserace\Repositories;

use File, DB;
use Modules\Horserace\Entities\Media;
use Modules\Horserace\Entities\MediaAccess;
use Modules\Horserace\Entities\User;
use Modules\Horserace\Entities\UserDailyAccessHistory;
use Modules\Horserace\Entities\UserDailyLoginHistory;

class MediaRepositories
{
  public function mediaStore($input)
  {
    $obj_media = new Media();
    $arr_media = [
      'name' => trim($input['name']),
      'code' => trim($input['code']),
      'cost' => trim($input['cost']),
      'url' => url('/?ref=' . trim($input['code'])),
      'link' => $input["link"],
      'ad_type' => $input["ad_type"],
    ];

    if (trim($input['id']) == 0) {
      $obj_media->insertMedia($arr_media);
      $result = [
        "status" => "success",
        "message" => __("horserace::be_msg.add_media_success"),
      ];
    } else {
      $obj_media->updateMedia(trim($input['id']), $arr_media);
      $result = [
        'status' => 'success',
        'message' => __("horserace::be_msg.edit_media_success"),
      ];
    }

    return $result;
  }

  public function getEditMedia($id)
  {
    $obj_media = new Media();
    $media = $obj_media->getMediaById($id);
    return $media;
  }

  public function getListMedia()
  {
    $obj_media = new Media();
    $list_media = $obj_media->getMedia();
    return $list_media;
  }

  public function getMediaByCode($media_code)
  {
    $obj_media = new Media();
    $media = $obj_media->getMediaByCode($media_code);
    return $media;
  }

  public function mediaDelete($id)
  {
    $obj_media = new Media();
    $obj_media->deleteMedia($id);
    $result = [
      "status" => "success",
      "message" => __("horserace::be_msg.deleted_media_success"),
    ];
    return $result;
  }


  //Sumary Media ko xai nua
  public function summaryMedia($year, $month)
  {
    $obj_media = new Media();
    $obj_media_access = new MediaAccess();
    $obj_user_access_daily = new UserDailyAccessHistory();
    $obj_user_login_daily = new UserDailyLoginHistory();
    $obj_transaction_deposit_repo = new TransactionDepositRepositories();
    $obj_user_repo = new UserRepositories();
    $list_media = $obj_media->getMedia();
    $obj_user = new User();

    // List media
    $arr_summary = array();
    $arr_summary["summary"] = [
      "number_access" => 0,
      "user_interim" => 0,
      "user_register" => 0,
      "total_user_deposit" => 0,
      "total_amount" => 0,
      "total_deposit" => 0,
      "total_ad_cost" => 0,
      "deposit_unit_price" => 0,
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
      "number_user_login" => 0,
      "total_number_login" => 0,
      "rate_login" => number_format((float) (0), 2, '.', ''),
      "total_new_payment_users" => 0,
      "total_new_registered_users" => 0,
    ];

    foreach ($list_media as $item) {
      $user_register = $obj_user->countUserByMediaCodeAndTime($year, $month, $item->code);
      $user_interim = $obj_user->countUserInterimByMediaCodeAndTime($year, $month, $item->code);
      // $number_access = $obj_user_access_daily->numberUserAccessMonthByMedia($year, $month, $item->code);
      $number_access = $obj_media_access->numberMediaAccessMonth($year, $month, $item->code);
      $total_user_deposit = (int) $user_register * (int) $item->cost;
      $arr_summary[$item->code] = [
        "media_id" => $item->id,
        "media_code" => $item->code,
        "user_register" => $user_register,
        "user_interim" => $user_interim,
        "name" => $item->name,
        "link" => $item->link,
        "link_media_code" => route("admin.summary.media_code", $item->code . "?year=" . $year . "&month=" . $month),
        "number_access" => $number_access,
        "total_user_deposit" => 0,
        "total_amount" => 0,
        "total_deposit" => 0,
        "total_ad_cost" => $total_user_deposit,
        "deposit_unit_price" => number_format((int) (0)),
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
        "number_user_login" => 0,
        "total_number_login" => 0,
        "rate_login" => number_format((float) (0), 2, '.', ''),
        "total_new_payment_users" => 0,
        "total_new_registered_users" => 0,
      ];
      $arr_summary["summary"]["number_access"] += $number_access;
      $arr_summary["summary"]["user_interim"] += $user_interim;
      $arr_summary["summary"]["user_register"] += $user_register;
      $arr_summary["summary"]["total_ad_cost"] += $total_user_deposit;
    }

    // Summary 0
    $month_0 = subMonth($year, $month, 0);
    $summary = $obj_transaction_deposit_repo->summaryDepositDistanceMonthGroupByMedia((int) $month_0["year"], $year, (int) $month_0["month"], $month);
    foreach ($summary as $item) {
      $arr_summary[$item->media_code]["total_user_deposit"] = $item->total_user_deposit;
      $arr_summary[$item->media_code]["total_amount"] = $item->total_amount;
      $arr_summary[$item->media_code]["total_deposit"] = $item->total_deposit;
      // Summary
      $arr_summary["summary"]["total_user_deposit"] += $item->total_user_deposit;
      $arr_summary["summary"]["total_amount"] += $item->total_amount;
      $arr_summary["summary"]["total_deposit"] += $item->total_deposit;
    }

    // Summary 1
    $month_1 = subMonth($year, $month, 1);
    $summary_1 = $obj_transaction_deposit_repo->summaryDepositDistanceMonthGroupByMedia((int) $month_1["year"], $year, (int) $month_1["month"], $month);
    foreach ($summary_1 as $item) {
      $arr_summary[$item->media_code]["total_user_deposit_1"] = $item->total_user_deposit;
      $arr_summary[$item->media_code]["total_amount_1"] = $item->total_amount;
      $arr_summary[$item->media_code]["total_deposit_1"] = $item->total_deposit;
      // Summary
      $arr_summary["summary"]["total_user_deposit_1"] += $item->total_user_deposit;
      $arr_summary["summary"]["total_amount_1"] += $item->total_amount;
      $arr_summary["summary"]["total_deposit_1"] += $item->total_deposit;
    }

    // Summary 2
    $month_2 = subMonth($year, $month, 2);
    $summary_2 = $obj_transaction_deposit_repo->summaryDepositDistanceMonthGroupByMedia((int) $month_2["year"], $year, (int) $month_2["month"], $month);
    foreach ($summary_2 as $item) {
      $arr_summary[$item->media_code]["total_user_deposit_2"] = $item->total_user_deposit;
      $arr_summary[$item->media_code]["total_amount_2"] = $item->total_amount;
      $arr_summary[$item->media_code]["total_deposit_2"] = $item->total_deposit;
      // Summary
      $arr_summary["summary"]["total_user_deposit_2"] += $item->total_user_deposit;
      $arr_summary["summary"]["total_amount_2"] += $item->total_amount;
      $arr_summary["summary"]["total_deposit_2"] += $item->total_deposit;
    }

    // Summary 3
    $month_3 = subMonth($year, $month, 3);
    $summary_3 = $obj_transaction_deposit_repo->summaryDepositDistanceOver3MonthGroupByMedia((int) $month_3["year"], $year, (int) $month_3["month"], $month);
    foreach ($summary_3 as $item) {
      $arr_summary[$item->media_code]["total_user_deposit_3"] = $item->total_user_deposit;
      $arr_summary[$item->media_code]["total_amount_3"] = $item->total_amount;
      $arr_summary[$item->media_code]["total_deposit_3"] = $item->total_deposit;
      // Summary
      $arr_summary["summary"]["total_user_deposit_3"] += $item->total_user_deposit;
      $arr_summary["summary"]["total_amount_3"] += $item->total_amount;
      $arr_summary["summary"]["total_deposit_3"] += $item->total_deposit;
    }

    // Summary total all
    $summary_total = $obj_transaction_deposit_repo->summaryMediaDepositTotal($year, $month);
    foreach ($summary_total as $item) {
      $arr_summary[$item->media_code]["user_deposit"] = $item->total_user_deposit;
      $arr_summary[$item->media_code]["amount"] = $item->total_amount;
      $arr_summary[$item->media_code]["deposit"] = $item->total_deposit;
      $arr_summary[$item->media_code]["deposit_unit_price"] = $item->total_deposit == 0 ?
        number_format((int) (0)) :
        number_format(((int) ($item->total_amount / $item->total_deposit)));
      // Summary
      $arr_summary["summary"]["user_deposit"] += $item->total_user_deposit;
      $arr_summary["summary"]["amount"] += $item->total_amount;
      $arr_summary["summary"]["deposit"] += $item->total_deposit;
    }

    // deposit_unit_price
    $arr_summary["summary"]["deposit_unit_price"] = $arr_summary["summary"]["deposit"] == 0 ?
      number_format((int) (0)) :
      number_format(((int) ($arr_summary["summary"]["amount"] / $arr_summary["summary"]["deposit"])));

    // Number login
    $number_login = $obj_user_login_daily->summaryMediaNumberLoginTotal($year, $month);

    foreach ($number_login as $item) {
      $media_code = remove2ByteSpace($item->media_code);
      if (isset($arr_summary[$media_code])) {
        $arr_summary[$media_code]["number_user_login"] = $item->number_user;
        $arr_summary[$media_code]["total_number_login"] = $item->total_number_login;
        $total_user_register = $arr_summary[$media_code]["user_register"];
        $arr_summary[$media_code]["rate_login"] = $total_user_register == 0 ?
          number_format((float) (0), 2, '.', '') :
          number_format(((float) ($item->total_number_login / $total_user_register)), 2, '.', '');
        // Summary
        $arr_summary["summary"]["number_user_login"] += $item->number_user;
        $arr_summary["summary"]["total_number_login"] += $item->total_number_login;
      }
    }

    // rate login
    $total_user_register = $arr_summary["summary"]["user_register"];
    $arr_summary["summary"]["rate_login"] = $total_user_register == 0 ?
      number_format((float) (0), 2, '.', '') :
      number_format(((float) ($arr_summary["summary"]["total_number_login"] / $total_user_register)), 2, '.', '');


    //Summary new payment user
    $summary_new_payment = $obj_user_repo->summaryMediaDepositByNewPaymentUsers($year, $month);

    foreach ($summary_new_payment as $item) {
      $media_code = remove2ByteSpace($item->media_code);
      if (isset($arr_summary[$media_code])) {
        $arr_summary[$media_code]["total_new_payment_users"] = $item->total_new_user_deposit;
        // Summary
        $arr_summary["summary"]["total_new_payment_users"] += $item->total_new_user_deposit;
      }
    }

    //Summary new  payment and new registered user
    $summary_new_register = $obj_user_repo->summaryMediaDepositByNewPaymentAndNewRegisterUsers($year, $month);

    foreach ($summary_new_register as $item) {
      $media_code = remove2ByteSpace($item->media_code);
      if (isset($arr_summary[$media_code])) {
        $arr_summary[$media_code]["total_new_registered_users"] = $item->total_new_user_deposit_payment;
        // Summary
        $arr_summary["summary"]["total_new_registered_users"] += $item->total_new_user_deposit_payment;
      }
    }
    //dd($summary_new_payment);

    return $arr_summary;
  }

  public function summaryMediaCode($year, $month, $media_code)
  {
    $obj_media = new Media();
    $obj_media_access = new MediaAccess();
    $obj_user = new User();
    $obj_user_access_daily = new UserDailyAccessHistory();
    $obj_user_login_daily = new UserDailyLoginHistory();
    $media = $obj_media->getMediaByCode($media_code);
    $day_in_month = listDayInMonth($year, $month);

    $summary = array();

    $summary["summary"] = [
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
      "number_user_login" => number_format((float)(0), 2, '.', ''),
      "total_number_login" => 0,
      "rate_login" => number_format((float)(0), 2, '.', ''),
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
        "number_user_login" => number_format((float)(0), 2, '.', ''),
        "total_number_login" => 0,
        "rate_login" => number_format((float)(0), 2, '.', ''),
      ];
    }

    // Set data media access
//    $media_access["datetime"] = $obj_user_access_daily->numberUserAccessDailyByMedia($year, $month, $media_code);
    $media_access["datetime"] = $obj_media_access->numberMediaAccessDaily($year, $month, $media_code);
    foreach ($media_access["datetime"] as $item) {
      $summary[$item->date]["number_access"] = (integer)$item->number_access;
      // Summary
      $summary["summary"]["number_access"] += (integer)$item->number_access;
    }

    // Set data user register
    $user_register["datetime"] = $obj_user->userByMediaCodeDaily($year, $month, $media_code);
    foreach ($user_register["datetime"] as $item) {
      $summary[$item->date]["user_register"] = (integer)$item->user_register;
      $summary[$item->date]["total_ad_cost"] = (integer)$item->user_register * (integer)$media->cost;
      // Summary
      $summary["summary"]["user_register"] += (integer)$item->user_register;
      $summary["summary"]["total_ad_cost"] += (integer)$item->user_register * (integer)$media->cost;
    }

    // Set data user interim
    $user_interim["datetime"] = $obj_user->userInterimByMediaCodeDaily($year, $month, $media_code);
    foreach ($user_interim["datetime"] as $item) {
      $summary[$item->date]["user_interim"] = (integer)$item->user_register;
      // Summary
      $summary["summary"]["user_interim"] += (integer)$item->user_register;
    }

    // Set deposit month 0
    $month_0 = subMonth($year, $month, 0);
    $total_deposit_0['datetime'] = $obj_media->summaryMediaCodeDailyDistanceMonth((integer)$month_0["year"], $year, (integer)$month_0["month"], $month, $media_code);
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
    $total_deposit_1['datetime'] = $obj_media->summaryMediaCodeDailyDistanceMonth((integer)$month_1["year"], $year, (integer)$month_1["month"], $month, $media_code);
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
    $total_deposit_2['datetime'] = $obj_media->summaryMediaCodeDailyDistanceMonth((integer)$month_2["year"], $year, (integer)$month_2["month"], $month, $media_code);
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
    $total_deposit_3['datetime'] = $obj_media->summaryMediaCodeDailyDistanceOver3Month((integer)$month_3["year"], $year, (integer)$month_3["month"], $month, $media_code);
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
    $summary_total = $obj_media->summaryMediaCodeDailyTotal($year, $month, $media_code);
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


    // Number login
    $number_login = $obj_user_login_daily->summaryMediaCodeNumberLoginDailyTotal($year, $month, $media_code);
    foreach ($number_login as $item) {
      $summary[$item->date]["number_user_login"] = $item->number_user;
      $summary[$item->date]["total_number_login"] = number_format((float)($item->total_number_login), 2, '.', '');
      // Summary
      $summary["summary"]["number_user_login"] += $item->number_user;
      $summary["summary"]["total_number_login"] += $item->total_number_login;
    }

    // rate login
    $total_user_register = $summary["summary"]["user_register"];
    $summary["summary"]["rate_login"] = $total_user_register == 0 ?
      number_format((float)(0), 2, '.', '') :
      number_format(((float)($summary["summary"]["total_number_login"] / $total_user_register)), 2, '.', '');

    ksort($summary);
    return $summary;
  }

  public function summaryMediaSort($input)
  {
    // Period time
    $year_start = $input["year_start"];
    $month_start = $input["month_start"];
    $day_start = $input["day_start"];

    $year_end = $input["year_end"];
    $month_end = $input["month_end"];
    $day_end = $input["day_end"];

    $time_start = $year_start . "-" . $month_start . "-" . $day_start . " 00:00:00";
    $time_end = $year_end . "-" . $month_end . "-" . $day_end . " 23:59:59";

    // Object
    $obj_media = new Media();
    $obj_media_access = new MediaAccess();
    $obj_user_access_daily = new UserDailyAccessHistory();
    $obj_user_login_daily = new UserDailyLoginHistory();
    $obj_user = new User();
    $obj_transaction_deposit_repo = new TransactionDepositRepositories();
    $obj_user_repo = new UserRepositories();

    // Get list media code
    if (is_null($input["media_code"])) {
      $list_media = $obj_media->getMedia();
    } else {
      $list_media = $obj_media->getMediaByLikeCode($input["media_code"]);
    }

    // List media
    $arr_summary = array();
    $arr_summary["summary"] = [
      "number_access" => 0,
      "user_interim" => 0,
      "user_register" => 0,
      "total_user_deposit" => 0,
      "total_amount" => 0,
      "total_deposit" => 0,
      "total_ad_cost" => 0,
      "deposit_unit_price" => 0,
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
      "number_user_login" => 0,
      "total_number_login" => 0,
      "rate_login" => number_format((float) (0), 2, '.', ''),
      "total_new_payment_users" => 0,
      "total_new_registered_users" => 0,
    ];

    foreach ($list_media as $item) {
      $user_register = $obj_user->countUserByMediaCodePeriodTime($time_start, $time_end, $item->code);
      $user_interim = $obj_user->countUserInterimByMediaCodePeriodTime($time_start, $time_end, $item->code);
      // $number_access = $obj_user_access_daily->numberUserAccessPeriodTimeByMedia($time_start, $time_end, $item->code);
      $number_access = $obj_media_access->numberMediaAccessPeriodTime($time_start, $time_end, $item->code);
      if ($item->ad_type == ADVERTISE_TYPE_AF) {
        $total_ad_cost = (int) $user_register * (int) $item->cost;
      } elseif ($item->ad_type == ADVERTISE_TYPE_PERMANENT) {
        $total_ad_cost = (int) $item->cost;
      } else {
        $total_ad_cost = 0;
      }

      $arr_summary[$item->code] = [
        "media_id" => $item->id,
        "media_code" => $item->code,
        "ad_type" => $item->ad_type,
        "cost" => (int) $item->cost,
        "user_register" => $user_register,
        "user_interim" => $user_interim,
        "name" => $item->name,
        "link" => $item->link,
        "link_media_code" => route("admin.summary.media_code", $item->code . "?year=" . $year_start . "&month=" . $month_end),
        "number_access" => $number_access,
        "total_user_deposit" => 0,
        "total_amount" => 0,
        "total_deposit" => 0,
        "total_ad_cost" => $total_ad_cost,
        "deposit_unit_price" => number_format((int) (0)),
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
        "number_user_login" => 0,
        "total_number_login" => 0,
        "rate_login" => number_format((float) (0), 2, '.', ''),
        "total_new_payment_users" => 0,
        "total_new_registered_users" => 0,
      ];
      $arr_summary["summary"]["number_access"] += $number_access;
      $arr_summary["summary"]["user_interim"] += $user_interim;
      $arr_summary["summary"]["user_register"] += $user_register;
      $arr_summary["summary"]["total_ad_cost"] += $total_ad_cost;
    }

    // Summary 0
    $month_0 = subMonth($year_start, $month_start, 0);
    $time_reg_start_0 = $month_0["year"] . "-" . $month_0["month"] . "-" . "01";
    $time_reg_end_0 = $time_end;
    $summary = $obj_transaction_deposit_repo->summaryDepositPeriodTime($time_reg_start_0, $time_start, $time_reg_end_0, $time_end);
    foreach ($summary as $item) {
      if (isset($arr_summary[$item->media_code])) {
        $arr_summary[$item->media_code]["total_user_deposit"] = $item->total_user_deposit;
        $arr_summary[$item->media_code]["total_amount"] = $item->total_amount;
        $arr_summary[$item->media_code]["total_deposit"] = $item->total_deposit;
        // Summary
        $arr_summary["summary"]["total_user_deposit"] += $item->total_user_deposit;
        $arr_summary["summary"]["total_amount"] += $item->total_amount;
        $arr_summary["summary"]["total_deposit"] += $item->total_deposit;
      }
    }

    // Summary 1
    $month_1 = subMonth($year_start, $month_start, 1);
    $time_reg_start_1 = $month_1["year"] . "-" . $month_1["month"] . "-" . "01";
    $time_reg_end_1 = $time_start;
    $summary_1 = $obj_transaction_deposit_repo->summaryDepositPeriodTime($time_reg_start_1, $time_start, $time_reg_end_1, $time_end);
    foreach ($summary_1 as $item) {
      if (isset($arr_summary[$item->media_code])) {
        $arr_summary[$item->media_code]["total_user_deposit_1"] = $item->total_user_deposit;
        $arr_summary[$item->media_code]["total_amount_1"] = $item->total_amount;
        $arr_summary[$item->media_code]["total_deposit_1"] = $item->total_deposit;
        // Summary
        $arr_summary["summary"]["total_user_deposit_1"] += $item->total_user_deposit;
        $arr_summary["summary"]["total_amount_1"] += $item->total_amount;
        $arr_summary["summary"]["total_deposit_1"] += $item->total_deposit;
      }
    }

    // Summary 2
    $month_2 = subMonth($year_start, $month_start, 2);
    $time_reg_start_2 = $month_2["year"] . "-" . $month_2["month"] . "-" . "01";
    $time_reg_end_2 = $time_reg_start_1;
    $summary_2 = $obj_transaction_deposit_repo->summaryDepositPeriodTime($time_reg_start_2, $time_start, $time_reg_end_2, $time_end);
    foreach ($summary_2 as $item) {
      if (isset($arr_summary[$item->media_code])) {
        $arr_summary[$item->media_code]["total_user_deposit_2"] = $item->total_user_deposit;
        $arr_summary[$item->media_code]["total_amount_2"] = $item->total_amount;
        $arr_summary[$item->media_code]["total_deposit_2"] = $item->total_deposit;
        // Summary
        $arr_summary["summary"]["total_user_deposit_2"] += $item->total_user_deposit;
        $arr_summary["summary"]["total_amount_2"] += $item->total_amount;
        $arr_summary["summary"]["total_deposit_2"] += $item->total_deposit;
      }
    }

    // Summary 3
    $month_3 = subMonth($year_start, $month_start, 3);
    $time_reg_start_3 = $month_3["year"] . "-" . $month_3["month"] . "-" . "01";
    $time_reg_end_3 = $time_reg_start_2;
    $summary_3 = $obj_transaction_deposit_repo->summaryDepositPeriodOver3Month($time_reg_start_3, $time_start, $time_reg_end_3, $time_end);
    foreach ($summary_3 as $item) {
      if (isset($arr_summary[$item->media_code])) {
        $arr_summary[$item->media_code]["total_user_deposit_3"] = $item->total_user_deposit;
        $arr_summary[$item->media_code]["total_amount_3"] = $item->total_amount;
        $arr_summary[$item->media_code]["total_deposit_3"] = $item->total_deposit;
        // Summary
        $arr_summary["summary"]["total_user_deposit_3"] += $item->total_user_deposit;
        $arr_summary["summary"]["total_amount_3"] += $item->total_amount;
        $arr_summary["summary"]["total_deposit_3"] += $item->total_deposit;
      }
    }

    // Summary total all
    $summary_total = $obj_transaction_deposit_repo->summaryMediaDepositTotalPeriod($time_start, $time_end);
    foreach ($summary_total as $item) {
      if (isset($arr_summary[$item->media_code])) {
        $arr_summary[$item->media_code]["user_deposit"] = $item->total_user_deposit;
        $arr_summary[$item->media_code]["amount"] = $item->total_amount;
        $arr_summary[$item->media_code]["deposit"] = $item->total_deposit;
        $arr_summary[$item->media_code]["deposit_unit_price"] = $item->total_deposit == 0 ?
          number_format((int) (0)) :
          number_format(((int) ($item->total_amount / $item->total_deposit)));
        // Summary
        $arr_summary["summary"]["user_deposit"] += $item->total_user_deposit;
        $arr_summary["summary"]["amount"] += $item->total_amount;
        $arr_summary["summary"]["deposit"] += $item->total_deposit;

        if ($arr_summary[$item->media_code]["ad_type"] == ADVERTISE_TYPE_SHARE) {
          $arr_summary[$item->media_code]["total_ad_cost"] = ($arr_summary[$item->media_code]["cost"] * $item->total_amount) / 100;
          $arr_summary["summary"]["total_ad_cost"] += $arr_summary[$item->media_code]["total_ad_cost"];
        }
      }
    }

    // deposit_unit_price
    $arr_summary["summary"]["deposit_unit_price"] = $arr_summary["summary"]["deposit"] == 0 ?
      number_format((int) (0)) :
      number_format(((int) ($arr_summary["summary"]["amount"] / $arr_summary["summary"]["deposit"])));

    // Number login
    $number_login = $obj_user_login_daily->summaryMediaNumberLoginTotalPeriod($time_start, $time_end);
    foreach ($number_login as $item) {
      $media_code = remove2ByteSpace($item->media_code);
      if (isset($arr_summary[$media_code])) {
        $arr_summary[$media_code]["number_user_login"] = $item->number_user;
        $arr_summary[$media_code]["total_number_login"] = $item->total_number_login;
        $total_user_register = $arr_summary[$media_code]["user_register"];
        $arr_summary[$media_code]["rate_login"] = $total_user_register == 0 ?
          number_format((float) (0), 2, '.', '') :
          number_format(((float) ($item->total_number_login / $total_user_register)), 2, '.', '');
        // Summary
        $arr_summary["summary"]["number_user_login"] += $item->number_user;
        $arr_summary["summary"]["total_number_login"] += $item->total_number_login;
      }
    }

    // rate login
    $total_user_register = $arr_summary["summary"]["user_register"];
    $arr_summary["summary"]["rate_login"] = $total_user_register == 0 ?
      number_format((float) (0), 2, '.', '') :
      number_format(((float) ($arr_summary["summary"]["total_number_login"] / $total_user_register)), 2, '.', '');


    //Summary new payment user
    $summary_new_payment = $obj_user_repo->summaryMediaDepositByNewPaymentUsersPeriod($time_start, $time_end);
    foreach ($summary_new_payment as $item) {
      $media_code = remove2ByteSpace($item->media_code);
      if (isset($arr_summary[$media_code])) {
        $arr_summary[$media_code]["total_new_payment_users"] = $item->total_new_user_deposit;
        // Summary
        $arr_summary["summary"]["total_new_payment_users"] += $item->total_new_user_deposit;
      }
    }

    //Summary new  payment and new registered user
    $summary_new_register = $obj_user_repo->summaryMediaDepositByNewPaymentAndNewRegisterUsersPeriod($time_start, $time_end);
    foreach ($summary_new_register as $item) {
      $media_code = remove2ByteSpace($item->media_code);
      if (isset($arr_summary[$media_code])) {
        $arr_summary[$media_code]["total_new_registered_users"] = $item->total_new_user_deposit_payment;
        // Summary
        $arr_summary["summary"]["total_new_registered_users"] += $item->total_new_user_deposit_payment;
      }
    }

    return $arr_summary;
  }

  public function summaryMediaRank($type)
  {
    $obj_media = new Media();
    $obj_user = new User();
    $list_media = $obj_media->getMedia();
    $arr_summary = array();

    switch ($type) {
      case SUMMARY_TYPE_PAYMENT:

        break;

      case SUMMARY_TYPE_NOT_PAYMENT:

        break;

      case SUMMARY_TYPE_NOT_LOGIN:

        break;

      default:
        foreach ($list_media as $item) {
          $arr_summary[] = [
            "rank" => 1,
            "media_code" => $item->code,
            "media_name" => $item->name,
            "number_user" => 0,
          ];
        }
        break;
    }

    return $arr_summary;
  }

}