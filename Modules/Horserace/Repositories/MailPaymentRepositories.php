<?php
/**
 * Date 2018-09-10
 */

namespace Modules\Horserace\Repositories;

use DB;
use Modules\Horserace\Entities\MailPaymentDetail;
use Modules\Horserace\Entities\MailRegisterDetail;
use Modules\Horserace\Entities\MailTemplate;
use Modules\Horserace\Entities\User;

class MailPaymentRepositories
{
  public function storeMailPayment($input)
  {
    $obj_mail_payment = new MailPaymentDetail();

    // Save data
    $arr_mail_payment = [
      "user_id" => trim($input["user_id"]),
      "transaction_payment_id" => trim($input["transaction_payment_id"]),
      "mail_template_payment_id" => trim($input["mail_template_payment_id"]),
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
      $obj_mail_payment->updateMailPaymentDetail(trim($input["id"]), $arr_mail_payment);
      $result = [
        "status" => "success",
        "message" => __("horserace::be_msg.edit_mail_payment_success")
      ];
    } else {
      // Create
      $obj_mail_payment->insertMailPaymentDetail($arr_mail_payment);
      $result = [
        "status" => "success",
        "message" => __("horserace::be_msg.add_mail_payment_success")
      ];
    }

    return $result;
  }

  public function getMailPaymentById($id_mail_payment)
  {
    $obj_mail_payment = new MailPaymentDetail();
    $mail_payment = $obj_mail_payment->getMailPaymentDetailById($id_mail_payment);
    return $mail_payment;
  }

  public function getMailPayment()
  {
    $obj_mail_payment = new MailPaymentDetail();
    $list_mail_payment = $obj_mail_payment->getMailPaymentDetail();
    return $list_mail_payment;
  }

  public function deleteMailPayment($id_mail_payment)
  {
    $obj_mail_payment = new MailPaymentDetail();
    $obj_mail_payment->deleteMailPaymentDetail($id_mail_payment);
    $result = [
      "status" => "success",
      "message" => __("horserace::be_msg.delete_mail_payment"),
    ];

    return $result;
  }
}