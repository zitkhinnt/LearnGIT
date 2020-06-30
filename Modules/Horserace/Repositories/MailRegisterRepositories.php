<?php
/**
 * Date 2018-09-10
 */

namespace Modules\Horserace\Repositories;

use DB;
use Modules\Horserace\Entities\MailRegisterDetail;
use Modules\Horserace\Entities\MailTemplate;
use Modules\Horserace\Entities\User;

class MailRegisterRepositories
{
  public function storeMailRegister($input)
  {
    $obj_mail_register = new MailRegisterDetail();

    // Save data
    $arr_mail_register = [
      "user_id" => trim($input["user_id"]),
      "mail_template_register_id" => trim($input["mail_template_register_id"]),
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
      $obj_mail_register->updateMailRegisterDetail(trim($input["id"]), $arr_mail_register);
      $result = [
        "status" => "success",
        "message" => __("horserace::be_msg.edit_mail_register_success")
      ];
    } else {
      // Create
      $obj_mail_register->insertMailRegisterDetail($arr_mail_register);
      // Send mail

      $result = [
        "status" => "success",
        "message" => __("horserace::be_msg.add_mail_register_success")
      ];
    }

    return $result;
  }

  public function getMailRegisterById($id_mail_register)
  {
    $obj_mail_register = new MailRegisterDetail();
    $mail_register = $obj_mail_register->getMailRegisterDetailById($id_mail_register);
    return $mail_register;
  }

  public function getMailRegister()
  {
    $obj_mail_register = new MailRegisterDetail();
    $list_mail_register = $obj_mail_register->getMailRegisterDetail();
    return $list_mail_register;
  }

  public function deleteMailRegister($id_mail_template)
  {
    $obj_mail_register = new MailRegisterDetail();
    $obj_mail_register->deleteMailRegisterDetail($id_mail_template);
    $result = [
      "status" => "success",
      "message" => __("horserace::be_msg.delete_mail_register"),
    ];

    return $result;
  }
}