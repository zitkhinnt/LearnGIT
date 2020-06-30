<?php

namespace Modules\Horserace\Entities;

use Illuminate\Database\Eloquent\Model as Model;
use Illuminate\Support\Facades\DB;

class Entrance
{
  protected $table = 'entrance';

  public function insertEntrance($data)
  {
    $data['created_at'] = \Carbon\Carbon::now()->toDateTimeString();
    $data['updated_at'] = \Carbon\Carbon::now()->toDateTimeString();
    return DB::table($this->table)->insert($data);
  }

  public function getEntrance()
  {
    return DB::table($this->table)
      ->where($this->table . '.deleted_flg', DELETED_DISABLE)
      ->orderBy('id', 'DESC')
      ->get()
      ->toArray();
  }

  public function getEntranceById($id)
  {
    return DB::table($this->table)->find($id);
  }

  public function updateEntrance($id, $data)
  {
    $data['updated_at'] = \Carbon\Carbon::now()->toDateTimeString();
    DB::table($this->table)
      ->where('id', $id)
      ->update($data);
  }

  public function deleteEntrance($id)
  {
    $data['deleted_flg'] = 1;
    DB::table($this->table)
      ->where('id', $id)
      ->update($data);
  }

  public function getEntranceDefault()
  {
    return DB::table($this->table)
      ->where($this->table . '.default_flg', ENTRANCE_DEFAULT_ENABLE)
      ->where($this->table . '.deleted_flg', DELETED_DISABLE)
      ->first();
  }

  public function summaryDepositDistanceMonth($year_register, $year_deposit, $month_register, $month_deposit)
  {
    return DB::table('users')
      ->select(DB::raw('count(DISTINCT td.user_id) as total_user_deposit,
      users.entrance_id,
      SUM(td.amount) as total_amount,
      count(td.id) as total_deposit '))
      ->join('transaction_deposit as td', 'users.id', '=', 'td.user_id')
      ->where('td.deleted_flg', DELETED_DISABLE)
      ->where('td.status', APPLY)
      ->whereRaw('YEAR(td.updated_at) =' . $year_deposit . ' AND MONTH(td.updated_at) =' . $month_deposit)
      ->whereRaw('YEAR(users.register_time) =' . $year_register . ' AND MONTH(users.register_time) =' . $month_register)
      ->where('users.deleted_flg', DELETED_DISABLE)
      ->groupBy('users.entrance_id')
      ->get()
      ->toArray();
  }

  public function summaryDepositDistanceOver3Month($year_register, $year_deposit, $month_register, $month_deposit)
  {
    return DB::table('users')
      ->select(DB::raw('count(DISTINCT td.user_id) as total_user_deposit,
      users.entrance_id,
      SUM(td.amount) as total_amount,
      count(td.id) as total_deposit '))
      ->join('transaction_deposit as td', 'users.id', '=', 'td.user_id')
      ->where('td.deleted_flg', DELETED_DISABLE)
      ->where('td.status', APPLY)
      ->whereRaw('YEAR(td.updated_at) =' . $year_deposit . ' AND MONTH(td.updated_at) =' . $month_deposit)
      ->whereRaw('YEAR(users.register_time) <=' . $year_register . ' AND MONTH(users.register_time) <=' . $month_register)
      ->where('users.deleted_flg', DELETED_DISABLE)
      ->groupBy('users.entrance_id')
      ->get()
      ->toArray();
  }

  public function summaryEntranceDepositTotal($year, $month)
  {
    return DB::table('users')
      ->select(DB::raw('count(DISTINCT td.user_id) as total_user_deposit,
      users.entrance_id,
      SUM(td.amount) as total_amount,
      count(td.id) as total_deposit '))
      ->join('transaction_deposit as td', 'users.id', '=', 'td.user_id')
      ->where('td.deleted_flg', DELETED_DISABLE)
      ->where('td.status', APPLY)
      ->whereRaw('YEAR(td.updated_at) =' . $year . ' AND MONTH(td.updated_at)=' . $month)
      ->where('users.deleted_flg', DELETED_DISABLE)
      ->groupBy('users.entrance_id')
      ->get()
      ->toArray();
  }

  public function summaryEntranceDetailDailyDistanceMonth($year_register, $year_deposit, $month_register, $month_deposit, $entrance_id)
  {
    $result = DB::table('users')
      ->select(DB::raw('DATE(td.updated_at) as date'),
        DB::raw('count(DISTINCT td.user_id) as total_user_deposit,
      SUM(td.amount) as total_amount,
      count(td.id) as total_deposit '))
      ->join('transaction_deposit as td', 'users.id', '=', 'td.user_id')
      ->where('td.deleted_flg', DELETED_DISABLE)
      ->where('users.entrance_id', $entrance_id)
      ->where('td.status', APPLY)
      ->whereRaw('YEAR(td.updated_at) =' . $year_deposit . ' AND MONTH(td.updated_at) =' . $month_deposit)
      ->whereRaw('YEAR(users.register_time) =' . $year_register . ' AND MONTH(users.register_time) =' . $month_register)
      ->where('users.deleted_flg', DELETED_DISABLE)
      ->groupBy('date')
      ->get()
      ->toArray();

    return $result;
  }

  public function summaryEntranceDetailDailyDistanceOver3Month($year_register, $year_deposit, $month_register, $month_deposit, $entrance_id)
  {
    $result = DB::table('users')
      ->select(DB::raw('DATE(td.updated_at) as date'),
        DB::raw('count(DISTINCT td.user_id) as total_user_deposit,
      SUM(td.amount) as total_amount,
      count(td.id) as total_deposit '))
      ->join('transaction_deposit as td', 'users.id', '=', 'td.user_id')
      ->where('td.deleted_flg', DELETED_DISABLE)
      ->where('users.entrance_id', $entrance_id)
      ->where('td.status', APPLY)
      ->whereRaw('YEAR(td.updated_at) =' . $year_deposit . ' AND MONTH(td.updated_at) =' . $month_deposit)
      ->whereRaw('YEAR(users.register_time) <=' . $year_register . ' AND MONTH(users.register_time) <=' . $month_register)
      ->where('users.deleted_flg', DELETED_DISABLE)
      ->groupBy('date')
      ->get()
      ->toArray();

    return $result;
  }

  public function summaryEntranceDetailDailyTotal($year, $month, $entrance_id)
  {
    $result = DB::table('users')
      ->select(DB::raw('DATE(td.updated_at) as date'),
        DB::raw('count(DISTINCT td.user_id) as total_user_deposit,
      SUM(td.amount) as total_amount,
      count(td.id) as total_deposit '))
      ->join('transaction_deposit as td', 'users.id', '=', 'td.user_id')
      ->where('td.deleted_flg', DELETED_DISABLE)
      ->where('users.entrance_id', $entrance_id)
      ->where('td.status', APPLY)
      ->whereRaw('YEAR(td.updated_at) =' . $year . ' AND MONTH(td.updated_at)=' . $month)
      ->where('users.deleted_flg', DELETED_DISABLE)
      ->groupBy('date')
      ->get()
      ->toArray();

    return $result;
  }
}
