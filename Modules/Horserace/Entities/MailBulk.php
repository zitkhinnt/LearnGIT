<?php

namespace Modules\Horserace\Entities;

use Illuminate\Database\Eloquent\Model as Model;
use Illuminate\Support\Facades\DB;

class MailBulk
{
  protected $table = 'mail_bulk';

  public function insertMailBulk($data)
  {
    $data['created_at'] = \Carbon\Carbon::now()->toDateTimeString();
    $data['updated_at'] = \Carbon\Carbon::now()->toDateTimeString();
    return DB::table($this->table)->insert($data);
  }

  public function getMailBulk()
  {
    return DB::table($this->table)
      ->where($this->table . '.deleted_flg', DELETED_DISABLE)
      ->orderBy('id', 'DESC')
      ->get()
      ->toArray();
  }

  public function getSearchMailBulk($input)
  {
    $result =  DB::table($this->table)
      ->where($this->table . '.deleted_flg', DELETED_DISABLE);

    if (!is_null($input['iSortCol_0']) && $input['iSortCol_0'] == 0) {
      $result->orderBy('id', $input['sSortDir_0']);
    }
    if (!is_null($input['iSortCol_0']) && $input['iSortCol_0'] == 1) {
      $result->orderBy('reserve_datetime', $input['sSortDir_0']);
    }
    if (!is_null($input['iSortCol_0']) && $input['iSortCol_0'] == 2) {
      $result->orderBy('send_datetime', $input['sSortDir_0']);
    }
    if (!is_null($input['iSortCol_0']) && $input['iSortCol_0'] == 3) {
      $result->orderBy('mail_title', $input['sSortDir_0']);
    }
    if (!is_null($input['iSortCol_0']) && $input['iSortCol_0'] == 4) {
      $result->orderBy('total_user', $input['sSortDir_0']);
    }
    if (!is_null($input['iSortCol_0']) && $input['iSortCol_0'] == 5) {
      $result->orderBy('total_user', $input['sSortDir_0']);
    }
    if (!is_null($input['iSortCol_0']) && $input['iSortCol_0'] == 10) {
      $result->orderBy('status', $input['sSortDir_0']);
    }
    if (isset($input['key_search']) && !is_null($input['key_search']) && (strlen($input['key_search']) > 0)) {
      $result->where('id', 'like', '%' . $input['key_search'] . '%')
      ->orWhere('mail_title', 'like', '%' . $input['key_search'] . '%')
      ->orWhere('total_user', 'like', '%' . $input['key_search'] . '%')
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

  public function getMailBulkById($id)
  {
    return DB::table($this->table)->find($id);
  }

  public function updateMailBulk($id, $data)
  {
    $data['updated_at'] = \Carbon\Carbon::now()->toDateTimeString();
    DB::table($this->table)
      ->where('id', $id)
      ->update($data);
  }

  public function deleteMailBulk($id)
  {
    $data['deleted_flg'] = DELETED_ENABLE;
    DB::table($this->table)
      ->where('id', $id)
      ->update($data);
  }

  public function getMailBulkSendToday()
  {
    $now = \Carbon\Carbon::now();
    $result = DB::table($this->table)
      ->where($this->table . '.deleted_flg', DELETED_DISABLE)
      ->where($this->table . '.reserve_datetime', '<=', $now)
      ->where($this->table . '.status', MAIL_BULK_STATUS_NOT_SEND)
      ->get()
      ->toArray();

    return $result;
  }

  public function getLastMailBulk()
  {
    $result = DB::table($this->table)
      ->where($this->table . '.deleted_flg', DELETED_DISABLE)
      ->where($this->table . '.status', MAIL_BULK_STATUS_SENDING)
      ->orderBy('created_at', 'desc')->first();

    return $result;
  }

  public function searchMailBulkByCondition($input, $page, $limit)
  { 
    $result=[];
    $result = DB::table($this->table)          
          ->select("mail_bulk.mail_from_address","mail_bulk.mail_from_name","mail_bulk.mail_title","mail_bulk.mail_body", "send_datetime AS created_at", "send_datetime AS admin_read_at" )
          ->where('mail_bulk.deleted_flg', DELETED_DISABLE)
          ->where('mail_bulk.status', MAIL_BULK_STATUS_DONE);

          // start_date
          if (isset($input['start_date']) && !is_null($input['start_date']) && (strlen($input['start_date']) > 0))
          {
            $result->where('mail_bulk.send_datetime', '>=', $input['start_date']);
          }
          // start_end
          if (isset($input['start_end']) && !is_null($input['start_end']) && (strlen($input['start_end']) > 0))
          {
            $result->where('mail_bulk.send_datetime', '<=', $input['start_end']. " 23:59:59"); 
          }
          // user Id
          if (isset($input['user_id']) && !is_null($input['user_id']) && (strlen($input['user_id']) > 0))
          {
            $user_id = $input['user_id'];
            $result->where(function($q) use ($user_id)
            {
                $q->where('mail_bulk.list_user', 'like', '%:'. $user_id.',%')
                ->orWhere('mail_bulk.list_user', 'like', '%:'. $user_id.'}%');
            });
          }
         
          // order 
          if (isset($input["order"])) {
            switch ($input["order"]) {
              case "created_at_asc":
                $result->orderBy('mail_bulk.send_datetime', 'ASC');
                break;
              case "created_at_desc":
                $result->orderBy('mail_bulk.send_datetime', 'DESC');
                break;
            }
          } else {
            $result->orderBy('mail_bulk.send_datetime', 'DESC');
          }

          $offset = $page * $limit;

          $result = $result->limit($limit)->offset($offset)->get()->toArray();
    
    return $result;
  }  
}
