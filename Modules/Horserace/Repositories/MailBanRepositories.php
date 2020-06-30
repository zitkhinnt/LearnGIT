<?php
/**
 * Date 2018-09-10
 */

namespace Modules\Horserace\Repositories;

use DB;
use Modules\Horserace\Entities\MailBan;

class MailBanRepositories
{
  public function MailBanStore($input)
  {
    $obj_mail_ban = new MailBan();
    $arr_mail_ban = [
      'mail' => trim($input['mail']),
    ];
    if (trim($input['id']) == 0) {
      // Add
      $obj_mail_ban->insertMailBan($arr_mail_ban);
      $result = [
        "status" => "success",
        "message" => __("horserace::be_msg.add_mail_ban_success"),
      ];
    } else {
      // Edit
      $obj_mail_ban->updateMailBan(trim($input['id']), $arr_mail_ban);
      $result = [
        'status' => 'success',
        'message' => __("horserace::be_msg.edit_mail_ban_success"),
      ];
    }
    return $result;
  }

  public function getEditMailBan($id)
  {
    $obj_mail_ban = new MailBan();
    $data_edit_mail_ban = $obj_mail_ban->getMailBanById($id);
    return $data_edit_mail_ban;
  }

  public function getListMailBan()
  {
    $obj_mail_ban = new MailBan();
    $list_mail_ban = $obj_mail_ban->getMailBan();
    return $list_mail_ban;
  }

  public function MailBanDelete($id)
  {
    $obj_mail_ban = new MailBan();
    $obj_mail_ban->deleteMailBan($id);
    $result = [
      "status" => "success",
      "message" => __("horserace::be_msg.deleted_mail_ban_success"),
    ];
    return $result;
  }

  public function checkMailBan($mail)
  {
    $obj_mail_ban = new MailBan();
    $is_mail_ban = $obj_mail_ban->isMailBan($mail);
    if ($is_mail_ban) {
      $result["status"] = "danger";
      $result["message"] = __("horserace::be_msg.address_mail_had_ban");
    } else {
      $result["status"] = "success";
    }

    return $result;
  }

  public function isMailBan($mail)
  {
    $obj_mail_ban = new MailBan();
    $is_mail_ban = $obj_mail_ban->isMailBan($mail);
    return $is_mail_ban;
  }
}