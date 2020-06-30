<?php
/**
 * Date 2018-09-10
 */

namespace Modules\Horserace\Repositories;

use DB;
use Modules\Horserace\Entities\MailBulk;
use Modules\Horserace\Entities\MailBulkDone;
use Modules\Horserace\Entities\MailRegisterDetail;
use Modules\Horserace\Entities\MailTemplate;
use Modules\Horserace\Entities\User;

class MailBulkRepositories
{
  public function storeMailBulk($input)
  {
    $obj_mail_bulk = new MailBulk();
    $obj_user = new User;

    // Save data
    $arr_mail_bulk = [
      "mail_from_address" => trim($input["mail_from_address"]),
      "mail_from_name" => trim($input["mail_from_name"]),
      "mail_title" => trim($input["mail_title"]),
      "mail_body" => $input["mail_body"],
      "reserve_datetime" => $input["reserve_datetime"],
      "condition" => $input["condition"],
    ];

    // Get list user
    $condition = json_decode($input["condition"], true);
    $list_user = $obj_user->searchUserByCondition($condition);
    foreach($list_user as $key=>$value)
      if($list_user[$key]->member_level == MEMBER_LEVEL_EXCEPT || $list_user[$key]->stop_mail== STOP_MAIL_ENABLE || strlen(trim($list_user[$key]->mail_pc))==0)
        unset($list_user[$key]);  
    
    $arr_mail_bulk["total_user"] = count($list_user);

    // Save list user
    $arr_user = array();
    foreach ($list_user as $user) {
      $arr_user[$user->user_id] = $user->user_id;
    }
    $arr_mail_bulk["list_user"] = json_encode($arr_user);

    if ($input["id"] != 0) {
      // Edit
      $obj_mail_bulk->updateMailBulk(trim($input["id"]), $arr_mail_bulk);
      $result = [
        "status" => "success",
        "message" => __("horserace::be_msg.edit_mail_bulk_success")
      ];
    } else {
      // Create
      $obj_mail_bulk->insertMailBulk($arr_mail_bulk);
      $result = [
        "status" => "success",
        "message" => __("horserace::be_msg.add_mail_bulk_success")
      ];
    }

    return $result;
  }

  public function getMailBulkById($id_mail_bulk)
  {
    $obj_mail_bulk = new MailBulk();
    $mail_bulk = $obj_mail_bulk->getMailBulkById($id_mail_bulk);
    return $mail_bulk;
  }

  public function getMailBulk()
  {
    $obj_mail_bulk = new MailBulk();
    $list_mail_bulk = $obj_mail_bulk->getMailBulk();
    return $list_mail_bulk;
  }

  public function deleteMailBulk($id_mail_bulk)
  {
    $obj_mail_bulk = new MailBulk();
    $obj_mail_bulk->deleteMailBulk($id_mail_bulk);
    $result = [
      "status" => "success",
      "message" => __("horserace::be_msg.deleted_mail_bulk_success"),
    ];

    return $result;
  }

  public function getInfoMailBulk()
  {
    $obj_mail_bulk = new MailBulk();
    $obj_mail_bulk_done = new MailBulkDone();

    // Get mail bulk
    $info_mail_bulk = $obj_mail_bulk->getMailBulk();

    // Get mail done
    foreach ($info_mail_bulk as $key => $mail_bulk) {
      $mail_bulk_done = $obj_mail_bulk_done->getMailBulkDoneByPredictionId($mail_bulk->id);
      if (is_null($mail_bulk_done)) {
        // Not send
        $info_mail_bulk[$key]->read_number = 0;
        $info_mail_bulk[$key]->send_success_number = 0;
        $info_mail_bulk[$key]->daemon = 0;
        $info_mail_bulk[$key]->rate_daemon = 0;
      } else {
        // Have send
        $info_mail_bulk[$key]->read_number = $mail_bulk_done->read_number;
        $info_mail_bulk[$key]->send_success_number = $mail_bulk_done->send_success_number;
        $mail_bulk->daemon = (integer)($mail_bulk_done->total_user) - (integer)($mail_bulk_done->send_success_number);
        // Mail bulk done
        if ($mail_bulk_done->total_user == 0) {
          $mail_bulk->rate_daemon = number_format(0, 2, '.', '');
        } else {

          $mail_bulk->rate_daemon = number_format(((float)($mail_bulk->daemon / $mail_bulk_done->total_user) * 100), 2, '.', '');
        }
      }
      unset($mail_bulk_done);
    }
    return $info_mail_bulk;
  }

  public function getSearchInfoMailBulk($input)
  {
    $obj_mail_bulk = new MailBulk();
    $obj_mail_bulk_done = new MailBulkDone();

    // Get mail bulk
    $info_mail_bulk = $obj_mail_bulk->getSearchMailBulk($input);
    // Get mail done
    foreach ($info_mail_bulk['result'] as $key => $mail_bulk) {
      $mail_bulk_done = $obj_mail_bulk_done->getMailBulkDoneByPredictionId($mail_bulk->id);
      if (is_null($mail_bulk_done)) {
        // Not send
        $info_mail_bulk['result'][$key]->read_number = 0;
        $info_mail_bulk['result'][$key]->send_success_number = 0;
        $info_mail_bulk['result'][$key]->daemon = 0;
        $info_mail_bulk['result'][$key]->rate_daemon = 0;
      } else {
        // Have send
        $info_mail_bulk['result'][$key]->read_number = $mail_bulk_done->read_number;
        $info_mail_bulk['result'][$key]->send_success_number = $mail_bulk_done->send_success_number;
        $mail_bulk->daemon = (int) ($mail_bulk_done->total_user) - (int) ($mail_bulk_done->send_success_number);
        // Mail bulk done
        if ($mail_bulk_done->total_user == 0) {
          $mail_bulk->rate_daemon = number_format(0, 2, '.', '');
        } else {

          $mail_bulk->rate_daemon = number_format(((float) ($mail_bulk->daemon / $mail_bulk_done->total_user) * 100), 2, '.', '');
        }
      }
      unset($mail_bulk_done);
    };
    return $info_mail_bulk;
  }

  public function changeStatusMailBulk($id_mail, $status)
  {
    $obj_mail_bulk = new MailBulk();
    $arr_mail_bulk = [
      "status" => $status,
    ];

    // Update mail bulk
    $obj_mail_bulk->updateMailBulk($id_mail, $arr_mail_bulk);

    $result = [
      "status" => "success",
      "message" => __("horserace::be_msg.change_status_mail_bulk_success")
    ];

    return $result;
  }
  public function applyMailBulk($id_mail, $data)
  {
    $obj_mail_bulk = new MailBulk();
    // Update mail bulk
    $obj_mail_bulk->updateMailBulk($id_mail, $data);
    $result = [
      "status" => "success",
      "message" => __("horserace::be_msg.edit_mail_bulk_success")
    ];

    return $result;
  }
}