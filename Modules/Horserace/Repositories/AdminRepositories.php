<?php
/**
 * Date 2018-09-10
 */

namespace Modules\Horserace\Repositories;

use DB;
use Hash;
use Modules\Horserace\Entities\Admin;

class AdminRepositories
{
  public function adminStore($input)
  {
    $obj_admin = new Admin();
    if(isset($input['menu_id'])){
      $roleMenu = implode(",", $input['menu_id']);
    }else{
      $roleMenu ='';
    }
    $arr_admin = [
      'name' => trim($input['name']),
      'email' => trim($input['email']),
      'login_id' => trim($input['login_id']),
      'password' => Hash::make($input['password']),
      'password_text' => trim($input['password']),
      'role_menu' => $roleMenu,
    ];

    if (trim($input["id"]) != 0) {
      $obj_admin->updateAdmin(trim($input["id"]), $arr_admin);
      $result = [
        'status' => 'success',
        'message' => __("horserace::be_msg.edit_admin_success"),
      ];
    } else {
      $arr_admin['role_code'] = ROLE_STAFF;
      $obj_admin->insertAdmin($arr_admin);
      $result = [
        "status" => "success",
        "message" => __("horserace::be_msg.add_admin_success"),
      ];
    }

    return $result;
  }

  public function updateHiddenMailAdmin($input)
  {
    $obj_admin = new Admin();
    $arr_admin= [
      'role_email' => $input['checked']
    ];
    $obj_admin->updateAdmin(trim($input["id"]), $arr_admin);
    $result = [
      'status' => 'success',
      'message' => __("horserace::be_msg.edit_admin_success"),
    ];
  
    return $result;
  }

  public function getEditAdmin($id)
  {
    $obj_admin = new Admin();
    $data_edit_admin = $obj_admin->getAdminById($id);
    return $data_edit_admin;
  }

  public function getListAdmin()
  {
    $obj_admin = new Admin();
    $list_admin = $obj_admin->getAdmin();
    return $list_admin;
  }


  public function adminDelete($id)
  {
    $obj_admin = new Admin();
    $obj_admin->deleteAdmin($id);
    $result = [
      "status" => "success",
      "message" => __("horserace::be_msg.deleted_admin_success"),
    ];
    return $result;
  }

  public function checkRouterPermission($current_router_name, $current_admin)
  {
    if ($router = DB::table('router_menu')->where('name', $current_router_name)->first()) {
      $menu_id = $router->menuid; //11
      $menu_array = explode(",", $current_admin->role_menu); // [11,33,44,112]

      return in_array($menu_id, $menu_array);
    } else {
      // cannot detect current router
      return false;
    }
  }

}