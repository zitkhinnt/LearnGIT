<?php
/**
 * Date 2018-09-10
 */

namespace Modules\Horserace\Repositories;

use DB;
use Modules\Horserace\Entities\MailDepositDetail;
use Modules\Horserace\Entities\MailRegisterDetail;
use Modules\Horserace\Entities\MailTemplate;
use Modules\Horserace\Entities\User;

class MailDepositRepositories
{
  public function storeMailDeposit($input)
  {
    $obj_mail_deposit = new MailDepositDetail();

    // Save data
    $arr_mail_deposit = [
      "user_id" => trim($input["user_id"]),
      "transaction_deposit_id" => trim($input["transaction_deposit_id"]),
      "mail_template_deposit_id" => trim($input["mail_template_deposit_id"]),
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
      $obj_mail_deposit->updateMailDepositDetail(trim($input["id"]), $arr_mail_deposit);
      $result = [
        "status" => "success",
        "message" => __("horserace::be_msg.edit_mail_deposit_success")
      ];
    } else {
      // Create
      $obj_mail_deposit->insertMailDepositDetail($arr_mail_deposit);
      $result = [
        "status" => "success",
        "message" => __("horserace::be_msg.add_mail_deposit_success")
      ];
    }

    return $result;
  }

  public function getMailDepositById($id_mail_deposit)
  {
    $obj_mail_deposit = new MailDepositDetail();
    $mail_deposit = $obj_mail_deposit->getMailDepositDetailById($id_mail_deposit);
    return $mail_deposit;
  }

  public function getMailDeposit()
  {
    $obj_mail_deposit = new MailDepositDetail();
    $list_mail_deposit = $obj_mail_deposit->getMailDepositDetail();
    return $list_mail_deposit;
  }

  public function deleteMailDeposit($id_mail_deposit)
  {
    $obj_mail_deposit = new MailDepositDetail();
    $obj_mail_deposit->deleteMailDepositDetail($id_mail_deposit);
    $result = [
      "status" => "success",
      "message" => __("horserace::be_msg.delete_mail_deposit"),
    ];

    return $result;
  }
}