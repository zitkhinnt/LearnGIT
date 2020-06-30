<?php
/**
 * Date 2018-09-10
 */

namespace Modules\Horserace\Repositories;

use DB;
use Modules\Horserace\Entities\MailGiftDetail;
use Modules\Horserace\Entities\MailRegisterDetail;
use Modules\Horserace\Entities\MailTemplate;
use Modules\Horserace\Entities\User;

class MailGiftRepositories
{
  public function storeMailGift($input)
  {
    $obj_mail_gift = new MailGiftDetail();

    // Save data
    $arr_mail_gift = [
      "user_id" => trim($input["user_id"]),
      "gift_id" => trim($input["gift_id"]),
      "mail_from_address" => trim($input["mail_from_address"]),
      "mail_from_name" => trim($input["mail_from_name"]),
      "mail_to_address" => trim($input["mail_to_address"]),
      "mail_to_name" => trim($input["mail_to_name"]),
      "mail_title" => trim($input["mail_title"]),
      "mail_body" => $input["mail_body"],
      "status" => trim($input["status"]),
      "read_at" => $input["read_at"],
    ];

    if ($input["id"] != 0) {
      // Edit
      $obj_mail_gift->updateMailGiftDetail(trim($input["id"]), $arr_mail_gift);
      $result = [
        "status" => "success",
        "message" => __("horserace::be_msg.edit_mail_gift_success")
      ];
    } else {
      // Create
      $obj_mail_gift->insertMailGiftDetail($arr_mail_gift);
      $result = [
        "status" => "success",
        "message" => __("horserace::be_msg.add_mail_gift_success")
      ];
    }

    return $result;
  }

  public function getMailGiftById($id_mail_gift)
  {
    $obj_mail_gift = new MailGiftDetail();
    $mail_gift = $obj_mail_gift->getMailGiftDetailById($id_mail_gift);
    return $mail_gift;
  }

  public function getMailGift()
  {
    $obj_mail_gift = new MailGiftDetail();
    $list_mail_gift = $obj_mail_gift->getMailGiftDetail();
    return $list_mail_gift;
  }

  public function deleteMailGift($id_mail_gift)
  {
    $obj_mail_gift = new MailGiftDetail();
    $obj_mail_gift->deleteMailGiftDetail($id_mail_gift);
    $result = [
      "status" => "success",
      "message" => __("horserace::be_msg.delete_mail_gift"),
    ];

    return $result;
  }
}