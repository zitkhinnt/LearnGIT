<?php

namespace Modules\Horserace\Entities;

use Illuminate\Database\Eloquent\Model as Model;
use Illuminate\Support\Facades\DB;

class MailScheduleDetail
{
  protected $table = 'mail_schedule_detail';

  public function insertMailScheduleDetail($data)
  {
    $data['created_at'] = \Carbon\Carbon::now()->toDateTimeString();
    $data['updated_at'] = \Carbon\Carbon::now()->toDateTimeString();
    return DB::table($this->table)->insert($data);
  }

  public function getMailScheduleDetail()
  {
    return DB::table($this->table)
      ->where($this->table . '.deleted_flg', DELETED_DISABLE)
      ->orderBy('id', 'DESC')
      ->get()
      ->toArray();
  }

  public function getMailScheduleDetailById($id)
  {
    return DB::table($this->table)->find($id);
  }

  public function updateMailScheduleDetail($id, $data)
  {
    $data['updated_at'] = \Carbon\Carbon::now()->toDateTimeString();
    DB::table($this->table)
      ->where('id', $id)
      ->update($data);
  }

  public function deleteMailScheduleDetail($id)
  {
    $data['deleted_flg'] = DELETED_ENABLE;
    DB::table($this->table)
      ->where('id', $id)
      ->update($data);
  }

  public function getMailScheduleDetailByUserId($user_id)
  {
    return DB::table($this->table)
      ->where($this->table . '.user_id', $user_id)
      ->where($this->table . '.deleted_flg', DELETED_DISABLE)
      ->get()
      ->toArray();
  }

  public function changeMailScheduleReadAt($user_id, $id)
  {
    $result = DB::table($this->table)
      ->where($this->table . '.id', $id)
      ->where($this->table . '.user_id', $user_id)
      ->where($this->table . '.deleted_flg', DELETED_DISABLE)
      ->first();

    if (is_null($result->read_at)) {
      $data['read_at'] = \Carbon\Carbon::now()->toDateTimeString();
      DB::table($this->table)
        ->where('id', $id)
        ->update($data);
    }
  }

  public function getMailScheduleDetailByIdUser($user_id, $mail_id)
  {
    $result = DB::table($this->table)
      ->where($this->table . '.id', $mail_id)
      ->where($this->table . '.user_id', $user_id)
      ->where($this->table . '.deleted_flg', DELETED_DISABLE)
      ->first();

    return $result;
  }

  public function deleteMailScheduleDetailUser($user_id, $mail_id)
  {
    $data['deleted_flg'] = DELETED_ENABLE;
    DB::table($this->table)
      ->where('user_id', $user_id)
      ->where('id', $mail_id)
      ->update($data);
  }
}
