<?php
/**
 * Date 2018-09-10
 */

namespace Modules\Horserace\Repositories;

use DB;
use Modules\Horserace\Entities\MailReplace;


class MailReplaceRepositories
{
  public function mailReplaceStore($input)
  {
    $obj_mail_replace = new MailReplace();
    $arr_mail_replace = [
      'name' => trim($input['name']),
      'type' => isset($input["type"]) ? $input["type"] : 0,
      'source' => trim($input['source']),
    ];

    if (trim($input["id"]) != 0) {
      // edit
      $obj_mail_replace->updateMailReplace(trim($input["id"]), $arr_mail_replace);
      $result = [
        'status' => 'success',
        'message' => __("horserace::be_msg.edit_mail_replace_success"),
      ];
    } else {
      // create user
      $obj_mail_replace->insertMailReplace($arr_mail_replace);
    }


    $result = [
      "status" => "success",
      "message" => __("horserace::be_msg.add_mail_replace_success"),
    ];
    return $result;
  }

  public function getEditMailReplace($id)
  {
    $obj_mail_replace = new MailReplace();
    $data_edit_mail_replace = $obj_mail_replace->getMailReplaceById($id);
    return $data_edit_mail_replace;
  }

  public function getListMailReplace()
  {
    $obj_mail_replace = new MailReplace();
    $list_mail_replace = $obj_mail_replace->getMailReplace();
    return $list_mail_replace;
  }

  public function deleteMailReplace($id)
  {
    $obj_mail_replace = new MailReplace();
    $obj_mail_replace->deleteMailReplace($id);
    $result = [
      "status" => "success",
      "message" => __("horserace::be_msg.delete_mail_replace"),
    ];

    return $result;
  }

}