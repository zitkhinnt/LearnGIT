<?php
/**
 * Date 2018-09-10
 */

namespace Modules\Horserace\Repositories;

use DB;
use Modules\Horserace\Entities\MailScheduleDetail;
use Modules\Horserace\Entities\MailRegisterDetail;
use Modules\Horserace\Entities\MailTemplate;
use Modules\Horserace\Entities\User;

class MailScheduleDetailRepositories
{
  public function storeMailScheduleDetail($input)
  {
    $obj_mail_schedule_detail = new MailScheduleDetail();

    // Save data
    $arr_mail_schedule_detail = [
      "user_id" => trim($input["user_id"]),
      "mail_schedule_id" => trim($input["mail_schedule_id"]),
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
      $obj_mail_schedule_detail->updateMailScheduleDetail(trim($input["id"]), $arr_mail_schedule_detail);
      $result = [
        "status" => "success",
        "message" => __("horserace::be_msg.edit_mail_schedule_detail_success")
      ];
    } else {
      // Create
      $obj_mail_schedule_detail->insertMailScheduleDetail($arr_mail_schedule_detail);
      $result = [
        "status" => "success",
        "message" => __("horserace::be_msg.add_mail_schedule_detail_success")
      ];
    }

    return $result;
  }

  public function getMailScheduleDetailById($id_mail_schedule_detail)
  {
    $obj_mail_schedule_detail = new MailScheduleDetail();
    $mail_schedule_detail = $obj_mail_schedule_detail->getMailScheduleDetailById($id_mail_schedule_detail);
    return $mail_schedule_detail;
  }

  public function getMailScheduleDetail()
  {
    $obj_mail_schedule_detail = new MailScheduleDetail();
    $list_mail_schedule_detail = $obj_mail_schedule_detail->getMailScheduleDetail();
    return $list_mail_schedule_detail;
  }

  public function deleteMailScheduleDetail($id_mail_schedule_detail)
  {
    $obj_mail_schedule_detail = new MailScheduleDetail();
    $obj_mail_schedule_detail->deleteMailScheduleDetail($id_mail_schedule_detail);
    $result = [
      "status" => "success",
      "message" => __("horserace::be_msg.delete_mail_schedule_detail"),
    ];

    return $result;
  }
}