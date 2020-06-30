<?php

namespace Modules\Horserace\Entities;

use Illuminate\Database\Eloquent\Model as Model;
use Illuminate\Support\Facades\DB;

class UserAccessBlog
{

  protected $table = 'user_access_blog';

  public function insertUserAccessBlog($data)
  {
    $data['created_at'] = \Carbon\Carbon::now()->toDateTimeString();
    $data['updated_at'] = \Carbon\Carbon::now()->toDateTimeString();
    return DB::table($this->table)->insert($data);
  }

  public function getUserAccessBlog()
  {
    return DB::table($this->table)
      ->where($this->table . '.deleted_flg', 0)
      ->orderBy('id', 'DESC')
      ->get()
      ->toArray();
  }

  public function getUserAccessBlogById($id)
  {
    return DB::table($this->table)->find($id);
  }

  public function updateUserAccessBlog($id, $data)
  {
    $data['updated_at'] = \Carbon\Carbon::now()->toDateTimeString();
    DB::table($this->table)
      ->where('id', $id)
      ->update($data);
  }

  public function deleteUserAccessBlog($id)
  {
    $data['deleted_flg'] = 1;
    DB::table($this->table)
      ->where('id', $id)
      ->update($data);
  }

  public function haveAccessBlog($user_id, $blog_id)
  {
    $result = DB::table($this->table)
      ->where($this->table . '.blog_id', $blog_id)
      ->where($this->table . '.user_id', $user_id)
      ->where($this->table . '.deleted_flg', DELETED_DISABLE)
      ->first();
    return is_null($result) ? false : true;
  }


  public function addAccessBlog($user_id, $blog_id)
  {
    $result = DB::table($this->table)
      ->where($this->table . '.blog_id', $blog_id)
      ->where($this->table . '.user_id', $user_id)
      ->where($this->table . '.deleted_flg', DELETED_DISABLE)
      ->first();

    $arr_access["number_access"] = (integer)$result->number_access + 1;
    $this->updateUserAccessBlog($result->id, $arr_access);
  }

  public function getUserAccessByBlogId($blog_id)
  {
    return DB::table($this->table)
      ->where($this->table . '.blog_id', $blog_id)
      ->where($this->table . '.deleted_flg', 0)
      ->orderBy('id', 'DESC')
      ->get()
      ->toArray();
  }

}
