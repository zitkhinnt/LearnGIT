<?php

namespace Modules\Horserace\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Horserace\Http\Requests\AdminRequest;
use Modules\Horserace\Http\Requests\PartnerRequest;
use Modules\Horserace\Repositories\AdminRepositories;
use Modules\Horserace\Repositories\PartnerRepositories;
use Modules\Horserace\Entities\Menu;

class ManagementController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth:admin');
    $this->middleware('admin');
  }

  // get list admin
  public function admin(Request $request,
                        AdminRepositories $adminRepositories)
  {
    $data['admin'] = $adminRepositories->getListAdmin();
    return view('horserace::backend.management.admin', compact('data'));
  }

  // get view add
  public function addAdmin(Request $request)
  {
    $menuAdmin = new Menu;
    $menuLv1 = $menuAdmin->getListMenu(MENU_LEVEL_1);
    $menuLv2 = $menuAdmin->getListMenu(MENU_LEVEL_2);
    return view('horserace::backend.management.add_admin', compact('menuLv1','menuLv2'));
  }

  // function store record in db
  public function storeAdmin(AdminRequest $request,
                             AdminRepositories $adminRepositories)
  {
    $input = $request->all();
    $result = $adminRepositories->adminStore($input);
    return redirect()->route('admin.admin')->with([
      'flash_level' => $result["status"],
      'flash_message' => $result["message"],
    ]);
  }

      // function store record in db
  public function updateHiddenMailAdmin(Request $request,
    AdminRepositories $adminRepositories)
  {
    $inputs = $request->all();
    $result = $adminRepositories->updateHiddenMailAdmin($inputs);
    return ([
    'flash_level' => $result["status"],
    'flash_message' => $result["message"],
    ]);
  }

  // function get data edit
  public function editAdmin(Request $request, $id,
                            AdminRepositories $adminRepositories)
  {
    $data["admin"] = $adminRepositories->getEditAdmin($id);
    $menuAdmin = new Menu;
    $role = $menuAdmin->getMenuListId($data["admin"]->role_menu);
    $menuLv1 = $menuAdmin->getListMenu(MENU_LEVEL_1);
    $menuLv2= $menuAdmin->getListMenu(MENU_LEVEL_2);
    return view('horserace::backend.management.edit_admin', compact('data','menuLv1','menuLv2','role'));
  }

  public function deleteAdmin(Request $request,
                              AdminRepositories $adminRepositories)
  {
    $input = $request->all();
    $result = $adminRepositories->adminDelete(trim($input["id_delete"]));
    return redirect()->route('admin.admin')->with([
      'flash_level' => $result["status"],
      'flash_message' => $result["message"],
    ]);
  }

  // get list admin
  public function partner(Request $request,
                          PartnerRepositories $partnerRepositories)
  {
    $data['partner'] = $partnerRepositories->getListPartner();
    return view('horserace::backend.management.partner', compact('data'));
  }

  // get view add
  public function addPartner(Request $request)
  {
    return view('horserace::backend.management.add_partner');
  }

  // function store record in db
  public function storePartner(PartnerRequest $request,
                               PartnerRepositories $partnerRepositories)
  {
    $input = $request->all();
    $result = $partnerRepositories->partnerStore($input);
    return redirect()->route('admin.partner')->with([
      'flash_level' => $result["status"],
      'flash_message' => $result["message"],
    ]);
  }

  // function get data edit
  public function editPartner(Request $request, $id,
                              PartnerRepositories $partnerRepositories)
  {
    $data['partner'] = $partnerRepositories->getEditPartner($id);
    return view('horserace::backend.management.edit_partner', compact('data'));
  }

  public function deletePartner(Request $request,
                                PartnerRepositories $partnerRepositories)
  {
    $input = $request->all();
    $result = $partnerRepositories->partnerDelete(trim($input["id_delete"]));
    return redirect()->route('admin.partner')->with([
      'flash_level' => $result["status"],
      'flash_message' => $result["message"],
    ]);
  }
}
