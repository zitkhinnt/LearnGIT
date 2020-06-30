<?php
/**
 * Date 2018-09-10
 */

namespace Modules\Horserace\Repositories;

use DB;
use DateTime;
use hasFile;
use Modules\Horserace\Entities\Gift;
use Modules\Horserace\Entities\TransactionGift;
use Modules\Horserace\Entities\User;
use Modules\Horserace\Http\Controllers\Backend\MailController;

class GiftRepositories
{
  public function giftStore($input)
  {
    $obj_gift = new Gift();
    // Gift
    $arr_gift = [
      'name' => trim($input['name']),
      'type' => trim($input['type']),
      'send_date' => empty($input['send_date']) ? null : trim($input['send_date']),
      'point' => trim($input['point']),
      'content' => trim($input['content']),
      'start_time' => trim($input['start_time']),
      'end_time' => trim($input['end_time']),
    ];

    if (trim($input["id"]) != 0) {
      // Edit
      $obj_gift->updateGift(trim($input["id"]), $arr_gift);
      $result = [
        'status' => 'success',
        'message' => __("horserace::be_msg.edit_gift_success"),
      ];
    } else {
      // Add
      $obj_gift->insertGift($arr_gift);
      $result = [
        "status" => "success",
        "message" => __("horserace::be_msg.add_gift_success"),
      ];
    }
    return $result;
  }

  public function getEditGift($id)
  {
    $obj_gift = new Gift();
    $data_edit_gift = $obj_gift->getGiftById($id);
    return $data_edit_gift;
  }

  public function getListGift()
  {
    $obj_gift = new Gift();
    $list_gift = $obj_gift->getGift();
    return $list_gift;
  }

  public function giftDelete($id)
  {
    $obj_gift = new Gift();
    $obj_gift->deleteGift($id);
    $result = [
      "status" => "success",
      "message" => __("horserace::be_msg.deleted_gift_success"),
    ];
    return $result;
  }

  public function giftAddPointByType($user_id, $type)
  {
    $obj_gift = new Gift();
    $obj_user = new User();
    $obj_trans_gift = new TransactionGift();
    $obj_mail_controller = new MailController();
    $obj_user_activity_repositories = new UserActivityRepositories();
    $user = $obj_user->getUserById($user_id);

    $obj_trans_gift_repositories = new TransactionGiftRepositories();

    // Get gift register
    $list_gift = $obj_gift->getGiftByType($type);

    // Create transaction gift
    foreach ($list_gift as $gift) {

      if (is_null($user)) {
        continue;
      }

      // Check user send gift
      if ($obj_trans_gift->haveSendGift($user_id, $gift->id)) {
        continue;
      }

      $arr_trans_gift = [
        "id" => 0,
        "user_id" => $user->id,
        "login_id" => $user->login_id,
        "member_level" => $user->member_level,
        "type" => $type,
        "gift_id" => $gift->id,
        "gift_name" => $gift->name,
        "point" => $gift->point,
        "status" => TRANSACTION_STATUS_SUCCESS,
        "send_mail" => SEND_MAIL_YET,
        "note" => null,
      ];

      $obj_trans_gift_repositories->storeTransactionGift($arr_trans_gift);
      unset($arr_trans_gift);

      // Add point for user
      $obj_user_activity_repositories->giftPoint($user->id, $gift->point);

      // Send mail
      $obj_mail_controller->sendMailGiftByType($user->id, $gift->id);
    }
  }

}