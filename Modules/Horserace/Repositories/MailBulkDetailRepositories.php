<?php
/**
 * Date 2018-09-10
 */

namespace Modules\Horserace\Repositories;

use DB;
use Modules\Horserace\Entities\MailBulkDetail;
use Modules\Horserace\Entities\MailRegisterDetail;
use Modules\Horserace\Entities\MailTemplate;
use Modules\Horserace\Entities\User;

class MailBulkDetailRepositories
{
  public function storeMailBulkDetail($input)
  {
    $obj_mail_bulk_detail = new MailBulkDetail();

    // Save data
    $arr_mail_bulk_detail = [
      "user_id" => trim($input["user_id"]),
      "mail_bulk_id" => trim($input["mail_bulk_id"]),
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
      $obj_mail_bulk_detail->updateMailBulkDetail(trim($input["id"]), $arr_mail_bulk_detail);
      $result = [
        "status" => "success",
        "message" => __("horserace::be_msg.edit_mail_bulk_detail_success")
      ];
    } else {
      // Create
      $obj_mail_bulk_detail->insertMailBulkDetail($arr_mail_bulk_detail);
      $result = [
        "status" => "success",
        "message" => __("horserace::be_msg.add_mail_bulk_detail_success")
      ];
    }

    return $result;
  }

  public function getMailBulkDetailById($id_mail_bulk_detail)
  {
    $obj_mail_bulk_detail = new MailBulkDetail();
    $mail_bulk_detail = $obj_mail_bulk_detail->getMailBulkDetailById($id_mail_bulk_detail);
    return $mail_bulk_detail;
  }

  public function getMailBulkDetail()
  {
    $obj_mail_bulk_detail = new MailBulkDetail();
    $list_mail_bulk_detail = $obj_mail_bulk_detail->getMailBulkDetail();
    return $list_mail_bulk_detail;
  }

  public function deleteMailBulkDetail($id_mail_bulk_detail)
  {
    $obj_mail_bulk_detail = new MailBulkDetail();
    $obj_mail_bulk_detail->deleteMailBulkDetail($id_mail_bulk_detail);
    $result = [
      "status" => "success",
      "message" => __("horserace::be_msg.delete_mail_bulk_detail"),
    ];

    return $result;
  }
  public function searchMailBulkDetailToShowMailContactPage($input, $page, $limit)
  {
    $obj_mail_bulk_detail = new MailBulkDetail();
    $list_mail_bulk_detail = $obj_mail_bulk_detail->searchMailBulkDetailToShowMailCotactPageByCondition($input, $page, $limit); 
    return $list_mail_bulk_detail;
  }

  public function searchMailBulkDetailToShowMailContactPageNotJoinActivity($input, $page, $limit)
  {
    $obj_mail_bulk_detail = new MailBulkDetail();
    $list_mail_bulk_detail = $obj_mail_bulk_detail->searchMailBulkDetailToShowMailCotactPageByConditionNotJoinActivity($input, $page, $limit); 
    return $list_mail_bulk_detail;
  }

  
  public function searchUserIdSendMailBulkByCondition($input)
  {
    $obj_mail_bulk_detail = new MailBulkDetail();
    $array_user_id = $obj_mail_bulk_detail->searchUserIdSendMailBulkByCondition($input); 
    return $array_user_id;
  }

    public function getMailBulkDetailByUserIdToShowMailContactPage($user_id, $page=null, $limit=null)
  {
    $obj_mail_bulk_detail = new MailBulkDetail();
    $arr_mail = $obj_mail_bulk_detail->getMailBulkDetailByUserIdToShowMailContactPage($user_id, $page, $limit);
    return $arr_mail;
  }  

}