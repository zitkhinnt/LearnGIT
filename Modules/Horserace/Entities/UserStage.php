<?php

namespace Modules\Horserace\Entities;

use Illuminate\Database\Eloquent\Model as Model;
use Illuminate\Support\Facades\DB;

class UserStage
{
  protected $table = 'user_stage';

  public function insertUserStage($data)
  {
    $data['created_at'] = \Carbon\Carbon::now()->toDateTimeString();
    $data['updated_at'] = \Carbon\Carbon::now()->toDateTimeString();
    return DB::table($this->table)->insert($data);
  }

  public function getUserStage()
  {
    return DB::table($this->table)
      ->where($this->table . '.deleted_flg', 0)
      ->orderBy('id', 'ASC')
      ->get()
      ->toArray();
  }

  public function getUserStageById($id)
  {
    return DB::table($this->table)->find($id);
  }

  public function updateUserStage($id, $data)
  {
    $data['updated_at'] = \Carbon\Carbon::now()->toDateTimeString();
    DB::table($this->table)
      ->where('id', $id)
      ->update($data);
  }

  public function deleteUserStage($id)
  {
    $data['deleted_flg'] = 1;
    DB::table($this->table)
      ->where('id', $id)
      ->update($data);
  }
}
