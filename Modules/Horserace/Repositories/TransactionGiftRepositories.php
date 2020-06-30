<?php
/**
 * Date 2018-09-10
 */

namespace Modules\Horserace\Repositories;

use DB;
use Modules\Horserace\Entities\TransactionGift;
use Modules\Horserace\Entities\MailRegisterDetail;
use Modules\Horserace\Entities\MailTemplate;
use Modules\Horserace\Entities\User;

class TransactionGiftRepositories
{
  public function storeTransactionGift($input)
  {
    $obj_trans_gift = new TransactionGift();

    // Save data
    $arr_trans_gift = [
      "user_id" => trim($input["user_id"]),
      "login_id" => trim($input["login_id"]),
      "type" => trim($input["type"]),
      "gift_id" => trim($input["gift_id"]),
      "gift_name" => trim($input["gift_name"]),
      "member_level" => trim($input["member_level"]),
      "point" => trim($input["point"]),
      "status" => trim($input["status"]),
      "send_mail" => trim($input["send_mail"]),
      "note" => $input["note"],
    ];

    if ($input["id"] != 0) {
      // Edit
      $obj_trans_gift->updateTransactionGift(trim($input["id"]), $arr_trans_gift);
      $result = [
        "status" => "success",
        "message" => __("horserace::be_msg.edit_trans_gift_success")
      ];
    } else {
      // Create
      $obj_trans_gift->insertTransactionGift($arr_trans_gift);
      $result = [
        "status" => "success",
        "message" => __("horserace::be_msg.add_trans_gift_success")
      ];
    }

    return $result;
  }

  public function getTransactionGiftById($id_trans_gift)
  {
    $obj_trans_gift = new TransactionGift();
    $mail_bulk_detail = $obj_trans_gift->getTransactionGiftById($id_trans_gift);
    return $mail_bulk_detail;
  }

  public function getTransactionGift()
  {
    $obj_trans_gift = new TransactionGift();
    $list_trans_gift = $obj_trans_gift->getTransactionGift();
    return $list_trans_gift;
  }

  public function getTransactionGiftAjax($input)
  {
    $obj_trans_gift = new TransactionGift();
    $list_trans_gift = $obj_trans_gift->getSearchTransactionGift($input);
    return $list_trans_gift;
  }

  public function deleteTransactionGift($id_trans_gift)
  {
    $obj_trans_gift = new TransactionGift();
    $obj_trans_gift->deleteTransactionGift($id_trans_gift);
    $result = [
      "status" => "success",
      "message" => __("horserace::be_msg.delete_trans_gift"),
    ];

    return $result;
  }

  public function addGiftBonus($input)
  {
    $obj_user = new User();
    $obj_user_activity_repositories = new UserActivityRepositories();
    $obj_trans_gift = new TransactionGift();

    // get user
    $user = $obj_user->getUserByLoginId(trim($input["login_id"]));

    // Check login id
    if (is_null($user)) {
      // Error
      $result = [
        "status" => "danger",
        "message" => __("horserace::be_msg.gift_bonus_login_id_not_found"),
      ];
    } else {
      $arr_trans_gift = [
        "user_id" => $user->id,
        "login_id" => $user->login_id,
        "member_level" => $user->member_level,
        "type" => TRANSACTION_GIFT_TYPE_BONUS,
        "gift_name" => trim($input["name"]),
        "point" => trim($input["point"]),
        "status" => TRANSACTION_STATUS_SUCCESS,
        "send_mail" => SEND_MAIL_NOT,
        "note" => $input["note"],
      ];

      // Update trans gift
      $obj_trans_gift->insertTransactionGift($arr_trans_gift);

      // Add point for user
      $obj_user_activity_repositories->giftPoint($user->id, trim($input["point"]));


      $result = [
        "status" => "success",
        "message" => __("horserace::be_msg.add_gift_bonus_success"),
      ];
    }

    return $result;
  }

  public function summaryGiftDaily($year, $month)
  {
    $obj_transaction_gift = new TransactionGift();
    $data = $obj_transaction_gift->getSummaryGiftDaily($year, $month);
    return $data;
  }

  public function summaryGiftWeekly($start_week, $end_week)
  {
    $obj_transaction_gift = new TransactionGift();
    $data = $obj_transaction_gift->getSummaryGiftWeekly($start_week, $end_week);

    return $data;
  }

  public function addGiftAll($input)
  {
    $condition = json_decode($input["condition"], true);
    $obj_user = new User();
    $obj_user_activity_repositories = new UserActivityRepositories();
    $obj_trans_gift = new TransactionGift();

    // List user
    $list_user = $obj_user->searchUserByCondition($condition);

    foreach ($list_user as $user) {
      $arr_trans_gift = [
        "user_id" => $user->user_id,
        "login_id" => $user->login_id,
        "member_level" => $user->member_level,
        "type" => TRANSACTION_GIFT_TYPE_BONUS,
        "gift_name" => trim($input["name"]),
        "point" => trim($input["point"]),
        "status" => TRANSACTION_STATUS_SUCCESS,
        "send_mail" => SEND_MAIL_NOT,
        "note" => $input["note"],
      ];

      // Update trans gift
      $obj_trans_gift->insertTransactionGift($arr_trans_gift);

      // Add point for user
      $obj_user_activity_repositories->giftPoint($user->user_id, trim($input["point"]));
    }

    $result = [
      "status" => "success",
      "message" => __("horserace::be_msg.add_gift_bonus_success"),
    ];

    return $result;
  }

  public function removeGiftAll($input)
  {
    $condition = json_decode($input["condition"], true);
    $obj_user = new User();
    $obj_user_activity_repositories = new UserActivityRepositories();
    $obj_trans_gift = new TransactionGift();

    // List user
    $list_user = $obj_user->searchUserByCondition($condition);
    $point = ((integer)trim($input["point"])) * (-1);
    foreach ($list_user as $user) {

      $arr_trans_gift = [
        "user_id" => $user->user_id,
        "login_id" => $user->login_id,
        "member_level" => $user->member_level,
        "type" => TRANSACTION_GIFT_TYPE_BONUS,
        "gift_name" => trim($input["name"]),
        "point" => $point,
        "status" => TRANSACTION_STATUS_SUCCESS,
        "send_mail" => SEND_MAIL_NOT,
        "note" => $input["note"],
      ];

      // Update trans gift
      $obj_trans_gift->insertTransactionGift($arr_trans_gift);

      // Add point for user
      $obj_user_activity_repositories->giftPoint($user->user_id, $point);
    }

    $result = [
      "status" => "success",
      "message" => __("horserace::be_msg.remove_gift_bonus_success"),
    ];

    return $result;
  }
}