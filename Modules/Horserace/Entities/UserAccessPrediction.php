<?php

namespace Modules\Horserace\Entities;

use Illuminate\Database\Eloquent\Model as Model;
use Illuminate\Support\Facades\DB;

class UserAccessPrediction
{

  protected $table = 'user_access_prediction';

  public function insertUserAccessPrediction($data)
  {
    $data['created_at'] = \Carbon\Carbon::now()->toDateTimeString();
    $data['updated_at'] = \Carbon\Carbon::now()->toDateTimeString();
    return DB::table($this->table)->insert($data);
  }

  public function getUserAccessPrediction()
  {
    return DB::table($this->table)
      ->where($this->table . '.deleted_flg', 0)
      ->orderBy('id', 'DESC')
      ->get()
      ->toArray();
  }

  public function getUserAccessPredictionById($id)
  {
    return DB::table($this->table)->find($id);
  }

  public function updateUserAccessPrediction($id, $data)
  {
    $data['updated_at'] = \Carbon\Carbon::now()->toDateTimeString();
    DB::table($this->table)
      ->where('id', $id)
      ->update($data);
  }

  public function deleteUserAccessPrediction($id)
  {
    $data['deleted_flg'] = 1;
    DB::table($this->table)
      ->where('id', $id)
      ->update($data);
  }

  public function haveAccessPrediction($user_id, $prediction_id)
  {
    $result = DB::table($this->table)
      ->where($this->table . '.prediction_id', $prediction_id)
      ->where($this->table . '.user_id', $user_id)
      ->where($this->table . '.deleted_flg', DELETED_DISABLE)
      ->first();
    return is_null($result) ? false : true;
  }

  public function haveBuyPrediction($user_id, $prediction_id)
  {
    $result = DB::table($this->table)
      ->where($this->table . '.prediction_id', $prediction_id)
      ->where($this->table . '.user_id', $user_id)
      ->where($this->table . '.buy', BUY_PREDICTION)
      ->where($this->table . '.deleted_flg', DELETED_DISABLE)
      ->first();

    return is_null($result) ? false : true;
  }

  public function addAccessPrediction($user_id, $prediction_id)
  {
    $result = DB::table($this->table)
      ->where($this->table . '.prediction_id', $prediction_id)
      ->where($this->table . '.user_id', $user_id)
      ->where($this->table . '.deleted_flg', DELETED_DISABLE)
      ->first();

    $arr_access["number_access"] = (integer)$result->number_access + 1;
    $this->updateUserAccessPrediction($result->id, $arr_access);
  }

  public function changeBuyPrediction($user_id, $prediction_id)
  {
    $result = DB::table($this->table)
      ->where($this->table . '.prediction_id', $prediction_id)
      ->where($this->table . '.user_id', $user_id)
      ->where($this->table . '.deleted_flg', DELETED_DISABLE)
      ->first();

    if (is_null($result)) {
      $arr_user_access = [
        "user_id" => $user_id,
        "prediction_id" => $prediction_id,
        "number_access" => 1,
        "buy" => BUY_PREDICTION,
      ];
      $this->insertUserAccessPrediction($arr_user_access);
    } else {
      $arr_access["buy"] = BUY_PREDICTION;
      $this->updateUserAccessPrediction($result->id, $arr_access);
    }
  }

  public function changeErrorBuyPrediction($user_id, $prediction_id)
  {
    $result = DB::table($this->table)
      ->where($this->table . '.prediction_id', $prediction_id)
      ->where($this->table . '.user_id', $user_id)
      ->where($this->table . '.deleted_flg', DELETED_DISABLE)
      ->first();

    if (is_null($result)) {
      $arr_user_access = [
        "user_id" => $user_id,
        "prediction_id" => $prediction_id,
        "number_access" => 1,
        "buy" => BUY_PREDICTION_ERROR,
      ];
      $this->insertUserAccessPrediction($arr_user_access);
    }
    else
    {
      $arr_access["buy"] = BUY_PREDICTION_ERROR;
      $this->updateUserAccessPrediction($result->id, $arr_access);
    }
  }

  public function accessResultUserAccessPrediction($user_id, $prediction_id)
  {
    $result = DB::table($this->table)
      ->where($this->table . '.prediction_id', $prediction_id)
      ->where($this->table . '.user_id', $user_id)
      ->where($this->table . '.deleted_flg', DELETED_DISABLE)
      ->first();

    if (is_null($result)) {
      $arr_user_access = [
        "user_id" => $user_id,
        "prediction_id" => $prediction_id,
        "number_access" => 1,
        "access_result" => ACCESS_RESULT_SEE,
      ];
      $this->insertUserAccessPrediction($arr_user_access);
    } else {
      if ($result->access_result == ACCESS_RESULT_NOT_SEE) {
        $arr_access["access_result"] = ACCESS_RESULT_SEE;
        $this->updateUserAccessPrediction($result->id, $arr_access);
      }
    }
  }

  public function getUserAccessByPredictionId($prediction_id)
  {
    return DB::table($this->table)
      ->where($this->table . '.prediction_id', $prediction_id)
      ->where($this->table . '.deleted_flg', 0)
      ->orderBy('id', 'DESC')
      ->get()
      ->toArray();
  }

  public function getUserBuyByPredictionId($prediction_id)
  {
    return DB::table($this->table)
      ->where($this->table . '.buy', BUY_PREDICTION)
      ->where($this->table . '.prediction_id', $prediction_id)
      ->where($this->table . '.deleted_flg', 0)
      ->orderBy('id', 'DESC')
      ->get()
      ->toArray();
  }
}
