<?php

namespace Modules\Horserace\Entities;

use Illuminate\Database\Eloquent\Model as Model;
use Illuminate\Support\Facades\DB;

class Point extends Model
{
  protected $table = 'point';

  protected $fillable = [
    'id',
    'point',
    'price',
    'deleted_flg',
  ];
  
  public function insertPoint($data)
  {
    $data['created_at'] = \Carbon\Carbon::now()->toDateTimeString();
    $data['updated_at'] = \Carbon\Carbon::now()->toDateTimeString();
    return DB::table($this->table)->insert($data);
  }

  public function getPoint()
  {
    return DB::table($this->table)
      ->where($this->table . '.deleted_flg', 0)
      ->orderBy('point', 'ASC')
      ->get()
      ->toArray();
  }

  public function getPointById($id)
  {
    return DB::table($this->table)->find($id);
  }

  public function updatePoint($id, $data)
  {
    $data['updated_at'] = \Carbon\Carbon::now()->toDateTimeString();
    DB::table($this->table)
      ->where('id', $id)
      ->update($data);
  }

  public function deletePoint($id)
  {
    $data['deleted_flg'] = 1;
    DB::table($this->table)
      ->where('id', $id)
      ->update($data);
  }
}
