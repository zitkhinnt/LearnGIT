<?php

namespace Modules\Horserace\Entities;

use Illuminate\Database\Eloquent\Model as Model;
use Illuminate\Support\Facades\DB;

class TransactionGift
{
  protected $table = 'transaction_gift';

  public function insertTransactionGift($data)
  {
    $data['created_at'] = \Carbon\Carbon::now()->toDateTimeString();
    $data['updated_at'] = \Carbon\Carbon::now()->toDateTimeString();
    return DB::table($this->table)->insert($data);
  }

  public function getTransactionGift()
  {
    return DB::table($this->table)
      ->where($this->table . '.deleted_flg', DELETED_DISABLE)
      ->orderBy('id', 'DESC')
      ->get()
      ->toArray();
  }

  public function getSearchTransactionGift($input)
  {
    $result =  DB::table($this->table)
      ->where($this->table . '.deleted_flg', DELETED_DISABLE);

    if (!is_null($input['iSortCol_0']) && $input['iSortCol_0'] == 0) {
      $result->orderBy('id', $input['sSortDir_0']);
    }
    if (!is_null($input['iSortCol_0']) && $input['iSortCol_0'] == 1) {
      $result->orderBy('created_at', $input['sSortDir_0']);
    }
    if (!is_null($input['iSortCol_0']) && $input['iSortCol_0'] == 2) {
      $result->orderBy('user_id', $input['sSortDir_0']);
    }
    if (!is_null($input['iSortCol_0']) && $input['iSortCol_0'] == 3) {
      $result->orderBy('member_level', $input['sSortDir_0']);
    }
    if (!is_null($input['iSortCol_0']) && $input['iSortCol_0'] == 4) {
      $result->orderBy('point', $input['sSortDir_0']);
    }
    if (!is_null($input['iSortCol_0']) && $input['iSortCol_0'] == 5) {
      $result->orderBy('gift_name', $input['sSortDir_0']);
    }
    if (isset($input['key_search']) && !is_null($input['key_search']) && (strlen($input['key_search']) > 0)) {
      $result->where('id', 'like', '%' . $input['key_search'] . '%')
      ->orWhere('login_id', 'like', '%' . $input['key_search'] . '%')
      ->orWhere('gift_name', 'like', '%' . $input['key_search'] . '%')
      ->orWhere('point', 'like', '%' . $input['key_search'] . '%')
      ->orWhere('note', 'like', '%' . $input['key_search'] . '%')
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

  public function getTransactionGiftById($id)
  {
    return DB::table($this->table)->find($id);
  }

  public function updateTransactionGift($id, $data)
  {
    $data['updated_at'] = \Carbon\Carbon::now()->toDateTimeString();
    DB::table($this->table)
      ->where('id', $id)
      ->update($data);
  }

  public function deleteTransactionGift($id)
  {
    $data['deleted_flg'] = DELETED_ENABLE;
    DB::table($this->table)
      ->where('id', $id)
      ->update($data);
  }

  public function getTransactionGiftByUserId($user_id)
  {
    return DB::table($this->table)
      ->where($this->table . '.user_id', $user_id)
      ->where($this->table . '.status', APPLY)
      ->where($this->table . '.deleted_flg', DELETED_DISABLE)
      ->orderBy('updated_at', 'DESC')
      ->get()
      ->toArray();
  }

  public function haveSendGift($user_id, $gift_id)
  {
    $result = DB::table($this->table)
      ->where($this->table . '.user_id', $user_id)
      ->where($this->table . '.gift_id', $gift_id)
      ->where($this->table . '.deleted_flg', DELETED_DISABLE)
      ->first();

    return is_null($result) ? false : true;
  }

  public function getTransBonusSend()
  {
    $result = DB::table($this->table)
      ->where($this->table . '.type', TRANSACTION_GIFT_TYPE_BONUS)
      ->where($this->table . '.send_mail', SEND_MAIL_NOT)
      ->where($this->table . '.deleted_flg', DELETED_DISABLE)
      ->get()
      ->toArray();

    return $result;
  }

  public function getSummaryGiftDaily($year, $month)
  {
    $result = DB::table($this->table)
      ->select(DB::raw('DATE(updated_at) as date'),
        DB::raw('SUM(point) as total_point,
          COUNT(DISTINCT user_id) as number_user_gift,
          COUNT(id) as number_gift'))
      ->where($this->table . '.status', APPLY)
      ->whereRaw('YEAR(updated_at) =' . $year . ' AND MONTH(updated_at)=' . $month)
      ->groupBy('date')
      ->get()
      ->toArray();

    return $result;
  }

  public function getSummaryGiftWeekly($week_start, $week_end)
  {
    $result = DB::table($this->table)
      ->where($this->table . '.status', APPLY)
      ->whereRaw('WEEKOFYEAR(created_at)>=' . $week_start)
      ->whereRaw('WEEKOFYEAR(created_at)<=' . $week_end)
      ->select(DB::raw('WEEKOFYEAR(created_at) as week_of_year'),
        DB::raw('SUM(point) as total_point,
        COUNT(DISTINCT user_id) as number_user_gift,
        COUNT(id) as number_gift'))
      ->groupBy('week_of_year')
      ->get()
      ->toArray();

    return $result;
  }
}
