<?php

namespace Modules\Horserace\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserDailyAccessHistory
{
  protected $table = 'user_daily_access_history';

  public function user()
  {
    return $this->belongTo('Modules\Horserace\Entities\User');
  }

  public function insertUserDailyAccessHistory($data)
  {
    $data['created_at'] = \Carbon\Carbon::now()->toDateTimeString();
    $data['updated_at'] = \Carbon\Carbon::now()->toDateTimeString();
    DB::table($this->table)->insert($data);
  }

  public function updateUserDailyAccessHistory($id, $data)
  {
    $data['updated_at'] = \Carbon\Carbon::now()->toDateTimeString();
    DB::table($this->table)
      ->where('id', $id)
      ->update($data);
  }

  public function getUserDailyAccessHistoryByLoginIdAndAccessDate($login_id, $access_date)
  {
    return DB::table($this->table)->select('*')
      ->where('login_id', $login_id)
      ->where('access_date', $access_date)
      ->first();
  }

  public function countUserAccessToday($access_date)
  {
    return DB::table($this->table)->select('*')
      ->where('access_date', $access_date)
      ->count();
  }

  public function getSummaryUserAccessDaily($year, $month)
  {
    $result = DB::table($this->table)
      ->select(DB::raw('DATE(access_date) as date'),
        DB::raw('SUM(number_access) as number_access'))
      ->where($this->table . '.deleted_flg', DELETED_DISABLE)
      ->whereRaw('YEAR(updated_at) =' . $year . ' AND MONTH(updated_at)=' . $month)
      ->groupBy('date')
      ->get()
      ->toArray();

    return $result;
  }

  public function getSummaryUserAccessWeekly($week_start, $week_end)
  {
    $result = DB::table($this->table)
      ->where($this->table . '.deleted_flg', DELETED_DISABLE)
      ->whereRaw('WEEKOFYEAR(access_date)>=' . $week_start)
      ->whereRaw('WEEKOFYEAR(access_date)<=' . $week_end)
      ->select(DB::raw('WEEKOFYEAR(access_date) as week_of_year'),
        DB::raw('SUM(number_access) as number_access'))
      ->groupBy('week_of_year')
      ->get()
      ->toArray();

    return $result;
  }

  public function numberUserAccessMonthByMedia($year, $month, $media_code)
  {
    $result = DB::table("users")
      ->join('user_daily_access_history as udah', 'users.id', '=', 'udah.user_id')
      ->select(DB::raw('SUM(udah.number_access) as number_access'))
      ->where('users.media_code', $media_code)
      ->whereRaw('YEAR(udah.access_date) =' . $year . ' AND MONTH(udah.access_date)=' . $month)
      ->get()
      ->toArray();

    return (integer)$result[0]->number_access;
  }

  public function numberUserAccessPeriodTimeByMedia($time_start, $time_end, $media_code)
  {
    $result = DB::table("users")
      ->join('user_daily_access_history as udah', 'users.id', '=', 'udah.user_id')
      ->select(DB::raw('SUM(udah.number_access) as number_access'))
      ->where('users.media_code', $media_code)
      ->where('udah.access_date', '>=', $time_start)
      ->where('udah.access_date', '<=', $time_end)
      ->get()
      ->toArray();

    return (integer)$result[0]->number_access;
  }

