<?php

namespace Modules\Horserace\Entities;

use Illuminate\Database\Eloquent\Model as Model;
use Illuminate\Support\Facades\DB;

class MailSchedule
{
  protected $table = 'mail_schedule';

  public function insertMailSchedule($data)
  {
    $data['created_at'] = \Carbon\Carbon::now()->toDateTimeString();
    $data['updated_at'] = \Carbon\Carbon::now()->toDateTimeString();
    return DB::table($this->table)->insert($data);
  }

  public function getMailSchedule()
  {
    return DB::table($this->table)
      ->where($this->table . '.deleted_flg', DELETED_DISABLE)
      ->orderBy('id', 'DESC')
      ->get()
      ->toArray();
  }

  public function getMailScheduleById($id)
  {
    return DB::table($this->table)->find($id);
  }

  public function updateMailSchedule($id, $data)
  {
    $data['updated_at'] = \Carbon\Carbon::now()->toDateTimeString();
    DB::table($this->table)
      ->where('id', $id)
      ->update($data);
  }

  public function deleteMailSchedule($id)
  {
    $data['deleted_flg'] = DELETED_ENABLE;
    DB::table($this->table)
      ->where('id', $id)
      ->update($data);
  }

  public function getMailScheduleSend()
  {
    $result = DB::table($this->table)
      ->where($this->table . '.deleted_flg', DELETED_DISABLE)
      ->get()
      ->toArray();

    return $result;
  }

  public function getMailScheduleSendDesignation()
  {
    $result = DB::table($this->table)
      ->where($this->table . '.properties', MAIL_SCHEDULE_PROPERTIES_DESIGNATION)
      ->where($this->table . '.deleted_flg', DELETED_DISABLE)
      ->get()
      ->toArray();

    return $result;
  }

  public function getMailScheduleTarget($target)
  {
    return DB::table($this->table)
      ->where($this->table . '.properties', MAIL_SCHEDULE_PROPERTIES_ELAPSED)
      ->where($this->table . '.target', $target)
      ->where($this->table . '.deleted_flg', DELETED_DISABLE)
      ->get()
      ->toArray();
  }

  public function countMailScheduleTarget($target)
  {
    return DB::table($this->table)
      ->where($this->table . '.properties', MAIL_SCHEDULE_PROPERTIES_ELAPSED)
      ->where($this->table . '.target', $target)
      ->where($this->table . '.deleted_flg', DELETED_DISABLE)
      ->count();
  }
}
