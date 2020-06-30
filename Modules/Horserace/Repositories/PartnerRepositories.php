<?php
/**
 * Date 2018-09-10
 */

namespace Modules\Horserace\Repositories;

use DB;
use Hash;
use Modules\Horserace\Entities\Admin;

class PartnerRepositories
{
  public function partnerStore($input)
  {
    $obj_partner = new Admin();
    $arr_partner = [
      'name' => trim($input['name']),
      'login_id' => trim($input['login_id']),
      'password' => Hash::make($input['password']),
      'password_text' => trim($input['password']),
      'role_code' => ROLE_PARTNER,
      'media_code' => trim($input['media_code']),
      'billing_flg' => isset($input["billing_flg"]) ? BILLING_FLG_ENABLE : BILLING_FLG_DISABLE
    ];

    if (trim($input["id"]) != 0) {
      $obj_partner->updateAdmin(trim($input["id"]), $arr_partner);
      $result = [
        'status' => 'success',
        'message' => __("horserace::be_msg.edit_partner_success"),
      ];
    } else {
      $obj_partner->insertAdmin($arr_partner);
      $result = [
        "status" => "success",
        "message" => __("horserace::be_msg.add_partner_success"),
      ];
    }

    return $result;
  }

  public function getEditPartner($id)
  {
    $obj_partner = new Admin();
    $data_edit_partner = $obj_partner->getAdminById($id);
    return $data_edit_partner;
  }

  public function getListPartner()
  {
    $obj_partner = new Admin();
    $list_partner = $obj_partner->getPartner();
    return $list_partner;
  }


  public function partnerDelete($id)
  {
    $obj_partner = new Admin();
    $obj_partner->deleteAdmin($id);
    $result = [
      "status" => "success",
      "message" => __("horserace::be_msg.deleted_partner_success"),
    ];
    return $result;
  }

}