<?php

namespace Modules\Horserace\Entities;

use Illuminate\Database\Eloquent\Model as Model;
use Illuminate\Support\Facades\DB;

class TransactionPayment
{
  protected $table = 'transaction_payment';

  public function insertTransactionPayment($data)
  {
    $data['created_at'] = \Carbon\Carbon::now()->toDateTimeString();
    $data['updated_at'] = \Carbon\Carbon::now()->toDateTimeString();
    return DB::table($this->table)->insertGetId($data);
  }

  public function getTransactionPayment()
  {
    return DB::table($this->table)
      ->where($this->table . '.deleted_flg', DELETED_DISABLE)
      ->orderBy('id', 'DESC')
      ->get()
      ->toArray();
  }

  public function getSearchTransactionPayment($input)
  {
    $result = DB::table($this->table)
      ->where($this->table . '.deleted_flg', DELETED_DISABLE);

    if (!is_null($input['iSortCol_0']) && $input['iSortCol_0'] == 0) {
      $result->orderBy('id', $input['sSortDir_0']);
    }
    if (!is_null($input['iSortCol_0']) && $input['iSortCol_0'] == 1) {
      $result->orderBy('created_at', $input['sSortDir_0']);
    }
    if (!is_null($input['iSortCol_0']) && $input['iSortCol_0'] == 2) {
      $result->orderBy('login_id', $input['sSortDir_0']);
    }
    if (!is_null($input['iSortCol_0']) && $input['iSortCol_0'] == 3) {
      $result->orderBy('point', $input['sSortDir_0']);
    }
    if (!is_null($input['iSortCol_0']) && $input['iSortCol_0'] == 4) {
      $result->orderBy('prediction_name', $input['sSortDir_0']);
    }

    if (isset($input['key_search']) && !is_null($input['key_search']) && (strlen($input['key_search']) > 0)) {
      $result->where('id', 'like', '%' . $input['key_search'] . '%')
        ->orWhere('login_id', 'like', '%' . $input['key_search'] . '%')
        ->orWhere('prediction_name', 'like', '%' . $input['key_search'] . '%')
        ->orWhere('point', 'like', '%' . $input['key_search'] . '%')
        ->orWhere('created_at', 'like', '%' . $input['key_search'] . '%')
        ->orWhere('updated_at', 'like', '%' . $input['key_search'] . '%');
    }

    $total_record = $result->count();
    $current_page = ($input['iDisplayStart'] / $input['iDisplayLength']) + 1;
    $limit = $input['iDisplayLength'];
    $total_page = ceil($total_record / $limit);
    if ($current_page > $total_page) {
      $current_page = $total_page;
    } else if ($current_page < 1) {
      $current_page = 1;
    }
    $skip = ($current_page - 1) * $limit;
    $data['total'] = $total_record;
    $data['result'] = $result->skip($skip)->take($limit)->get()->toArray();
    return $data;
  }

  public function getTransactionPaymentById($id)
  {
    return DB::table($this->table)->find($id);
  }

  public function updateTransactionPayment($id, $data)
  {
    $data['updated_at'] = \Carbon\Carbon::now()->toDateTimeString();
    DB::table($this->table)
      ->where('id', $id)
      ->update($data);
  }

  public function getTransactionPaymentByUserId($user_id)
  {
    return DB::table($this->table)
      ->where($this->table . '.user_id', $user_id)
      ->where($this->table . '.status', APPLY)
      ->where($this->table . '.deleted_flg', DELETED_DISABLE)
      ->orderBy('updated_at', 'DESC')
      ->get()
      ->toArray();
  }

  public function deleteTransactionPayment($id)
  {
    $data['deleted_flg'] = DELETED_ENABLE;
    DB::table($this->table)
      ->where('id', $id)
      ->update($data);
  }

  public function getSendMailPayment($number_mail_payment)
  {
    return DB::table($this->table)
      ->where($this->table . '.status', APPLY)
      ->where($this->table . '.send_mail_payment', "<", $number_mail_payment)
      ->where($this->table . '.deleted_flg', DELETED_DISABLE)
      ->get()
      ->toArray();
  }

  public function getSendMailPredictionResult($prediction_id)
  {
    return DB::table($this->table)
      ->where($this->table . '.status', APPLY)
      ->where($this->table . '.prediction_id', $prediction_id)
      ->where($this->table . '.send_mail_prediction_result', SEND_MAIL_NOT)
      ->where($this->table . '.deleted_flg', DELETED_DISABLE)
      ->get()
      ->toArray();
  }

  public function getTransactionByUserIdAndPredictionId($user_id, $prediction_id)
  {
    return DB::table($this->table)
      ->where($this->table . '.status', APPLY)
      ->where($this->table . '.prediction_id', $prediction_id)
      ->where($this->table . '.user_id', $user_id)
      ->where($this->table . '.deleted_flg', DELETED_DISABLE)
      ->get()
      ->first();
  }
  public function getTransactionByUserIdAndPredictionIdDuplicate($user_id, $prediction_id) 
  {
    return DB::table($this->table)
      ->where($this->table . '.status', APPLY)
      ->where($this->table . '.prediction_id', $prediction_id)
      ->where($this->table . '.user_id', $user_id)
      ->where($this->table . '.deleted_flg', DELETED_DISABLE)
      ->get()
      ->toArray();
  }

  public function addSendMailPayment($tran_id, $mail_id)
  {
    $result = DB::table($this->table)->find($tran_id);
    $mail_payment = json_decode($result->mail_payment, true);
    $mail_payment[$mail_id] = $mail_id;

    $arr_payment = [
      "send_mail_payment" => (integer)$result->send_mail_payment + 1,
      "mail_payment" => json_encode($mail_payment)
    ];
    $this->updateTransactionPayment($tran_id, $arr_payment);
  }

  public function paymentToday($time)
  {
    $result = DB::table($this->table)
      ->select(DB::raw('SUM(point) as total_point,
      COUNT(id) as number_payment'))
      ->where($this->table . '.status', APPLY)
      // ->where($this->table . '.created_at', 'LIKE', "%$time%")
      ->get()
      ->toArray();

    $data = (array)$result[0];
    $data["total_point"] = is_null($data["total_point"]) ? 0 : $data["total_point"];
    return $data;
  }

  public function getSummaryPaymentDaily($year, $month)
  {
    $result = DB::table($this->table)
      ->select(DB::raw('DATE(updated_at) as date'),
        DB::raw('SUM(point) as total_point,
          COUNT(DISTINCT user_id) as number_user_payment,
          COUNT(id) as number_payment'))
      ->where($this->table . '.status', APPLY)
      ->whereRaw('YEAR(updated_at) =' . $year . ' AND MONTH(updated_at)=' . $month)
      ->groupBy('date')
      ->get()
      ->toArray();

    return $result;
  }

  public function getSummaryPaymentWeekly($week_start, $week_end)
  {
    $result = DB::table($this->table)
      ->where($this->table . '.status', APPLY)
      ->whereRaw('WEEKOFYEAR(created_at)>=' . $week_start)
      ->whereRaw('WEEKOFYEAR(created_at)<=' . $week_end)
      ->select(DB::raw('WEEKOFYEAR(created_at) as week_of_year'),
        DB::raw('SUM(point) as total_point,
        COUNT(DISTINCT user_id) as number_user_payment,
        COUNT(id) as number_payment'))
      ->groupBy('week_of_year')
      ->get()
      ->toArray();

    return $result;
  }
}
