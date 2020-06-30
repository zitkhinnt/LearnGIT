<?php

namespace Modules\Horserace\Entities;

use Illuminate\Database\Eloquent\Model as Model;
use Illuminate\Support\Facades\DB;

class MailScheduleDone
{
  protected $table = 'mail_schedule_done';

  public function insertMailScheduleDone($data)
  {
    $data['created_at'] = \Carbon\Carbon::now()->toDateTimeString();
    $data['updated_at'] = \Carbon\Carbon::now()->toDateTimeString();
    return DB::table($this->table)->insert($data);
  }

  public function getMailScheduleDone()
  {
    return DB::table($this->table)
      ->where($this->table . '.deleted_flg', DELETED_DISABLE)
      ->orderBy('mail_schedule_done.id', 'DESC')
      ->get()
      ->toArray();
  }

  public function getMailScheduleDoneById($id)
  {
    return DB::table($this->table)->find($id);
  }

  public function updateMailScheduleDone($id, $data)
  {
    $data['updated_at'] = \Carbon\Carbon::now()->toDateTimeString();
    DB::table($this->table)
      ->where('id', $id)
      ->update($data);
  }

  public function deleteMailScheduleDone($id)
  {
    $data['deleted_flg'] = DELETED_ENABLE;
    DB::table($this->table)
      ->where('id', $id)
      ->update($data);
  }

  public function addNumberReadByMailScheduleId($mail_id)
  {
    $result = DB::table($this->table)
      ->rightJoin('mail_schedule_detail', 'mail_schedule_done.mail_schedule_id', '=', 'mail_schedule_detail.mail_schedule_id')
      ->where('mail_schedule_detail.id', $mail_id)
      ->whereRaw('DATE(mail_schedule_detail.created_at) = DATE(mail_schedule_done.created_at)')
      ->where($this->table . '.deleted_flg', DELETED_DISABLE)
      ->where('mail_schedule_detail.deleted_flg', DELETED_DISABLE)
      ->select('mail_schedule_done.id', 'mail_schedule_done.read_number')
      ->first();

    if (!is_null($result)) {
      $arr_mail_bulk_done["read_number"] = (integer)$result->read_number + 1;
      $this->updateMailScheduleDone($result->id, $arr_mail_bulk_done);
    }
  }
}
