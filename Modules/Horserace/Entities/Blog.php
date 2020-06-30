<?php

namespace Modules\Horserace\Entities;

use Illuminate\Database\Eloquent\Model as Model;
use Illuminate\Support\Facades\DB;

class Blog extends Model
{
  protected $table = 'blog';

  protected $fillable = [
    'id',
    'title',
    'status',
    'content',
    'deleted_flg',
  ];

  public function insertBlog($data)
  {
    $data['created_at'] = \Carbon\Carbon::now()->toDateTimeString();
    $data['updated_at'] = \Carbon\Carbon::now()->toDateTimeString();
    return DB::table($this->table)->insert($data);
  }

  public function getBlog()
  {
    return DB::table($this->table)
      ->where($this->table . '.deleted_flg', 0)
      ->orderBy('id', 'DESC')
      ->get()
      ->toArray();
  }

  public function getBlogPublic()
  {
    $now = \Carbon\Carbon::now()->toDateTimeString();
    return DB::table($this->table)
      ->where('public_at', '<=', $now)
      ->where('public_end','>=', $now)
      ->where($this->table . '.deleted_flg', 0)
      ->orderBy('public_at', 'DESC')
      ->get()
      ->toArray();
  }

  public function getBLogById($id)
  {
    $now = \Carbon\Carbon::now()->toDateTimeString();
    return DB::table($this->table)
      // ->where('public_at', '<=', $now)
      ->where($this->table . '.deleted_flg', 0)
      ->find($id);
  }

  public function updateBlog($id, $data)
  {
    $data['updated_at'] = \Carbon\Carbon::now()->toDateTimeString();
    DB::table($this->table)
      ->where('id', $id)
      ->update($data);
  }

  public function deleteBlog($id)
  {
    $data['deleted_flg'] = 1;
    DB::table($this->table)
      ->where('id', $id)
      ->update($data);
  }

  public function addAccessBlog($id)
  {
    $result = DB::table($this->table)
      ->where($this->table . '.id', $id)
      ->where($this->table . '.deleted_flg', DELETED_DISABLE)
      ->first();

    $arr_access["number_access"] = (integer)$result->number_access + 1;
    $this->updateBlog($result->id, $arr_access);
  }
}
