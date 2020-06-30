<?php

namespace Modules\Horserace\Entities;

use Illuminate\Database\Eloquent\Model as Model;
use Illuminate\Support\Facades\DB;

class PredictionResult
{
  protected $table = 'prediction_result';

  public function insertPredictionResult($data)
  {
    $data['created_at'] = \Carbon\Carbon::now()->toDateTimeString();
    $data['updated_at'] = \Carbon\Carbon::now()->toDateTimeString();
    return DB::table($this->table)->insert($data);
  }

  public function getPredictionResult()
  {
    return DB::table($this->table)
      ->where($this->table . '.deleted_flg', DELETED_DISABLE)
      ->orderBy('id', 'DESC')
      ->get()
      ->toArray();
  }

  public function getPredictionResultById($id)
  {
    return DB::table($this->table)->find($id);
  }

  public function updatePredictionResult($id, $data)
  {
    $data['updated_at'] = \Carbon\Carbon::now()->toDateTimeString();
    DB::table($this->table)
      ->where('id', $id)
      ->update($data);
  }

  public function deletePredictionResult($id)
  {
    $data['deleted_flg'] = DELETED_ENABLE;
    DB::table($this->table)
      ->where('id', $id)
      ->update($data);
  }

  public function getPredictionResultSendMail()
  {
    $now = \Carbon\Carbon::now();
    return DB::table($this->table)
      ->where($this->table . '.reserve_datetime', '<=', $now)
      ->where($this->table . '.send_mail', SEND_MAIL_NOT)
      ->where($this->table . '.deleted_flg', DELETED_DISABLE)
      ->get()
      ->toArray();
  }

  public function getResultByPredictionId($prediction_id)
  {
    return DB::table($this->table)
      ->where($this->table . '.prediction_id', $prediction_id)
      ->where($this->table . '.deleted_flg', DELETED_DISABLE)
      ->first();
  }
}
