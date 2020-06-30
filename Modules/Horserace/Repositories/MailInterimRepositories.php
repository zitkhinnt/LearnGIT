<?php
/**
 * Date 2018-09-10
 */

namespace Modules\Horserace\Repositories;

use DB;
use Modules\Horserace\Entities\MailInterimDetail;
use Modules\Horserace\Entities\MailTemplate;
use Modules\Horserace\Entities\User;

class MailInterimRepositories
{
  public function storeMailInterim($input)
  {
    $obj_mail_interim = new MailInterimDetail();

    // Save data
    $arr_mail_interim = [
      "user_id" => trim($input["user_id"]),
      "mail_template_interim_id" => trim($input["mail_template_interim_id"]),
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
      $obj_mail_interim->updateMailInterimDetail(trim($input["id"]), $arr_mail_interim);
      $result = [
        "status" => "success",
        "message" => __("horserace::be_msg.edit_mail_interim_success")
      ];
    } else {
      // Create
      $obj_mail_interim->insertMailInterimDetail($arr_mail_interim);
      // Send mail

      $result = [
        "status" => "success",
        "message" => __("horserace::be_msg.add_mail_interim_success")
      ];
    }

    return $result;
  }

  public function getMailInterimById($id_mail_interim)
  {
    $obj_mail_interim = new MailInterimDetail();
    $mail_interim = $obj_mail_interim->getMailInterimDetailById($id_mail_interim);
    return $mail_interim;
  }

  public function getMailInterim()
  {
    $obj_mail_interim = new MailInterimDetail();
    $list_mail_interim = $obj_mail_interim->getMailInterimDetail();
    return $list_mail_interim;
  }

  public function deleteMailInterim($id_mail_template)
  {
    $obj_mail_interim = new MailInterimDetail();
    $obj_mail_interim->deleteMailInterimDetail($id_mail_template);
    $result = [
      "status" => "success",
      "message" => __("horserace::be_msg.delete_mail_interim"),
    ];

    return $result;
  }
}