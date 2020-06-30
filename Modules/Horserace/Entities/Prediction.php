<?php

namespace Modules\Horserace\Entities;

use Illuminate\Support\Facades\DB;

class Prediction
{
    protected $table = 'prediction';

    public function insertPrediction($data)
    {
        $data['created_at'] = \Carbon\Carbon::now()->toDateTimeString();
        $data['updated_at'] = \Carbon\Carbon::now()->toDateTimeString();
        return DB::table($this->table)->insert($data);
    }

    public function getPrediction()
    {
        return DB::table($this->table)
            ->where($this->table . '.deleted_flg', DELETED_DISABLE)
            ->orderBy('id', 'DESC')
            ->get()
            ->toArray();
    }

    public function getAllActivePredictionsWithType()
    {
        return DB::table($this->table)
            ->select($this->table . '.*', 'prediction_type.name as prediction_type_name')
            ->join('prediction_type', 'prediction_type.id',$this->table . '.prediction_type')
            ->where($this->table . '.deleted_flg', DELETED_DISABLE)
            ->orderBy($this->table . '.id', 'DESC')
            ->get()
            ->toArray();
    }

    public function getSearchAllActivePredictionsWithType($input)
    {
      $result =  DB::table($this->table)
        ->select($this->table . '.*', 'prediction_type.name as prediction_type_name')
        ->join('prediction_type', 'prediction_type.id', $this->table . '.prediction_type')
        ->where($this->table . '.deleted_flg', DELETED_DISABLE);
      // Search status
      if (isset($input['type_filter_1']) && !is_null($input['type_filter_1']) && (strlen($input['type_filter_1']) > 0)) {
        $result->where('prediction.status', $input['type_filter_1']);
      }
      // Search type
      if (isset($input['type_filter_2']) && !is_null($input['type_filter_2']) && (strlen($input['type_filter_2']) > 0)) {
        $result->where('prediction_type.name', 'like', "%{$input['type_filter_2']}%");
      }
      if (!is_null($input['iSortCol_0']) && $input['iSortCol_0'] == 0) {
        $result->orderBy('prediction.id', $input['sSortDir_0']);
      }
      if (!is_null($input['iSortCol_0']) && $input['iSortCol_0'] == 1) {
        $result->orderBy('prediction.id', $input['sSortDir_0']);
      }
      if (!is_null($input['iSortCol_0']) && $input['iSortCol_0'] == 2) {
        $result->orderBy('prediction.name', $input['sSortDir_0']);
      }
      if (!is_null($input['iSortCol_0']) && $input['iSortCol_0'] == 3) {
        $result->orderBy('prediction.default_point', $input['sSortDir_0']);
      }
      if (!is_null($input['iSortCol_0']) && $input['iSortCol_0'] == 4) {
        $result->orderBy('prediction_type.name', $input['sSortDir_0']);
      }
      if (!is_null($input['iSortCol_0']) && $input['iSortCol_0'] == 5) {
        $result->orderBy('prediction.status', $input['sSortDir_0']);
      }
      if (!is_null($input['iSortCol_0']) && $input['iSortCol_0'] == 6) {
        $result->orderBy('prediction.user_stage_id', $input['sSortDir_0']);
      }
      if (!is_null($input['iSortCol_0']) && $input['iSortCol_0'] == 7) {
        $result->orderBy('prediction.number_buyer', $input['sSortDir_0']);
      }
      // if (!is_null($input['iSortCol_0']) && $input['iSortCol_0'] == 8) {
      //   $result->orderBy('prediction.number_buyer', $input['sSortDir_0']);
      // }
      if (!is_null($input['iSortCol_0']) && $input['iSortCol_0'] == 8) {
        $result->orderBy('prediction.number_buyer', $input['sSortDir_0']);
      }
      if (!is_null($input['iSortCol_0']) && $input['iSortCol_0'] == 9) {
        $result->orderBy('prediction.number_access', $input['sSortDir_0']);
      }
      if (!is_null($input['iSortCol_0']) && $input['iSortCol_0'] == 10) {
        $result->orderBy('prediction.start_time', $input['sSortDir_0']);
      }
      if (!is_null($input['iSortCol_0']) && $input['iSortCol_0'] == 11) {
        $result->orderBy('prediction.id', $input['sSortDir_0']);
      }
      if (!is_null($input['iSortCol_0']) && $input['iSortCol_0'] == 12) {
        $result->orderBy('prediction.id', $input['sSortDir_0']);
      }
      if (isset($input['key_search']) && !is_null($input['key_search']) && (strlen($input['key_search']) > 0)) {
        $result->where('prediction.id', 'like', '%' . $input['key_search'] . '%')
          ->orWhere('prediction.name', 'like', '%' . $input['key_search'] . '%')
          ->orWhere('prediction.prediction_type', 'like', '%' . $input['key_search'] . '%')
          ->orWhere('prediction.member_level', 'like', '%' . $input['key_search'] . '%')
          ->orWhere('prediction.number_buyer', 'like', '%' . $input['key_search'] . '%')
          ->orWhere('prediction.number_access', 'like', '%' . $input['key_search'] . '%')
          ->orWhere('prediction.number_buyer', 'like', '%' . $input['key_search'] . '%');
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

    public function getPredictionById($id)
    {
        return DB::table($this->table)->find($id);
    }

    public function updatePrediction($id, $data)
    {
        $data['updated_at'] = \Carbon\Carbon::now()->toDateTimeString();
        DB::table($this->table)
            ->where('id', $id)
            ->update($data);
    }

    public function deletePrediction($id)
    {
        $data['deleted_flg'] = DELETED_ENABLE;
        DB::table($this->table)
            ->where('id', $id)
            ->update($data);
    }

    public function getPredictionResultSendMail()
    {
        $now = \Carbon\Carbon::now()->toDateTimeString();
        $result = DB::table($this->table)
            ->where($this->table . '.status', PREDICTION_STATUS_DONE)
            ->where($this->table . '.send_mail_done', SEND_MAIL_NOT)
            ->where($this->table . '.deleted_flg', DELETED_DISABLE)
            ->where($this->table . '.start_time', '<=', $now)
            ->where($this->table . '.end_time', '>=', $now)
            ->get()
            ->toArray();

        return $result;
    }

    public function getPredictionOpenSendMail()
    {
        $now = \Carbon\Carbon::now()->toDateTimeString();
        $result = DB::table($this->table)
            ->where($this->table . '.status', PREDICTION_STATUS_OPEN)
            ->where($this->table . '.send_mail_open', SEND_MAIL_NOT)
            ->where($this->table . '.deleted_flg', DELETED_DISABLE)
            ->where($this->table . '.start_time', '<=', $now)
            ->where($this->table . '.end_time', '>=', $now)
            ->get()
            ->toArray();

        return $result;
    }

    public function getPredictionPublicMemberLevel($member_level)
    {
        $now = \Carbon\Carbon::now()->toDateTimeString();
        $result = DB::table($this->table)
            ->where($this->table . '.member_level', $member_level)
            ->where($this->table . '.deleted_flg', DELETED_DISABLE)
            ->where($this->table . '.start_time', '<=', $now)
            ->where($this->table . '.end_time', '>=', $now)
            ->orderBy('display_order', 'ASC')
            ->get()
            ->toArray();

        return $result;
    }

    public function addAccessPrediction($prediction_id)
    {
        $result = DB::table($this->table)
            ->where($this->table . '.id', $prediction_id)
            ->where($this->table . '.deleted_flg', DELETED_DISABLE)
            ->first();

        $arr_access["number_access"] = (integer) $result->number_access + 1;
        $this->updatePrediction($result->id, $arr_access);
    }

    public function addBuyPrediction($prediction_id)
    {
        $result = DB::table($this->table)
            ->where($this->table . '.id', $prediction_id)
            ->where($this->table . '.deleted_flg', DELETED_DISABLE)
            ->first();

        $arr_access["number_buyer"] = (integer) $result->number_buyer + 1;
        $this->updatePrediction($result->id, $arr_access);
    }

    public function getPredictionOpenMemberLevel($member_level)
    {
        $now = \Carbon\Carbon::now()->toDateTimeString();
        $result = DB::table($this->table)
            ->where($this->table . '.member_level', $member_level)
            ->where($this->table . '.status', PREDICTION_STATUS_OPEN)
            ->where($this->table . '.deleted_flg', DELETED_DISABLE)
            ->where($this->table . '.start_time', '<=', $now)
            ->where($this->table . '.end_time', '>=', $now)
            ->orderBy('display_order', 'ASC')
            ->get()
            ->toArray();

        return $result;
    }

    public function getPredictionOpen()
    {
        $now = \Carbon\Carbon::now()->toDateTimeString();
        $result = DB::table($this->table)
            ->where($this->table . '.status', PREDICTION_STATUS_OPEN)
            ->where($this->table . '.deleted_flg', DELETED_DISABLE)
            ->where($this->table . '.start_time', '<=', $now)
            ->where($this->table . '.end_time', '>=', $now)
            ->orderBy('display_order', 'ASC')
            ->get()
            ->toArray();

        return $result;
    }

    public function getPredictionPublicPoint($point)
    {
        $now = \Carbon\Carbon::now()->toDateTimeString();
        $result = DB::table($this->table)
            ->where($this->table . '.default_point', $point)
            ->where($this->table . '.deleted_flg', DELETED_DISABLE)
            ->where($this->table . '.start_time', '<=', $now)
            ->where($this->table . '.end_time', '>=', $now)
            ->orderBy('display_order', 'ASC')
            ->get()
            ->toArray();

        return $result;
    }

    public function getPredictionPublicType($type_id)
    {
        $now = \Carbon\Carbon::now()->toDateTimeString();
        $result = DB::table($this->table)
            ->where($this->table . '.prediction_type', $type_id)
            ->where($this->table . '.deleted_flg', DELETED_DISABLE)
            ->where($this->table . '.start_time', '<=', $now)
            ->where($this->table . '.end_time', '>=', $now)
            ->orderBy('display_order', 'ASC')
            ->get()
            ->toArray();

        return $result;
    }

    public function updatePredictionStatus()
    {
      $result = DB::table($this->table)
        ->whereRaw('finish_recruit_time < NOW()')
        ->where('status', '!=', PREDICTION_STATUS_DONE)
        ->update(['status' => PREDICTION_STATUS_DONE]);

      return $result;
    }

   /* public function getPredictionByType($type_id)
    {
        return DB::table($this->table)
        ->where($this->table . '.prediction_type', $type_id)
        ->get()
        ->toArray();
    }*/

}
