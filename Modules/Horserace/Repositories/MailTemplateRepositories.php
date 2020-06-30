<?php
/**
 * Date 2018-09-10
 */

namespace Modules\Horserace\Repositories;

use DB;
use Modules\Horserace\Entities\MailTemplate;
use Modules\Horserace\Entities\User;

class MailTemplateRepositories
{
  public function storeMailTemplate($input)
  {
    $obj_mail_template = new MailTemplate();

    // Save data
    $arr_mail_template = [
      "name" => trim($input["name"]),
      "mail_from_address" => trim($input["mail_from_address"]),
      "mail_from_name" => trim($input["mail_from_name"]),
      "type" => trim($input["type"]),
      "mail_title" => trim($input["mail_title"]),
      "mail_body" => $input["mail_body"],
    ];

    if ($input["id"] != 0) {
      // Edit
      $obj_mail_template->updateMailTemplate(trim($input["id"]), $arr_mail_template);
      $result = [
        "status" => "success",
        "message" => __("horserace::be_msg.edit_mail_template_success")
      ];
    } else {
      // Create
      $obj_mail_template->insertMailTemplate($arr_mail_template);
      $result = [
        "status" => "success",
        "message" => __("horserace::be_msg.add_mail_template_success")
      ];
    }

    return $result;
  }

  public function getMailTemplateById($id_mail_template)
  {
    $obj_mail_template = new MailTemplate();
    $mail_template = $obj_mail_template->getMailTemplateById($id_mail_template);
    return $mail_template;
  }

  public function getMailTemplate()
  {
    $obj_mail_template = new MailTemplate();
    $list_mail_template = $obj_mail_template->getMailTemplate();
    return $list_mail_template;
  }

  public function deleteMailTemplate($id_mail_template)
  {
    $obj_mail_template = new MailTemplate();
    $obj_mail_template->deleteMailTemplate($id_mail_template);
    $result = [
      "status" => "success",
      "message" => __("horserace::be_msg.deleted_mail_template_success"),
    ];

    return $result;
  }
}