<?php

namespace Modules\Horserace\Entities;

use Illuminate\Database\Eloquent\Model as Model;
use Illuminate\Support\Facades\DB;

class MailPredictionResultDetail
{
  protected $table = 'mail_prediction_result_detail';

  public function insertMailPredictionResultDetail($data)
  {
    $data['created_at'] = \Carbon\Carbon::now()->toDateTimeString();
    $data['updated_at'] = \Carbon\Carbon::now()->toDateTimeString();
    return DB::table($this->table)->insert($data);
  }

  public function getMailPredictionResultDetail()
  {
    return DB::table($this->table)
      ->where($this->table . '.deleted_flg', DELETED_DISABLE)
      ->orderBy('id', 'DESC')
      ->get()
      ->toArray();
  }

  public function getMailPredictionResultDetailById($id)
  {
    return DB::table($this->table)->find($id);
  }

  public function updateMailPredictionResultDetail($id, $data)
  {
    $data['updated_at'] = \Carbon\Carbon::now()->toDateTimeString();
    DB::table($this->table)
      ->where('id', $id)
      ->update($data);
  }

  public function deleteMailPredictionResultDetail($id)
  {
    $data['deleted_flg'] = DELETED_ENABLE;
    DB::table($this->table)
      ->where('id', $id)
      ->update($data);
  }

  public function getMailPredictionResultDetailByUserId($user_id)
  {
    return DB::table($this->table)
      ->where($this->table . '.user_id', $user_id)
      ->where($this->table . '.deleted_flg', DELETED_DISABLE)
      ->get()
      ->toArray();
  }

  public function changeMailPredictionResultReadAt($user_id, $id)
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

  public function getMailPredictionResultDetailByIdUser($user_id, $mail_id)
  {
    $result = DB::table($this->table)
      ->where($this->table . '.id', $mail_id)
      ->where($this->table . '.user_id', $user_id)
      ->where($this->table . '.deleted_flg', DELETED_DISABLE)
      ->first();

    return $result;
  }

  public function deleteMailPredictionResultDetailUser($user_id, $mail_id)
  {
    $data['deleted_flg'] = DELETED_ENABLE;
    DB::table($this->table)
      ->where('user_id', $user_id)
      ->where('id', $mail_id)
      ->update($data);
  }
}
