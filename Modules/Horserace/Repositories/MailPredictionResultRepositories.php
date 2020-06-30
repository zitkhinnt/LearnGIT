<?php
/**
 * Date 2018-09-10
 */

namespace Modules\Horserace\Repositories;

use DB;
use Modules\Horserace\Entities\MailPredictionResultDetail;
use Modules\Horserace\Entities\MailRegisterDetail;
use Modules\Horserace\Entities\MailTemplate;
use Modules\Horserace\Entities\User;

class MailPredictionResultRepositories
{
  public function storeMailPredictionResult($input)
  {
    $obj_mail_prediction_result = new MailPredictionResultDetail();

    // Save data
    $arr_mail_prediction_result = [
      "user_id" => trim($input["user_id"]),
      "prediction_id" => trim($input["prediction_id"]),
      "transaction_prediction_result_id" => trim($input["transaction_prediction_result_id"]),
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
      $obj_mail_prediction_result->updateMailPredictionResultDetail(trim($input["id"]), $arr_mail_prediction_result);
      $result = [
        "status" => "success",
        "message" => __("horserace::be_msg.edit_mail_prediction_result_success")
      ];
    } else {
      // Create
      $obj_mail_prediction_result->insertMailPredictionResultDetail($arr_mail_prediction_result);
      $result = [
        "status" => "success",
        "message" => __("horserace::be_msg.add_mail_prediction_result_success")
      ];
    }

    return $result;
  }

  public function getMailPredictionResultById($id_mail_prediction_result)
  {
    $obj_mail_prediction_result = new MailPredictionResultDetail();
    $mail_prediction_result = $obj_mail_prediction_result->getMailPredictionResultDetailById($id_mail_prediction_result);
    return $mail_prediction_result;
  }

  public function getMailPredictionResult()
  {
    $obj_mail_prediction_result = new MailPredictionResultDetail();
    $list_mail_prediction_result = $obj_mail_prediction_result->getMailPredictionResultDetail();
    return $list_mail_prediction_result;
  }

  public function deleteMailPredictionResult($id_mail_prediction_result)
  {
    $obj_mail_prediction_result = new MailPredictionResultDetail();
    $obj_mail_prediction_result->deleteMailPredictionResultDetail($id_mail_prediction_result);
    $result = [
      "status" => "success",
      "message" => __("horserace::be_msg.delete_mail_prediction_result"),
    ];

    return $result;
  }
}