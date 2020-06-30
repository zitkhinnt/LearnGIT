<?php

namespace Modules\Horserace\Entities;

use Illuminate\Database\Eloquent\Model as Model;
use Illuminate\Support\Facades\DB;

class Media
{
  protected $table = 'media';

  public function insertMedia($data)
  {
    $data['created_at'] = \Carbon\Carbon::now()->toDateTimeString();
    $data['updated_at'] = \Carbon\Carbon::now()->toDateTimeString();
    return DB::table($this->table)->insert($data);
  }

  public function getMedia()
  {
    return DB::table($this->table)
      ->where($this->table . '.deleted_flg', 0)
      ->orderBy('id', 'ASC')
      ->get()
      ->toArray();
  }

  public function getMediaById($id)
  {
    return DB::table($this->table)->find($id);
  }

  public function getMediaByCode($code)
  {
    return DB::table($this->table)
      ->where('code', $code)
      ->first();
  }

  public function getMediaByLikeCode($code)
  {
    return DB::table($this->table)
      ->where('code', 'LIKE', '%' . $code . '%')
      ->get()
      ->toArray();
  }

  public function updateMedia($id, $data)
  {
    $data['updated_at'] = \Carbon\Carbon::now()->toDateTimeString();
    DB::table($this->table)
      ->where('id', $id)
      ->update($data);
  }

  public function deleteMedia($id)
  {
    $data['deleted_flg'] = 1;
    DB::table($this->table)
      ->where('id', $id)
      ->update($data);
  }

