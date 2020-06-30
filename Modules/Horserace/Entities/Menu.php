<?php

namespace Modules\Horserace\Entities;

use Illuminate\Database\Eloquent\Model as Model;
use Illuminate\Support\Facades\DB;

class menu
{
  
  protected $table = 'menu';



  public function getListMenu($level)
  {
    return DB::table($this->table)
      ->where($this->table . '.deleted_flg', DELETED_DISABLE)
      ->where('level', $level)
      ->orderBy('id', 'ASC')
      ->get()
      ->toArray();
  }

  public function getMenuListId($list)
  {
    return DB::table($this->table)
      ->where($this->table . '.deleted_flg', DELETED_DISABLE)
      ->wherein('id', explode(",", $list))
      ->orderBy('id', 'ASC')
      ->get()
      ->toArray();
  }

  public function getListParentID($list)
  {
    return DB::table($this->table)->select('groupid')
    ->where($this->table . '.deleted_flg', DELETED_DISABLE)
    ->wherein('id', explode(",", $list))
    ->distinct('groupid')
    ->get()
    ->toArray();
  }

  public function  getlistParentDetail($list)
  {
    return DB::table($this->table)
    ->where($this->table . '.deleted_flg', DELETED_DISABLE)
    ->wherein('id', explode(",", $list))
    ->orderBy('id', 'ASC')
    ->get()
    ->toArray();
  }
}