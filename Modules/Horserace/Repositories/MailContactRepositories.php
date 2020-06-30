<?php
/**
 * Date 2018-09-10
 */

namespace Modules\Horserace\Repositories;

use DB;
use Hash;
use DateTime;
use hasFile;

use Modules\Horserace\Entities\MailContact;

class MailContactRepositories
{

  public function mailContactStore($input)
  {
    $obj_mail_contact = new MailContact();
    $arr_mail_contact = [
      'user_id' => trim($input['user_id']),
      'mail_from_address' => trim($input['mail_from_address']),
      'mail_from_name' => trim($input['mail_from_name']),
      'mail_to_address' => trim($input['mail_to_address']),
      'mail_to_name' => trim($input['mail_to_name']),
      'mail_title' => trim($input['mail_title']),
      'mail_body' => trim($input['mail_body']),
      'mail_html' => $input['mail_html'] ?? '' ,
      'attachments' => $input['mail_attachments'] ?? '[]',
      'user_read_at' => $input["user_read_at"] ?? null,
      'admin_read_at' => $input["admin_read_at"] ?? null,
      'status' => $input["status"] ?? 0,
    ];

    $obj_mail_contact->insertMailContact($arr_mail_contact);

    $result = [
      "status" => "success",
      "message" => __("horserace::be_msg.add_mail_contact_success"),
    ];
    return $result;
  }

  public function getListMailContact($input)
  {
    $obj_mail_contact = new MailContact();
    $list_mail_contact = $obj_mail_contact->getMailContact($input);
    return $list_mail_contact;
  }

  public function adminReadMailByUserId($user_id)
  {
    $obj_mail_contact = new MailContact();
    $obj_mail_contact->adminReadMailByUserId((integer)$user_id);
  }

  public function adminReadMailGuest($mail_guest)
  {
    $obj_mail_contact = new MailContact();
    $obj_mail_contact->adminReadMailGuest($mail_guest);
  }

  public function adminReadAllMail($arr_user_id)
  {
    foreach ($arr_user_id as $user_id) {
      if (is_numeric($user_id)) {
        $this->adminReadMailByUserId($user_id);
      } else {
        $this->adminReadMailGuest($user_id);
      }
    }

    $result = [
      "status" => "success",
      "message" => __("horserace::be_msg.read_all_mail_contact_success"),
    ];
    return $result;
  }

  public function adminDeletedAllMail($arr_user_id)
  {
    foreach ($arr_user_id as $user_id) {
      if (is_numeric($user_id)) {
        $this->adminDeletedMailByUserId($user_id);
      } else {
        $this->adminDeletedMailGuest($user_id);
      }
    }

    $result = [
      "status" => "success",
      "message" => __("horserace::be_msg.deleted_all_mail_contact_success"),
    ];
    return $result;
  }

  public function mailContactDelete($input)
  {
    $obj_mail_contact = new MailContact();

    if (isset($input["delete"])) {
      foreach ($input["delete"] as $user_id) {
        $obj_mail_contact->deleteMailContactByUserId($user_id);
      }
    }

    $result = [
      "status" => "success",
      "message" => __("horserace::be_msg.deleted_mail_contact_success"),
    ];
    return $result;
  }

  public function searchMailContact($input, $page = null, $limit=null)
  {
    $obj_mail_contact = new MailContact();
    $list_mail_contact = $obj_mail_contact->searchMailContactByCondition($input, $page, $limit);
    return $list_mail_contact;
  }
  public function searchMailContactNotJoinActivity($input, $page = null, $limit=null)
  {
    $obj_mail_contact = new MailContact();
    $list_mail_contact = $obj_mail_contact->searchMailContactByConditionNotJoinActivity($input, $page, $limit);
    return $list_mail_contact;
  }

  public function adminDeletedMailByUserId($user_id)
  {
    $obj_mail_contact = new MailContact();
    $obj_mail_contact->adminDeletedMailByUserId((integer)$user_id);
    $result = [
      "status" => "success",
      "message" => __("horserace::be_msg.deleted_mail_contact_success"),
    ];

    return $result;
  }

