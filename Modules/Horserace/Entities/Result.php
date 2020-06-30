<?php

namespace Modules\Horserace\Entities;

use Illuminate\Database\Eloquent\Model as Model;
use Illuminate\Support\Facades\DB;

class Result extends Model
{
  protected $table = 'result';

  protected $fillable = [
    'id',
    'title',
    'content',
    'deleted_flg',
  ];

  public function insertResult($data)
  {
    $data['created_at'] = \Carbon\Carbon::now()->toDateTimeString();
    $data['updated_at'] = \Carbon\Carbon::now()->toDateTimeString();
    return DB::table($this->table)->insert($data);
  }

  public function getResult()
  {
    return DB::table($this->table)
      ->where($this->table . '.deleted_flg', 0)
      ->orderBy('created_at', 'DESC')
      ->get()
      ->toArray();
  }

  public function getResultPublic($page, $limit)
  {
    $offset = $page * $limit;

    $result_temp = DB::table($this->table)
      ->where($this->table . '.deleted_flg', 0)
      ->orderBy('created_at', 'DESC');
     
    $result['total'] = $result_temp->count();

    $result['items'] = $result_temp->orderBy('created_at', 'DESC')
      ->limit($limit)
      ->offset($offset)
      ->get()
      ->toArray();

    foreach ($result['items'] as $key => $item) {
      $result['items'][$key] = (array)$item;
    }

    $result['perPage'] = $limit;
    $result['lastPage'] = (int)ceil($result['total'] / $result['perPage']) - 1;
    $result['currentPage'] = $page;

    return $result;
  }

  public function getResultById($id)
  {
    return DB::table($this->table)
      ->where($this->table . '.deleted_flg', 0)
      ->find($id);
  }

  public function getSearchResult($input)
  {
    $result = DB::table($this->table)
      ->where($this->table . '.deleted_flg', 0);

    if (!is_null($input['iSortCol_0']) && $input['iSortCol_0'] == 0) {
      $result->orderBy('id', $input['sSortDir_0']);
    }
    if (!is_null($input['iSortCol_0']) && $input['iSortCol_0'] == 1) {
      $result->orderBy('course_text', $input['sSortDir_0']);
    }
    if (!is_null($input['iSortCol_0']) && $input['iSortCol_0'] == 2) {
      $result->orderBy('double', $input['sSortDir_0']);
    }
    if (!is_null($input['iSortCol_0']) && $input['iSortCol_0'] == 3) {
      $result->orderBy('race_no_1_title', $input['sSortDir_0']);
    }
    if (!is_null($input['iSortCol_0']) && $input['iSortCol_0'] == 4) {
      $result->orderBy('race_no_2_title', $input['sSortDir_0']);
    }
    if (!is_null($input['iSortCol_0']) && $input['iSortCol_0'] == 5) {
      $result->orderBy('korogashi', $input['sSortDir_0']);
    }

    if (!is_null($input['iSortCol_0']) && $input['iSortCol_0'] == 6) {
      $result->orderBy('ticket_type', $input['sSortDir_0']);
    }
    if (!is_null($input['iSortCol_0']) && $input['iSortCol_0'] == 7) {
      $result->orderBy('bike_number_1', $input['sSortDir_0']);
    }
    if (!is_null($input['iSortCol_0']) && $input['iSortCol_0'] == 8) {
      $result->orderBy('won_man', $input['sSortDir_0']);
    }
    if (!is_null($input['iSortCol_0']) && $input['iSortCol_0'] == 9) {
      $result->orderBy('date', $input['sSortDir_0']);
    }

    if (isset($input['key_search']) && !is_null($input['key_search']) && (strlen($input['key_search']) > 0)) {
      $result->where('id', 'like', '%' . $input['key_search'] . '%')
      ->orWhere('course_text', 'like', '%' . $input['key_search'] . '%')
      ->orWhere('race_no_1_title', 'like', '%' . $input['key_search'] . '%')
      ->orWhere('race_no_2_num', 'like', '%' . $input['key_search'] . '%')
      ->orWhere('date', 'like', '%' . $input['key_search'] . '%')
      ->orWhere('won_man', 'like', '%' . $input['key_search'] . '%')
      ->orWhere('won_yen', 'like', '%' . $input['key_search'] . '%')
      ->orWhere('created_at', 'like', '%' . $input['key_search'] . '%');
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

  public function updateResult($id, $data)
  {
    $data['updated_at'] = \Carbon\Carbon::now()->toDateTimeString();
    DB::table($this->table)
      ->where('id', $id)
      ->update($data);
  }

  public function deleteResult($id)
  {
    $data['deleted_flg'] = 1;
    DB::table($this->table)
      ->where('id', $id)
      ->update($data);
  }
}
