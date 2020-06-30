<?php

namespace Modules\Horserace\Repositories;

use DB;
use Modules\Horserace\Entities\UserDailyLoginHistory;
use Modules\Horserace\Entities\User;
use Modules\Horserace\Entities\UserDailyAccessHistory;

class UserDailyLoginHistoryRepositories
{

  public function addDailyLoginUser($input)
  {
    $obj_user_daily_login = new UserDailyLoginHistory();
    $date = \Carbon\Carbon::now()->toDateTimeString();
    $now = date("Y-m-d H:i:s", strtotime($date));

    $arr_user_daily_login = [
      "ip" => $input["ip"],
      "user_id" => $input["user_id"],
      "login_id" => $input["login_id"],
      "user_agent" => $input["user_agent"],
      "login_date" => $now
    ];
    // Check have login in date
    if ($obj_user_daily_login->haveLoginDate(trim($input["login_id"]), $now))
    {
      // Edit
      $obj_user_daily_access_history = new UserDailyAccessHistory();
      $user_daily_access_history_id = $obj_user_daily_access_history->getUserDailyAccessHistoryByLoginIdAndAccessDate(trim($input["login_id"]), $now);
      if($user_daily_access_history_id!=null)
      {
        $last_time = \Carbon\Carbon::parse($user_daily_access_history_id->updated_at)->timestamp;
        if (time() - $last_time > config('session.lifetime') * 60)
        {
          $user_daily_login = $obj_user_daily_login->getByLoginIdAndAccessDate(trim($input["login_id"]), $now);
          $arr_user_daily_login["login_number"] = (integer)$user_daily_login->login_number + 1;
          $obj_user_daily_login->updateUserDailyLoginHistory($user_daily_login->id, $arr_user_daily_login);
        }
      }
    }
    else
    {
      // Add
      $arr_user_daily_login["login_number"] = 1;
      $obj_user_daily_login->insertUserDailyLoginHistory($arr_user_daily_login);
    }
  }

  public function summaryUserLoginDaily($year, $month)
  {
    $obj_user_daily_login = new UserDailyLoginHistory();
    $data = $obj_user_daily_login->getSummaryUserLoginDaily($year, $month);
    return $data;
  }

  public function summaryUserLoginWeekly($start_week, $end_week)
  {
    $obj_user_daily_login = new UserDailyLoginHistory();
    $data = $obj_user_daily_login->getSummaryUserLoginWeekly($start_week, $end_week);
    return $data;
  }

  public function getUserLoginHistory($input)
  {
    $obj_user_daily_login = new UserDailyLoginHistory();
    $data = $obj_user_daily_login->searchUserDailyLoginHistory($input);
    return $data;
  }

  public function getUserLoginHistoryAjax($input)
  {
    $obj_user_daily_login = new UserDailyLoginHistory();
    $data = $obj_user_daily_login->searchUserDailyLoginHistoryAjax($input);
    return $data;
  }
}