  public function adminDeletedMailGuest($mail_guest)
  {
    $obj_mail_contact = new MailContact();
    $obj_mail_contact->adminDeletedMailGuest($mail_guest);
    $result = [
      "status" => "success",
      "message" => __("horserace::be_msg.deleted_mail_contact_success"),
    ];

    return $result;
  }

  public function getMailGuest($input)
  {
    $obj_mail_contact = new MailContact();
    $list_mail = $obj_mail_contact->getMailGuest($input);
    $arr_mail = array();

    //
    foreach ($list_mail as $item) {
      $mail_address = "";
      switch ($item->status) {
        case MAIL_CONTACT_ADMIN_SEND:
          $mail_address = $item->mail_to_address;
          if (isset($arr_mail[$item->mail_to_address])) {
            $user_info = (array)$arr_mail[$item->mail_to_address]["user_info"];
          } else {
            $user_info = array();
            $user_info = [
              'id' => GUEST_0,
              'nickname' => GUEST_NICKNAME . '_' . $item->mail_to_address,
              'mail_pc' => $item->mail_to_address,
              'last_mail' => $item->created_at,
              'admin_not_read' => 0,
              'admin_send' => 0,
              'total_mail' => 0,
              'user_send' => 0,
            ];
          }
          break;

        case MAIL_CONTACT_USER_SEND:
          $mail_address = $item->mail_from_address;
          if (isset($arr_mail[$item->mail_from_address])) {
            $user_info = (array)$arr_mail[$item->mail_from_address]["user_info"];
          } else {
            $user_info = array();
            $user_info = [
              'id' => GUEST_0,
              'nickname' => GUEST_NICKNAME . '_' . $item->mail_from_address,
              'mail_pc' => $item->mail_from_address,
              'last_mail' => $item->created_at,
              'admin_not_read' => 0,
              'admin_send' => 0,
              'total_mail' => 0,
              'user_send' => 0,
            ];
          }
          break;
      }

      // Mail admin not read
      if (is_null($item->admin_read_at)) {
        $user_info["admin_not_read"] += 1;
      }
      // Set who send
      if ($item->status == MAIL_CONTACT_ADMIN_SEND) {
        $user_info["admin_send"] += 1;
      } else {
        $user_info["user_send"] += 1;
      }
      $user_info["total_mail"] += 1;

      $arr_mail[$mail_address]["user_info"] = (object)$user_info;
      $arr_mail[$mail_address][] = $item;
    }

    return $arr_mail;
  }

  public function numberMailContactUnread()
  {
    $obj_mail_contact = new MailContact();
    $number = $obj_mail_contact->getNumberMailUnread();
    return $number;
  }

  public function getMailAdminUnreadByUserId($user_id, $page=null, $limit=null)
  {
    $obj_mail_contact = new MailContact();
    $arr_mail = $obj_mail_contact->getMailContactAdminUnreadByUserId($user_id, $page, $limit);
    return $arr_mail;
  }

  public function getMailAdminUnreadByMailPc($mail_pc, $page=null, $limit=null)
  {
    $obj_mail_contact = new MailContact();
    $arr_mail = $obj_mail_contact->getMailContactAdminUnreadByMailPc($mail_pc, $page, $limit);
    return $arr_mail;
  }
  public function searchUserIdSendMailContactByCondition($input)
  {
    $obj_mail_contact = new MailContact();
    $array_user_id = $obj_mail_contact->searchUserIdSendMailContactByCondition($input); 
    return $array_user_id;
  }  
  public function getMailAdminReadByUserIdByCondition($user_id, $input, $page=null, $limit=null)
  {
    $obj_mail_contact = new MailContact();
    $arr_mail = $obj_mail_contact->getMailContactAdminReadByUserIdByCondition($user_id, $input, $page, $limit);
    return $arr_mail;
  }
  public function getMailAdminReadByMailPcByCondition($mail_pc, $input, $page=null, $limit=null)
  {
    $obj_mail_contact = new MailContact();
    $arr_mail = $obj_mail_contact->getMailContactAdminReadByMailPcByCondition($mail_pc, $input, $page, $limit);
    return $arr_mail;
  }

}