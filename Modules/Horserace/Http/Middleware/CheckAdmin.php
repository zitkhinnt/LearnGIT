<?php

namespace Modules\Horserace\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;
use Modules\Permission\Permission;
use Illuminate\Support\Facades\Route;
use Modules\Horserace\Entities\Menu;
use Modules\Horserace\Entities\router_menu;
use Session;
use Illuminate\Support\Facades\Log;
use Modules\Horserace\Repositories\AdminRepositories;

class CheckAdmin
{
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request $request
   * @param  \Closure $next
   * @return mixed
   */
  public function handle(Request $request, Closure $next)
  {
    $menuAdmin = new Menu;
    $dataIdMenuLevel1 = $menuAdmin->getListParentID(Auth::guard('admin')->user()->role_menu);
    $list=implode(',',array_column($dataIdMenuLevel1,'groupid'));
    $data_menu['menuLv1'] = $menuAdmin->getlistParentDetail($list);
    //get detail menu parent 
    $data_menu['menu_user'] = $menuAdmin->getMenuListId(Auth::guard('admin')->user()->role_menu);
    Session::put('data_menu', $data_menu);

    if (Auth::check()) {
      switch (Auth::user()->role_code) {
        case ROLE_ADMIN:
          return $next($request);
          break;
        // check staff

        case ROLE_STAFF:
        $adminRepo = new AdminRepositories;
        if ($adminRepo->checkRouterPermission(\Request::route()->getName(), Auth::user())) {
          return $next($request);
        } else {
          return redirect()->route("admin.login")->with([
            'flash_level' => 'danger',
            'flash_message' => __('horserace::be_msg.permission_denied'),
          ]);
        }
        break;
        
        case ROLE_PARTNER:
          return redirect()->route("partner.summary.access")->with([
            'flash_level' => 'danger',
            'flash_message' => __('horserace::be_msg.permission_denied'),
          ]);
          break;
      }
    } else {
      return redirect()->route("admin.login");
    }
  }
}
