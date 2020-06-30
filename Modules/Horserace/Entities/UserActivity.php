<?php

namespace Modules\Horserace\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserActivity
{
  protected $table = 'user_activity';

  public function user()
  {
    return $this->belongTo('Modules\Horserace\Entities\User');
  }

  public function insertUserActivity($data)
  {
    $data['created_at'] = \Carbon\Carbon::now()->toDateTimeString();
    $data['updated_at'] = \Carbon\Carbon::now()->toDateTimeString();
    DB::table($this->table)->insert($data);
  }

  public function updateUserActivity($user_id, $data)
  {
    $data['updated_at'] = \Carbon\Carbon::now()->toDateTimeString();
    DB::table($this->table)
      ->where('user_id', $user_id)
      ->update($data);
  }

  public function getUserActivityByUserId($user_id)
  {
    return DB::table($this->table)->select('*')
      ->where('user_id', trim($user_id))
      ->first();
  }
}