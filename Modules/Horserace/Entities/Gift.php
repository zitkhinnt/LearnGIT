<?php

namespace Modules\Horserace\Entities;

use Illuminate\Database\Eloquent\Model as Model;
use Illuminate\Support\Facades\DB;

class Gift
{
  protected $table = 'gift';

  protected $fillable = [
    'id',
    'name',
    'point',
    'type',
    'send_date',
    'content',
    'start_time',
    'end_time',
  ];

  public function insertGift($data)
  {
    $data['created_at'] = \Carbon\Carbon::now()->toDateTimeString();
    $data['updated_at'] = \Carbon\Carbon::now()->toDateTimeString();
    return DB::table($this->table)->insert($data);
  }

  public function getGift()
  {
    return DB::table($this->table)
      ->where($this->table . '.deleted_flg', DELETED_DISABLE)
      ->orderBy('id', 'DESC')
      ->get()
      ->toArray();
  }

  public function getGiftById($id)
  {
    return DB::table($this->table)->find($id);
  }

  public function updateGift($id, $data)
  {
    $data['updated_at'] = \Carbon\Carbon::now()->toDateTimeString();
    DB::table($this->table)
      ->where('id', $id)
      ->update($data);
  }

  public function deleteGift($id)
  {
    $data['deleted_flg'] = DELETED_ENABLE;
    DB::table($this->table)
      ->where('id', $id)
      ->update($data);
  }

  public function getGiftByType($type)
  {
    $now = \Carbon\Carbon::now()->toDateTimeString();
    $result = DB::table($this->table)
      ->where($this->table . '.deleted_flg', DELETED_DISABLE)
      ->where($this->table . '.type', $type)
      ->where($this->table . '.start_time', '<=', $now)
      ->where($this->table . '.end_time', '>=', $now);

    if ($type == GIFT_TYPE_EVENT) {
      $result = $result->where($this->table . '.send_date', '<=', $now);
    }

    $result = $result->get()
      ->toArray();
    return $result;
  }
}
