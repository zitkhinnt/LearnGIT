<?php

namespace Modules\Horserace\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MediaAccess
{
  protected $table = 'media_access';

  public function insertMediaAccess($data)
  {
    $data['created_at'] = \Carbon\Carbon::now()->toDateTimeString();
    $data['updated_at'] = \Carbon\Carbon::now()->toDateTimeString();
    DB::table($this->table)->insert($data);
  }

  public function updateMediaAccess($id, $data)
  {
    $data['updated_at'] = \Carbon\Carbon::now()->toDateTimeString();
    DB::table($this->table)
      ->where('id', $id)
      ->update($data);
  }

  public function getByMediaIdAndAccessDate($media_id, $access_date)
  {
    return DB::table($this->table)->select('*')
      ->where('media_id', $media_id)
      ->where('access_date', $access_date)
      ->first();
  }

  public function haveMediaAccess($media_id, $access_date)
  {
    $result = DB::table($this->table)->select('*')
      ->where('media_id', $media_id)
      ->where('access_date', $access_date)
      ->first();

    return is_null($result) ? false : true;
  }

  public function numberMediaAccessMonth($year, $month, $media_code)
  {
    $result = DB::table($this->table)
      ->select(DB::raw('SUM(number_access) as number_access'))
      ->where('media_code', $media_code)
      ->whereRaw('YEAR(access_date) =' . $year . ' AND MONTH(access_date)=' . $month)
      ->where('deleted_flg', DELETED_DISABLE)
      ->get()
      ->toArray();

    return (integer)$result[0]->number_access;
  }

  public function numberMediaAccessPeriodTime($time_start, $time_end, $media_code)
  {
    $result = DB::table($this->table)
      ->select(DB::raw('SUM(number_access) as number_access'))
      ->where('media_code', $media_code)
      ->where($this->table . '.created_at', '>=', $time_start)
      ->where($this->table . '.created_at', '<=', $time_end)
      ->where('deleted_flg', DELETED_DISABLE)
      ->get()
      ->toArray();

    return (integer)$result[0]->number_access;
  }

  public function numberMediaAccessDaily($year, $month, $media_code)
  {
    $result = DB::table($this->table)
      ->select(DB::raw('DATE(access_date) as date,
      SUM(number_access) as number_access'))
      ->where('media_code', $media_code)
      ->where('deleted_flg', DELETED_DISABLE)
      ->whereRaw('YEAR(access_date) =' . $year . ' AND MONTH(access_date)=' . $month)
      ->groupBy('date')
      ->get()
      ->toArray();

    return $result;
  }

  public function partnerGetSummaryMediaAccess($year, $month, $media_code)
  {
    $result = DB::table($this->table)
      ->select(DB::raw('media_code as media_code'),
        DB::raw('SUM(number_access) as number_access'))
      ->where('media_code', 'like', "%{$media_code}%")
      ->where('deleted_flg', DELETED_DISABLE)
      ->whereRaw('YEAR(access_date) =' . $year . ' AND MONTH(access_date)=' . $month)
      ->groupBy('media_code')
      ->get()
      ->toArray();

    return $result;
  }

  public function partnerGetSummaryMediaAccessPeriod($time_start, $time_end, $media_code)
  {
    $result = DB::table($this->table)
      ->select(DB::raw('media_code as media_code'),
        DB::raw('SUM(number_access) as number_access'))
      ->where('media_code', 'like', "%{$media_code}%")
      ->where('deleted_flg', DELETED_DISABLE)
      ->where('access_date', '>=', $time_start)
      ->where('access_date', '<=', $time_end)
      ->groupBy('media_code')
      ->get()
      ->toArray();

    return $result;
  }
}