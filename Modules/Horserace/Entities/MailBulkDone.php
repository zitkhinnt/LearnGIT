<?php

namespace Modules\Horserace\Entities;

use Illuminate\Database\Eloquent\Model as Model;
use Illuminate\Support\Facades\DB;

class MailBulkDone
{
  protected $table = 'mail_bulk_done';

  public function insertMailBulkDone($data)
  {
    $data['created_at'] = \Carbon\Carbon::now()->toDateTimeString();
    $data['updated_at'] = \Carbon\Carbon::now()->toDateTimeString();
    return DB::table($this->table)->insert($data);
  }

  public function getMailBulkDone()
  {
    return DB::table($this->table)
      ->where($this->table . '.deleted_flg', DELETED_DISABLE)
      ->orderBy('id', 'DESC')
      ->get()
      ->toArray();
  }

  public function getMailBulkDoneByMailBulkId($mail_bulk_id)
  {
    $result = DB::table($this->table)
      ->where($this->table . '.mail_bulk_id', $mail_bulk_id)
      ->where($this->table . '.deleted_flg', DELETED_DISABLE)
      ->first();

    return $result;
  }

  public function getMailBulkDoneById($id)
  {
    return DB::table($this->table)->find($id);
  }

  public function updateMailBulkDone($id, $data)
  {
    $data['updated_at'] = \Carbon\Carbon::now()->toDateTimeString();
    DB::table($this->table)
      ->where('id', $id)
      ->update($data);
  }

  public function getMailBulkDoneByPredictionId($prediction_id)
  {
    return DB::table($this->table)
      ->where($this->table . '.mail_bulk_id', $prediction_id)
      ->where($this->table . '.deleted_flg', DELETED_DISABLE)
      ->first();
  }

  public function deleteMailBulkDone($id)
  {
    $data['deleted_flg'] = DELETED_ENABLE;
    DB::table($this->table)
      ->where('id', $id)
      ->update($data);
  }

  public function addNumberReadByMailBulkId($mail_bulk_id)
  {
    $result = DB::table($this->table)
      ->where($this->table . '.mail_bulk_id', $mail_bulk_id)
      ->where($this->table . '.deleted_flg', DELETED_DISABLE)
      ->first();

    if (!is_null($result)) {
      $arr_mail_bulk_done["read_number"] = (integer)$result->read_number + 1;
      $this->updateMailBulkDone($result->id, $arr_mail_bulk_done);
    }
  }

  public function getSummaryMailBulkDaily($year, $month)
  {
    $result = DB::table($this->table)
      ->select(DB::raw('DATE(created_at) as date'),
        DB::raw('SUM(total_user) as total_user,
          SUM(send_success_number) as send_success_number,
          SUM(read_number) as read_number'))
      ->whereRaw('YEAR(created_at) =' . $year . ' AND MONTH(created_at)=' . $month)
      ->groupBy('date')
      ->get()
      ->toArray();

    return $result;
  }

  public function getSummaryMailBulkWeekly($week_start, $week_end)
  {
    $result = DB::table($this->table)
      ->whereRaw('WEEKOFYEAR(created_at)>=' . $week_start)
      ->whereRaw('WEEKOFYEAR(created_at)<=' . $week_end)
      ->select(DB::raw('WEEKOFYEAR(created_at) as week_of_year'),
        DB::raw('SUM(total_user) as total_user,
          SUM(send_success_number) as send_success_number,
          SUM(read_number) as read_number'))
      ->groupBy('week_of_year')
      ->get()
      ->toArray();

    return $result;
  }
}
