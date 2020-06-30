<?php

namespace Modules\Horserace\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserDailyLoginHistory
{
  protected $table = 'user_daily_login_history';

  public function insertUserDailyLoginHistory($data)
  {
    $data['created_at'] = \Carbon\Carbon::now()->toDateTimeString();
    $data['updated_at'] = \Carbon\Carbon::now()->toDateTimeString();
    DB::table($this->table)->insert($data);
  }

  public function updateUserDailyLoginHistory($id, $data)
  {
    $data['updated_at'] = \Carbon\Carbon::now()->toDateTimeString();
    DB::table($this->table)
      ->where('id', $id)
      ->update($data);
  }

  public function getByLoginIdAndAccessDate($login_id, $access_date)
  {

    return DB::table($this->table)->select('*')
      ->where('login_id', $login_id)
      ->where('login_date', $access_date)
      ->first();
  }

  public function haveLoginDate($login_id, $login_date)
  {
    $result = DB::table($this->table)->select('*')
      ->where('login_id', $login_id)
      ->where('login_date', $login_date)
      ->first();

    return is_null($result) ? false : true;
  }

  public function countUserLoginToday($login_date)
  {
    return DB::table($this->table)->select('*')
      ->where('login_date', $login_date)
      ->count();
  }

  public function getSummaryUserLoginDaily($year, $month)
  {
    $result = DB::table($this->table)
      ->select(DB::raw('DATE(login_date) as date'),
        DB::raw('COUNT(DISTINCT user_id) as number_user_login'))
      ->where($this->table . '.deleted_flg', DELETED_DISABLE)
      ->whereRaw('YEAR(login_date) =' . $year . ' AND MONTH(login_date)=' . $month)
      ->groupBy('date')
      ->get()
      ->toArray();

    return $result;
  }

  public function getSummaryUserLoginWeekly($week_start, $week_end)
  {
    $result = DB::table($this->table)
      ->where($this->table . '.deleted_flg', DELETED_DISABLE)
      ->whereRaw('WEEKOFYEAR(login_date)>=' . $week_start)
      ->whereRaw('WEEKOFYEAR(login_date)<=' . $week_end)
      ->select(DB::raw('WEEKOFYEAR(login_date) as week_of_year'),
        DB::raw('COUNT(DISTINCT user_id) as number_user_login'))
      ->groupBy('week_of_year')
      ->get()
      ->toArray();

    return $result;
  }

  public function summaryMediaNumberLoginTotal($year, $month)
  {
    return DB::table('users')
      ->select(DB::raw('count(DISTINCT udlh.user_id) as number_user,
      users.media_code,
      SUM(udlh.login_number) as total_number_login'))
      ->join('user_daily_login_history as udlh', 'users.id', '=', 'udlh.user_id')
      ->whereRaw('YEAR(udlh.login_date) =' . $year . ' AND MONTH(udlh.login_date)=' . $month)
      ->where('users.deleted_flg', DELETED_DISABLE)
      ->groupBy('users.media_code')
      ->get()
      ->toArray();
  }

  public function summaryMediaNumberLoginTotalPeriod($time_start, $time_end)
  {
    return DB::table('users')
      ->select(DB::raw('count(DISTINCT udlh.user_id) as number_user,
      users.media_code,
      SUM(udlh.login_number) as total_number_login'))
      ->join('user_daily_login_history as udlh', 'users.id', '=', 'udlh.user_id')
      ->where('udlh.login_date', '>=', $time_start)
      ->where('udlh.login_date', '<=', $time_end)
      ->where('users.deleted_flg', DELETED_DISABLE)
      ->groupBy('users.media_code')
      ->get()
      ->toArray();
  }

  public function summaryMediaCodeNumberLoginDailyTotal($year, $month, $media_code)
  {
    $result = DB::table('users')
      ->select(DB::raw('DATE(udlh.login_date) as date'),
        DB::raw('count(DISTINCT udlh.user_id) as number_user,
      SUM(udlh.login_number) as total_number_login'))
      ->join('user_daily_login_history as udlh', 'users.id', '=', 'udlh.user_id')
      ->where('users.media_code', $media_code)
      ->whereRaw('YEAR(udlh.login_date) =' . $year . ' AND MONTH(udlh.login_date)=' . $month)
      ->where('users.deleted_flg', DELETED_DISABLE)
      ->groupBy('date')
      ->get()
      ->toArray();

    return $result;
  }

  public function searchUserDailyLoginHistory($input)
  {
    $result = DB::table($this->table)
      ->where('deleted_flg', DELETED_DISABLE);

    // login_id
    if (isset($input['login_id']) && !is_null($input['login_id']) && (strlen($input['login_id']) > 0)) {
      $result->where('login_id', $input['login_id']);
    }

    // last_payment_time_start
    if (isset($input['login_time_start']) && !is_null($input['login_time_start']) && (strlen($input['login_time_start']) > 0)) {
      $login_time_start = $input["login_time_start"] . " 00:00:00";
      $result->where('login_date', '>=', $login_time_start);
    }
    // last_payment_time_end
    if (isset($input['login_time_end']) && !is_null($input['login_time_end']) && (strlen($input['login_time_end']) > 0)) {
      $login_time_end = $input["login_time_end"] . " 23:59:59";
      $result->where('login_date', '<=', $login_time_end);
    }

    $result = $result
      ->orderBy("id", "desc")
      ->get()
      ->toArray();
    return $result;
  }

  public function searchUserDailyLoginHistoryAjax($input)
  {
    $result = DB::table($this->table)
      ->where('deleted_flg', DELETED_DISABLE)->orderBy("id", "desc");

    // login_id
    if (isset($input['login_id']) && !is_null($input['login_id']) && (strlen($input['login_id']) > 0)) {
      $result->where('login_id', $input['login_id']);
    }

    // last_payment_time_start
    if (isset($input['login_time_start']) && !is_null($input['login_time_start']) && (strlen($input['login_time_start']) > 0)) {
      $login_time_start = $input["login_time_start"] . " 00:00:00";
      $result->where('login_date', '>=', $login_time_start);
    }
    // last_payment_time_end
    if (isset($input['login_time_end']) && !is_null($input['login_time_end']) && (strlen($input['login_time_end']) > 0)) {
      $login_time_end = $input["login_time_end"] . " 23:59:59";
      $result->where('login_date', '<=', $login_time_end);
    }

    $total_record = $result->count();
    $current_page = ($input['iDisplayStart'] / $input['iDisplayLength']) + 1;
    $limit = $input['iDisplayLength'];
    $total_page = ceil($total_record / $limit);
    if ($current_page > $total_page) {
      $current_page = $total_page;
    } else if ($current_page < 1) {
      $current_page = 1;
    }
    $skip = ($current_page - 1) * $limit;
    $data['total'] = $total_record;
    $data['result'] = $result->skip($skip)->take($limit)->get()->toArray();
    return $data;
  }
}