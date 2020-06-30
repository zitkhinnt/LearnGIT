<?php

namespace Modules\Horserace\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;

class CheckPartner
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
    if (Auth::check()) {
      switch (Auth::user()->role_code) {
        case ROLE_ADMIN:
          return redirect()->route("admin.dashboard")->with([
            'flash_level' => 'danger',
            'flash_message' => __('horserace::be_msg.permission_denied'),
          ]);
          break;

        case ROLE_PARTNER:
          return $next($request);
          break;
      }
    } else {
      return redirect()->route("admin.login");
    }
  }
}
