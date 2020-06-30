<?php

namespace Modules\Horserace\Http\Middleware;

use Closure;
use Auth;
use Modules\Horserace\Entities\User;
use Modules\Horserace\Entities\UserActivity;
use Modules\Horserace\Entities\UserDailyLoginHistory;

class LoginByKey
{
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   * @return mixed
   */
  public function handle($request, Closure $next)
  {
    if ($request->route()->getName() == 'login.user_key' && Auth::user()) {
      $obj_user = new User();
      $user = $obj_user->getUserByUserKey(Auth::user()->user_key);

      Auth::guard('web')->attempt(['login_id' => $user->login_id, 'password' => $user->password_text, 'deleted_flg' => 0], $request->remember);
      if (Auth::user()->member_level == MEMBER_LEVEL_EXCEPT) {
        Auth::guard('web')->logout();
        return redirect()->route('login', '#a02')->with([
          'flash_level' => "danger",
          'flash_message' => __('horserace::be_msg.account_fail_member_level_except'),
        ]);
      }
      // add daily login count
      $date = \Carbon\Carbon::now()->toDateTimeString();
      $now = date("Y-m-d H:i:s", strtotime($date));
      $userDailyLoginHistoryModel = new UserDailyLoginHistory();
      $userActivityModel = new UserActivity();
      $login_daily = $userDailyLoginHistoryModel->getByLoginIdAndAccessDate($user->login_id, $now);
      $user_activity = $userActivityModel->getUserActivityByUserId($user->id);

      // if ($login_daily) {
      //     $login_number = (int) $login_daily->login_number + 1;
      //     $userDailyLoginHistoryModel->updateUserDailyLoginHistory($login_daily->id, ['login_number' => $login_number]);
      // } else {

      $ip = $_SERVER['REMOTE_ADDR'];
      if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
      } else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
      }

      $user_agent = $_SERVER['HTTP_USER_AGENT'];

      $userDailyLoginHistoryModel->insertUserDailyLoginHistory([
        'user_id' => $user->id,
        'login_id' => $user->login_id,
        'user_agent' => $user_agent,
        'ip' => $ip,
        'login_date' => $now,
        'login_number' => 1
      ]);
      // }

      khanh_log('user activiti ::::::' . print_r($user_activity, true));

      // add user activity login number
      if ($user_activity && $user_activity->login_number) {
        $total_login_number = $user_activity->login_number + 1;
        $userActivityModel->updateUserActivity($user->id, [
          'login_number' => $total_login_number
        ]);
      }
    }
    if ($user_key = $request->get('keylogin')) {
      $obj_user = new User();
      $user = $obj_user->getUserByUserKey($user_key);

      Auth::guard('web')->attempt(['login_id' => $user->login_id, 'password' => $user->password_text, 'deleted_flg' => 0], $request->remember);
      if (Auth::user()->member_level == MEMBER_LEVEL_EXCEPT) {
        Auth::guard('web')->logout();
        return redirect()->route('login', '#a02')->with([
          'flash_level' => "danger",
          'flash_message' => __('horserace::be_msg.account_fail_member_level_except'),
        ]);
      }
      if ($request->route()->getName() != 'login.user_key') {
        // add daily login count
        $date = \Carbon\Carbon::now()->toDateTimeString();
        $now = date("Y-m-d H:i:s", strtotime($date));
        $userDailyLoginHistoryModel = new UserDailyLoginHistory();
        $userActivityModel = new UserActivity();
        $login_daily = $userDailyLoginHistoryModel->getByLoginIdAndAccessDate($user->login_id, $now);
        $user_activity = $userActivityModel->getUserActivityByUserId($user->id);

        if ($login_daily) {
          $login_number = (int) $login_daily->login_number + 1;
          $userDailyLoginHistoryModel->updateUserDailyLoginHistory($login_daily->id, ['login_number' => $login_number]);
        } else {

          $ip = $_SERVER['REMOTE_ADDR'];
          if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
          } else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
          }

          $user_agent = $_SERVER['HTTP_USER_AGENT'];

          $userDailyLoginHistoryModel->insertUserDailyLoginHistory([
            'user_id' => $user->id,
            'login_id' => $user->login_id,
            'user_agent' => $user_agent,
            'ip' => $ip,
            'login_date' => $now,
            'login_number' => 1
          ]);
        }

        khanh_log('user activiti ::::::' . print_r($user_activity, true));

        // add user activity login number
        if ($user_activity && $user_activity->login_number) {
          $total_login_number = $user_activity->login_number + 1;
          $userActivityModel->updateUserActivity($user->id, [
            'login_number' => $total_login_number
          ]);
        }
      }
    }
    return $next($request);
  }
}