  public function summaryMediaDeposit($year, $month)
  {
    return DB::table('users')
      ->select(DB::raw('count(DISTINCT td.user_id) as total_user_deposit,
      users.media_code,
      SUM(td.amount_pay) as total_amount,
      count(td.id) as total_deposit '))
      ->join('transaction_deposit as td', 'users.id', '=', 'td.user_id')
      ->where('td.status', APPLY)
      ->whereRaw('YEAR(td.created_at) =' . $year . ' AND MONTH(td.created_at)=' . $month)
      ->where('users.deleted_flg', DELETED_DISABLE)
      ->groupBy('users.media_code')
      ->get()
      ->toArray();
  }

  public function summaryMediaDepositDistanceMonth($year_start, $year_end, $month_start, $month_end)
  {
    return DB::table('users')
      ->select(DB::raw('count(DISTINCT td.user_id) as total_user_deposit,
      users.media_code,
      SUM(td.amount_pay) as total_amount,
      count(td.id) as total_deposit '))
      ->join('transaction_deposit as td', 'users.id', '=', 'td.user_id')
      ->where('td.status', APPLY)
      ->whereRaw('YEAR(td.updated_at) >=' . $year_start . ' AND MONTH(td.updated_at) >=' . $month_start)
      ->whereRaw('YEAR(td.updated_at) <=' . $year_end . ' AND MONTH(td.updated_at) <=' . $month_end)
      ->where('users.deleted_flg', DELETED_DISABLE)
      ->groupBy('users.media_code')
      ->get()
      ->toArray();
  }

  public function summaryDepositDistanceMonth($year_register, $year_deposit, $month_register, $month_deposit)
  {
    return DB::table('users')
      ->select(DB::raw('count(DISTINCT td.user_id) as total_user_deposit,
      users.media_code,
      SUM(td.amount_pay) as total_amount,
      count(td.id) as total_deposit '))
      ->join('transaction_deposit as td', 'users.id', '=', 'td.user_id')
      ->where('td.status', APPLY)
      ->where('td.deleted_flg', DELETED_DISABLE)
      ->whereRaw('YEAR(td.updated_at) =' . $year_deposit . ' AND MONTH(td.updated_at) =' . $month_deposit)
      ->whereRaw('YEAR(users.register_time) =' . $year_register . ' AND MONTH(users.register_time) =' . $month_register)
      ->where('users.deleted_flg', DELETED_DISABLE)
      ->groupBy('users.media_code')
      ->get()
      ->toArray();
  }

  public function summaryDepositDistanceOver3Month($year_register, $year_deposit, $month_register, $month_deposit)
  {
    return DB::table('users')
      ->select(DB::raw('count(DISTINCT td.user_id) as total_user_deposit,
      users.media_code,
      SUM(td.amount_pay) as total_amount,
      count(td.id) as total_deposit '))
      ->join('transaction_deposit as td', 'users.id', '=', 'td.user_id')
      ->where('td.status', APPLY)
      ->where('td.deleted_flg', DELETED_DISABLE)
      ->whereRaw('YEAR(td.updated_at) =' . $year_deposit . ' AND MONTH(td.updated_at) =' . $month_deposit)
      ->whereRaw('YEAR(users.register_time) <=' . $year_register . ' AND MONTH(users.register_time) <=' . $month_register)
      ->where('users.deleted_flg', DELETED_DISABLE)
      ->groupBy('users.media_code')
      ->get()
      ->toArray();
  }

  public function summaryDepositPeriodTime($time_reg_start, $time_deposit_start, $time_reg_end, $time_deposit_end)
  {
    return DB::table('users')
      ->select(DB::raw('count(DISTINCT td.user_id) as total_user_deposit,
      users.media_code,
      SUM(td.amount_pay) as total_amount,
      count(td.id) as total_deposit '))
      ->join('transaction_deposit as td', 'users.id', '=', 'td.user_id')
      ->where('td.deleted_flg', DELETED_DISABLE)
      ->where('td.status', APPLY)
      ->where('td.updated_at', '>=', $time_deposit_start)
      ->where('td.updated_at', '<=', $time_deposit_end)
      ->where('users.register_time', '>=', $time_reg_start)
      ->where('users.register_time', '<=', $time_reg_end)
      ->where('users.deleted_flg', DELETED_DISABLE)
      ->groupBy('users.media_code')
      ->get()
      ->toArray();
  }

  public function summaryDepositPeriodOver3Month($time_reg_start, $time_deposit_start, $time_reg_end, $time_deposit_end)
  {
    return DB::table('users')
      ->select(DB::raw('count(DISTINCT td.user_id) as total_user_deposit,
      users.media_code,
      SUM(td.amount_pay) as total_amount,
      count(td.id) as total_deposit '))
      ->join('transaction_deposit as td', 'users.id', '=', 'td.user_id')
      ->where('td.deleted_flg', DELETED_DISABLE)
      ->where('td.status', APPLY)
      ->where('td.updated_at', '>=', $time_deposit_start)
      ->where('td.updated_at', '<=', $time_deposit_end)
      ->where('users.register_time', '<=', $time_reg_end)
      ->where('users.deleted_flg', DELETED_DISABLE)
      ->groupBy('users.media_code')
      ->get()
      ->toArray();
  }

  public function summaryMediaDepositTotal($year, $month)
  {
    return DB::table('users')
      ->select(DB::raw('count(DISTINCT td.user_id) as total_user_deposit,
      users.media_code,
      SUM(td.amount_pay) as total_amount,
      count(td.id) as total_deposit '))
      ->join('transaction_deposit as td', 'users.id', '=', 'td.user_id')
      ->where('td.status', APPLY)
      ->where('td.deleted_flg', DELETED_DISABLE)
      ->whereRaw('YEAR(td.updated_at) =' . $year . ' AND MONTH(td.updated_at)=' . $month)
      ->where('users.deleted_flg', DELETED_DISABLE)
      ->groupBy('users.media_code')
      ->get()
      ->toArray();
  }

  public function summaryMediaDepositTotalPeriod($time_start, $time_end)
  {
    return DB::table('users')
      ->select(DB::raw('count(DISTINCT td.user_id) as total_user_deposit,
      users.media_code,
      SUM(td.amount_pay) as total_amount,
      count(td.id) as total_deposit '))
      ->join('transaction_deposit as td', 'users.id', '=', 'td.user_id')
      ->where('td.deleted_flg', DELETED_DISABLE)
      ->where('td.status', APPLY)
      ->where('td.updated_at', '>=', $time_start)
      ->where('td.updated_at', '<=', $time_end)
      ->where('users.deleted_flg', DELETED_DISABLE)
      ->groupBy('users.media_code')
      ->get()
      ->toArray();
  }

  public function summaryMediaCodeDailyDistanceMonth($year_register, $year_deposit, $month_register, $month_deposit, $media_code)
  {
    $result = DB::table('users')
      ->select(DB::raw('DATE(td.updated_at) as date'),
        DB::raw('count(DISTINCT td.user_id) as total_user_deposit,
      SUM(td.amount_pay) as total_amount,
      count(td.id) as total_deposit '))
      ->join('transaction_deposit as td', 'users.id', '=', 'td.user_id')
      ->where('users.media_code', $media_code)
      ->where('td.deleted_flg', DELETED_DISABLE)
      ->where('td.status', APPLY)
      ->whereRaw('YEAR(td.updated_at) =' . $year_deposit . ' AND MONTH(td.updated_at) =' . $month_deposit)
      ->whereRaw('YEAR(users.register_time) =' . $year_register . ' AND MONTH(users.register_time) =' . $month_register)
      ->where('users.deleted_flg', DELETED_DISABLE)
      ->groupBy('date')
      ->get()
      ->toArray();

    return $result;
  }

  public function summaryMediaCodeDailyDistanceOver3Month($year_register, $year_deposit, $month_register, $month_deposit, $media_code)
  {
    $result = DB::table('users')
      ->select(DB::raw('DATE(td.updated_at) as date'),
        DB::raw('count(DISTINCT td.user_id) as total_user_deposit,
      SUM(td.amount_pay) as total_amount,
      count(td.id) as total_deposit '))
      ->join('transaction_deposit as td', 'users.id', '=', 'td.user_id')
      ->where('td.deleted_flg', DELETED_DISABLE)
      ->where('users.media_code', $media_code)
      ->where('td.status', APPLY)
      ->whereRaw('YEAR(td.updated_at) =' . $year_deposit . ' AND MONTH(td.updated_at) =' . $month_deposit)
      ->whereRaw('YEAR(users.register_time) <=' . $year_register . ' AND MONTH(users.register_time) <=' . $month_register)
      ->where('users.deleted_flg', DELETED_DISABLE)
      ->groupBy('date')
      ->get()
      ->toArray();

    return $result;
  }

  public function summaryMediaCodeDailyTotal($year, $month, $media_code)
  {
    $result = DB::table('users')
      ->select(DB::raw('DATE(td.updated_at) as date'),
        DB::raw('count(DISTINCT td.user_id) as total_user_deposit,
      SUM(td.amount_pay) as total_amount,
      count(td.id) as total_deposit '))
      ->join('transaction_deposit as td', 'users.id', '=', 'td.user_id')
      ->where('td.deleted_flg', DELETED_DISABLE)
      ->where('users.media_code', $media_code)
      ->where('td.status', APPLY)
      ->whereRaw('YEAR(td.updated_at) =' . $year . ' AND MONTH(td.updated_at)=' . $month)
      ->where('users.deleted_flg', DELETED_DISABLE)
      ->groupBy('date')
      ->get()
      ->toArray();

    return $result;
  }

  /** Partner start */
  public function partnerGetMedia($code)
  {
    return DB::table($this->table)
      ->where($this->table . '.code', 'like', "%{$code}%")
      ->where($this->table . '.deleted_flg', 0)
      ->orderBy('id', 'ASC')
      ->get()
      ->toArray();
  }

  public function partnerSummaryMediaDeposit($year, $month, $media_code)
  {
    return DB::table('users')
      ->select(DB::raw('count(DISTINCT td.user_id) as total_user_deposit,
      users.media_code,
      SUM(td.amount_pay) as total_amount,
      count(td.id) as total_deposit '))
      ->join('transaction_deposit as td', 'users.id', '=', 'td.user_id')
      ->where('td.deleted_flg', DELETED_DISABLE)
      ->where('users.media_code', 'like', "%{$media_code}%")
      ->where('td.status', APPLY)
      ->whereRaw('YEAR(td.created_at) =' . $year . ' AND MONTH(td.created_at)=' . $month)
      ->where('users.deleted_flg', DELETED_DISABLE)
      ->groupBy('users.media_code')
      ->get()
      ->toArray();
  }
  /** Partner end */
}
