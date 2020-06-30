<?php

namespace Modules\Horserace\Entities;

use Illuminate\Database\Eloquent\Model as Model;
use Illuminate\Support\Facades\DB;

class TransactionDeposit
{
  protected $table = 'transaction_deposit';

  public function insertTransactionDeposit($data)
  {
    $data['created_at'] = \Carbon\Carbon::now()->toDateTimeString();
    $data['updated_at'] = \Carbon\Carbon::now()->toDateTimeString();
    return DB::table($this->table)->insert($data);
  }

  public function insertTransactionDepositGetId($data)
  {
    $data['created_at'] = \Carbon\Carbon::now()->toDateTimeString();
    $data['updated_at'] = \Carbon\Carbon::now()->toDateTimeString();
    return DB::table($this->table)->insertGetId($data);
  }

  public function getTransactionDeposit()
  {
    return DB::table($this->table)
      ->where($this->table . '.deleted_flg', DELETED_DISABLE)
      ->orderBy('id', 'DESC')
      ->get()
      ->toArray();
  }

  public function getSearchTransactionDeposit($input)
  {
    $result =  DB::table($this->table)
      ->where($this->table . '.deleted_flg', DELETED_DISABLE);

    if (!is_null($input['iSortCol_0']) && $input['iSortCol_0'] == 0) {
      $result->orderBy('id', $input['sSortDir_0']);
    }
    if (!is_null($input['iSortCol_0']) && $input['iSortCol_0'] == 1) {
      $result->orderBy('id', $input['sSortDir_0']);
    }
    if (!is_null($input['iSortCol_0']) && $input['iSortCol_0'] == 2) {
      $result->orderBy('created_at', $input['sSortDir_0']);
    }
    if (!is_null($input['iSortCol_0']) && $input['iSortCol_0'] == 3) {
      $result->orderBy('payment_at', $input['sSortDir_0']);
    }
    if (!is_null($input['iSortCol_0']) && $input['iSortCol_0'] == 4) {
      $result->orderBy('user_id', $input['sSortDir_0']);
    }
    if (!is_null($input['iSortCol_0']) && $input['iSortCol_0'] == 5) {
      $result->orderBy('point', $input['sSortDir_0']);
    }
    if (!is_null($input['iSortCol_0']) && $input['iSortCol_0'] == 6) {
      $result->orderBy('amount', $input['sSortDir_0']);
    }
    if (!is_null($input['iSortCol_0']) && $input['iSortCol_0'] == 7) {
      $result->orderBy('amount_pay', $input['sSortDir_0']);
    }
    if (!is_null($input['iSortCol_0']) && $input['iSortCol_0'] == 8) {
      $result->orderBy('method', $input['sSortDir_0']);
    }
    if (!is_null($input['iSortCol_0']) && $input['iSortCol_0'] == 9) {
      $result->orderBy('status', $input['sSortDir_0']);
    }
    if (!is_null($input['iSortCol_0']) && $input['iSortCol_0'] == 10) {
      $result->orderBy('member_level', $input['sSortDir_0']);
    }
    if (!is_null($input['iSortCol_0']) && $input['iSortCol_0'] == 11) {
      $result->orderBy('note', $input['sSortDir_0']);
    }

    if (isset($input['key_search']) && !is_null($input['key_search']) && (strlen($input['key_search']) > 0)) {

      $result->where('id', 'like', '%' . $input['key_search'] . '%')
        ->orWhere('login_id', 'like', '%' . $input['key_search'] . '%')
        ->orWhere('method', 'like', '%' . $input['key_search'] . '%')
        ->orWhere('point', 'like', '%' . $input['key_search'] . '%')
        ->orWhere('amount', 'like', '%' . $input['key_search'] . '%')
        ->orWhere('note', 'like', '%' . $input['key_search'] . '%')
        ->orWhere('payment_at', 'like', '%' . $input['key_search'] . '%')
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

  public function getTransactionDepositById($id)
  {
    return DB::table($this->table)->find($id);
  }

  public function updateTransactionDeposit($id, $data)
  {
    $data['updated_at'] = \Carbon\Carbon::now()->toDateTimeString();
    DB::table($this->table)
      ->where('id', $id)
      ->update($data);
  }

  public function getTransactionDepositByUserId($user_id)
  {
    return DB::table($this->table)
      ->where($this->table . '.user_id', $user_id)
      ->where($this->table . '.deleted_flg', DELETED_DISABLE)
      ->orderBy('updated_at', 'DESC')
      ->get()
      ->toArray();
  }

  public function deleteTransactionDeposit($id)
  {
    $data['deleted_flg'] = DELETED_ENABLE;
    DB::table($this->table)
      ->where('id', $id)
      ->update($data);
  }

  public function getSendMailDeposit($number_mail_deposit)
  {
    return DB::table($this->table)
      ->where($this->table . '.status', APPLY)
      ->where($this->table . '.send_mail', '<', $number_mail_deposit)
      ->where($this->table . '.deleted_flg', DELETED_DISABLE)
      ->get()
      ->toArray();
  }

  public function addSendMailDeposit($tran_id, $mail_id)
  {
    $result = DB::table($this->table)->find($tran_id);
    $mail_deposit = json_decode($result->mail_deposit, true);
    $mail_deposit[$mail_id] = $mail_id;

    $arr_deposit = [
      "send_mail" => (integer)$result->send_mail + 1,
      "mail_deposit" => json_encode($mail_deposit)
    ];
    $this->updateTransactionDeposit($tran_id, $arr_deposit);
  }

  public function depositToday($time)
  {
    $result = DB::table($this->table)
      ->select(DB::raw('SUM(point) as total_point,
      SUM(amount_pay) as total_amount'))
      ->where($this->table . '.status', APPLY)
      // ->where($this->table . '.updated_at', 'LIKE', "%$time%")
      ->where($this->table . '.deleted_flg', DELETED_DISABLE)
      ->get()
      ->toArray();

    $data = (array)$result[0];
    $data["total_point"] = is_null($data["total_point"]) ? 0 : $data["total_point"];
    $data["total_amount"] = is_null($data["total_amount"]) ? 0 : $data["total_amount"];

    return $data;
  }

  public function reportTransactionDepositByDayInMonth($year, $month, $input)
  {
    $result = DB::table($this->table)
      ->where($this->table . '.status', APPLY)
      ->where($this->table . '.deleted_flg', DELETED_DISABLE)
      ->whereRaw('YEAR(updated_at) =' . $year . ' AND MONTH(updated_at)=' . $month);

    if (isset($input['method']) && strlen($input['method']) > 0) {
      $result->where($this->table . '.method', (integer)$input['method']);
    }

    $result = $result->select(DB::raw('DATE(updated_at) as date'),
      DB::raw('SUM(amount_pay) as total_amount,
        SUM(point) as total_point,
        COUNT(DISTINCT user_id) as number_user_deposit,
        COUNT(id) as number_deposit'))
      ->groupBy('date')
      ->get()
      ->toArray();

    return $result;
  }

  public function reportTransactionDepositByWeek($week_start, $week_end, $input)
  {
    $result = DB::table($this->table)
      ->where($this->table . '.status', APPLY)
      ->where($this->table . '.deleted_flg', DELETED_DISABLE)
      ->whereNotNull($this->table . '.payment_at')
      ->whereRaw('WEEKOFYEAR(payment_at)>=' . $week_start)
      ->whereRaw('WEEKOFYEAR(payment_at)<=' . $week_end);

    if (isset($input['method']) && strlen($input['method']) > 0) {
      $result->where($this->table . '.method', (integer)$input['method']);
    }

    $result = $result->select(DB::raw('WEEKOFYEAR(payment_at) as week_of_year'),
      DB::raw('SUM(amount_pay) as total_amount, 
        SUM(point) as total_point,
        COUNT(DISTINCT user_id) as number_user_deposit,
        COUNT(id) as number_deposit'))
      ->groupBy('week_of_year')
      ->get()
      ->toArray();

    return $result;
  }


  public function summaryDepositByYear($year)
  {
    $result = DB::table($this->table)
      ->whereNotNull($this->table . '.payment_at')
      ->where('status', APPLY)
      ->whereRaw('YEAR(payment_at) =' . $year)
      ->where($this->table . '.deleted_flg', DELETED_DISABLE)
      ->get()
      ->toArray();

    return $result;
  }

  public function reportTransDepositByDayInMonthByMediaCode($year, $month, $media_code)
  {
    $result = DB::table("users")
      ->join('transaction_deposit as td', 'users.id', '=', 'td.user_id')
      ->where('td.status', APPLY)
      ->where('users.media_code', $media_code)
      ->where('td.deleted_flg', DELETED_DISABLE)
      ->whereRaw('YEAR(td.created_at) =' . $year . ' AND MONTH(td.created_at)=' . $month);

    $result = $result->select(DB::raw('SUM(td.amount_pay) as total_amount,
        SUM(td.point) as total_point'))
      ->get()
      ->toArray();

    return $result[0];
  }

  public function reportTransDepositByMediaCodePeriod($time_start, $time_end, $media_code)
  {
    $result = DB::table("users")
      ->join('transaction_deposit as td', 'users.id', '=', 'td.user_id')
      ->where('td.deleted_flg', DELETED_DISABLE)
      ->where('td.status', APPLY)
      ->where('users.media_code', $media_code)
      ->where('td.created_at', '>=', $time_start)
      ->where('td.created_at', '<=', $time_end);

    $result = $result->select(DB::raw('SUM(td.amount_pay) as total_amount,
        SUM(td.point) as total_point'))
      ->get()
      ->toArray();

    return $result[0];
  }

  public function reportTransDepositTotalByMediaCode($media_code)
  {
    $result = DB::table("users")
      ->join('transaction_deposit as td', 'users.id', '=', 'td.user_id')
      ->where('td.deleted_flg', DELETED_DISABLE)
      ->where('td.status', APPLY)
      ->where('users.media_code', $media_code);

    $result = $result->select(DB::raw('SUM(td.amount_pay) as total_amount,
        SUM(td.point) as total_point'))
      ->get()
      ->toArray();

    return $result[0];
  }

  public function summaryNewPaymentUserByDate($year, $month)
  {
    return DB::table($this->table)
      ->select(DB::raw('DATE(transaction_deposit.updated_at) as date, COUNT(transaction_deposit.updated_at) as number_user_new_deposit'))
      ->join(DB::raw('(SELECT id, user_id, MIN(updated_at)
                FROM transaction_deposit
                WHERE deleted_flg = ' . DELETED_DISABLE . ' AND status = ' . APPLY . '
                GROUP BY user_id) as td'), 'transaction_deposit.id', '=', 'td.id')
      ->where('transaction_deposit.deleted_flg', DELETED_DISABLE)
      ->where('transaction_deposit.status', APPLY)
      ->whereRaw('YEAR(transaction_deposit.updated_at) =' . $year . ' AND MONTH(transaction_deposit.updated_at)=' . $month)
      ->groupBy('date')
      ->get()
      ->toArray();
  }


}