  public function numberUserAccessDailyByMedia($year, $month, $media_code)
  {
    $result = DB::table("users")
      ->join('user_daily_access_history as udah', 'udah.user_id', '=', 'users.id')
      ->select(DB::raw('count(DISTINCT udah.user_id) as unique_number,
      DATE(udah.access_date) as date,
      SUM(udah.number_access) as number_access'))
      ->where('users.media_code', $media_code)
      ->where('users.deleted_flg', DELETED_DISABLE)
      ->whereRaw('YEAR(udah.access_date) =' . $year . ' AND MONTH(udah.access_date)=' . $month)
      ->groupBy('date')
      ->get()
      ->toArray();

    return $result;
  }

  public function numberUserAccessMonthByEntrance($year, $month, $entrance_id)
  {
    $result = DB::table("users")
      ->join('user_daily_access_history as udah', 'users.id', '=', 'udah.user_id')
      ->select(DB::raw('SUM(udah.number_access) as number_access'))
      ->where('users.entrance_id', $entrance_id)
      ->whereRaw('YEAR(udah.access_date) =' . $year . ' AND MONTH(udah.access_date)=' . $month)
      ->get()
      ->toArray();

    return (integer)$result[0]->number_access;
  }

  public function numberUserAccessDailyByEntrance($year, $month, $entrance_id)
  {
    $result = DB::table("users")
      ->join('user_daily_access_history as udah', 'udah.user_id', '=', 'users.id')
      ->select(DB::raw('count(DISTINCT udah.user_id) as unique_number,
      DATE(udah.access_date) as date,
      SUM(udah.number_access) as number_access'))
      ->where('users.entrance_id', $entrance_id)
      ->where('users.deleted_flg', DELETED_DISABLE)
      ->whereRaw('YEAR(udah.access_date) =' . $year . ' AND MONTH(udah.access_date)=' . $month)
      ->groupBy('date')
      ->get()
      ->toArray();

    return $result;
  }

  public function partnerGetSummaryUserAccess($year, $month, $media_code)
  {
    $result = DB::table("users")
      ->join('user_daily_access_history as udah', 'users.id', '=', 'udah.user_id')
      ->select(DB::raw('count(DISTINCT udah.user_id) as unique_number,
      users.media_code as media_code'),
        DB::raw('SUM(udah.number_access) as number_access'))
      ->where('users.media_code', 'like', "%{$media_code}%")
      ->where('users.deleted_flg', DELETED_DISABLE)
      ->whereRaw('YEAR(udah.access_date) =' . $year . ' AND MONTH(udah.access_date)=' . $month)
      ->groupBy('media_code')
      ->get()
      ->toArray();

    return $result;
  }

  public function partnerGetSummaryUserAccessPeriod($time_start, $time_end, $media_code)
  {
    $result = DB::table("users")
      ->join('user_daily_access_history as udah', 'users.id', '=', 'udah.user_id')
      ->select(DB::raw('count(DISTINCT udah.user_id) as unique_number,
      users.media_code as media_code'),
        DB::raw('SUM(udah.number_access) as number_access'))
      ->where('users.media_code', 'like', "%{$media_code}%")
      ->where('users.deleted_flg', DELETED_DISABLE)
      ->where('udah.access_date', '>=', $time_start)
      ->where('udah.access_date', '<=', $time_end)
      ->groupBy('media_code')
      ->get()
      ->toArray();

    return $result;
  }

  public function partnerGetSummaryUserAccessDaily($year, $month, $media_code)
  {
    $result = DB::table("users")
      ->join('user_daily_access_history as udah', 'udah.user_id', '=', 'users.id')
      ->select(DB::raw('count(DISTINCT udah.user_id) as unique_number,
      DATE(udah.access_date) as date,
      SUM(udah.number_access) as number_access'))
      ->where('users.media_code', $media_code)
      ->where('users.deleted_flg', DELETED_DISABLE)
      ->whereRaw('YEAR(udah.access_date) =' . $year . ' AND MONTH(udah.access_date)=' . $month)
      ->groupBy('date')
      ->get()
      ->toArray();

    return $result;
  }

  public function partnerGetTotalUserAccessDaily($year, $month, $media_code)
  {
    $result = DB::table("users")
      ->join('user_daily_access_history as udah', 'users.id', '=', 'udah.user_id')
      ->select(DB::raw('count(DISTINCT udah.user_id) as unique_number,
      users.media_code as media_code'),
        DB::raw('SUM(udah.number_access) as number_access'))
      ->where('users.media_code', $media_code)
      ->where('users.deleted_flg', DELETED_DISABLE)
      ->whereRaw('YEAR(udah.access_date) =' . $year . ' AND MONTH(udah.access_date)=' . $month)
      ->groupBy('media_code')
      ->get()
      ->toArray();

    return $result;
  }
}