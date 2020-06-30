<?php
/**
 * Date 2018-09-10
 */

namespace Modules\Horserace\Repositories;

use DB;
use Modules\Horserace\Entities\MailPredictionOpenDetail;
use Modules\Horserace\Entities\MailRegisterDetail;
use Modules\Horserace\Entities\MailTemplate;
use Modules\Horserace\Entities\User;

class MailPredictionOpenRepositories
{
  public function storeMailPredictionOpen($input)
  {
    $obj_mail_prediction_open = new MailPredictionOpenDetail();

    // Save data
    $arr_mail_prediction_open = [
      "user_id" => trim($input["user_id"]),
      "prediction_id" => trim($input["prediction_id"]),
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
      $obj_mail_prediction_open->updateMailPredictionOpenDetail(trim($input["id"]), $arr_mail_prediction_open);
      $result = [
        "status" => "success",
        "message" => __("horserace::be_msg.edit_mail_prediction_open_success")
      ];
    } else {
      // Create
      $obj_mail_prediction_open->insertMailPredictionOpenDetail($arr_mail_prediction_open);
      $result = [
        "status" => "success",
        "message" => __("horserace::be_msg.add_mail_prediction_open_success")
      ];
    }

    return $result;
  }

  public function getMailPredictionOpenById($id_mail_prediction_open)
  {
    $obj_mail_prediction_open = new MailPredictionOpenDetail();
    $mail_prediction_open = $obj_mail_prediction_open->getMailPredictionOpenDetailById($id_mail_prediction_open);
    return $mail_prediction_open;
  }

  public function getMailPredictionOpen()
  {
    $obj_mail_prediction_open = new MailPredictionOpenDetail();
    $list_mail_prediction_open = $obj_mail_prediction_open->getMailPredictionOpenDetail();
    return $list_mail_prediction_open;
  }

  public function deleteMailPredictionOpen($id_mail_prediction_open)
  {
    $obj_mail_prediction_open = new MailPredictionOpenDetail();
    $obj_mail_prediction_open->deleteMailPredictionOpenDetail($id_mail_prediction_open);
    $result = [
      "status" => "success",
      "message" => __("horserace::be_msg.delete_mail_prediction_open"),
    ];

    return $result;
  }
}