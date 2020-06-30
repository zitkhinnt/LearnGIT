<?php

namespace Modules\Horserace\Entities;
///use Modules\Horserace\Entities\Prediction;

use Illuminate\Support\Facades\DB;

class User
{
    protected $table = 'users';

    public function insertUser($data)
    {
        if (isset($data['mail_pc'])) {
            // try to remove illegal from email string
            $data['mail_pc'] = filter_var($data['mail_pc'], FILTER_SANITIZE_EMAIL);
        }

        $data['interim_register_time'] = \Carbon\Carbon::now()->toDateTimeString();
        $data['created_at'] = \Carbon\Carbon::now()->toDateTimeString();
        $data['updated_at'] = \Carbon\Carbon::now()->toDateTimeString();
        return DB::table($this->table)->insertGetId($data);
    }

    public function getUser()
    {
        return DB::table($this->table)
            ->join('user_activity', 'users.id', '=', 'user_activity.user_id')
            ->where($this->table . '.deleted_flg', DELETED_DISABLE)
            ->orderBy('users.id', 'DESC')
            ->get()
            ->toArray();
    }
    public function getObjectUser()
    {
        return DB::table($this->table)
        ->join('user_activity', 'users.id', '=', 'user_activity.user_id')
        ->where($this->table . '.deleted_flg', DELETED_DISABLE)
        ->get();
    }

    public function getUserById($id)
    {
        return DB::table($this->table)->find($id);
    }


    public function getUserByLoginId($login_id)
    {
      dd($login_id);        
      khanh_log(print_r($this->login_id, true));        
        return DB::table($this->table)
            ->where($this->table . '.login_id', $login_id)
            ->where($this->table . '.deleted_flg', DELETED_DISABLE)
            ->first();
    }

    public function getUserByUserKey($user_key)
    {
        return DB::table($this->table)
            ->where($this->table . '.user_key', $user_key)
            ->where($this->table . '.deleted_flg', DELETED_DISABLE)
            ->first();
    }

    public function updateUser($id, $data)
    {
        if (isset($data['mail_pc'])) {
            // try to remove illegal from email string
            $data['mail_pc'] = filter_var($data['mail_pc'], FILTER_SANITIZE_EMAIL);
        }

        $data['updated_at'] = \Carbon\Carbon::now()->toDateTimeString();
        return DB::table($this->table)
            ->where('id', $id)
            ->update($data);
    }

    public function deleteUser($id)
    {
        $data['deleted_flg'] = DELETED_ENABLE;
        DB::table($this->table)
            ->where('id', $id)
            ->update($data);
    }

    public function deleteUserByMediaCode($media_code)
    {
        $data['deleted_flg'] = DELETED_ENABLE;
        DB::table($this->table)
            ->where('media_code', $media_code)
            ->update($data);
    }

    public function getDetailUserById($id)
    {
        return DB::table($this->table)
            ->join('user_activity', 'users.id', '=', 'user_activity.user_id')
            ->where($this->table . '.deleted_flg', DELETED_DISABLE)
            ->where($this->table . '.id', $id)
            ->first();
    }

    public function getUserNotSendMail($number_mail_register)
    {
        return DB::table($this->table)
            ->join('user_activity', 'users.id', '=', 'user_activity.user_id')
            ->whereNotNull('users.register_time')
            ->where($this->table . '.send_mail', '<', $number_mail_register)
            ->where($this->table . '.deleted_flg', DELETED_DISABLE)
            ->get()
            ->toArray();
    }

    public function getUserInterimSendMail($number_mail_interim)
    {
        return DB::table($this->table)
            ->join('user_activity', 'users.id', '=', 'user_activity.user_id')
            ->whereNull('users.register_time')
            ->where($this->table . '.send_mail_interim', '<', $number_mail_interim)
            ->where($this->table . '.deleted_flg', DELETED_DISABLE)
            ->get()
            ->toArray();
    }

    public function getSendMailPredictionResult($member_level)
    {
        return DB::table($this->table)
            ->where($this->table . '.member_level', '>=', $member_level)
            ->where($this->table . '.deleted_flg', DELETED_DISABLE)
            ->get()
            ->toArray();
    }

    public function getSendMailPredictionOpen($member_level)
    {
        return DB::table($this->table)
            ->where($this->table . '.member_level', '>=', $member_level)
            ->where($this->table . '.deleted_flg', DELETED_DISABLE)
            ->get()
            ->toArray();
    }

    public function getUserByMailPc($mail_pc)
    {
        return DB::table($this->table)
            ->where($this->table . '.mail_pc', 'like', "%{$mail_pc}%")
            ->where($this->table . '.deleted_flg', DELETED_DISABLE)
            ->first();
    }
    public function getUserByMailPcGoogle()
    {
        return DB::table($this->table)
            ->where($this->table . '.mail_pc', 'like', "%@gmail%")
            ->where($this->table . '.deleted_flg', DELETED_DISABLE)->get();
    }
    
    public function getUserByMailMobileGoogle()
    {
        return DB::table($this->table)
            ->where($this->table . '.mail_mobile', 'like', "%@gmail%")
            ->where($this->table . '.deleted_flg', DELETED_DISABLE)->get();
    }
    public function replaceMailGoogle($mail)
    {
	// dat comment: khong can phai sua mail, google tu hieu dau cham
        // $mail_name_before = substr($mail,0,strpos(strtolower($mail), strtolower('@gmail'))+1);
        // $mail_name_before_replace = str_replace('.','',$mail_name_before); 
        // $mail = str_replace($mail_name_before, $mail_name_before_replace, $mail);
        return $mail;
    }

    public function getUserByMailPcNew($mail_pc)
    {
        return DB::table($this->table)
            ->where($this->table . '.mail_pc', $mail_pc)
            ->where($this->table . '.deleted_flg', DELETED_DISABLE)
            ->first();
    }
    public function getUserByMailMobile($mail_mobile)
    {
        return DB::table($this->table)
            ->where($this->table . '.mail_mobile', $mail_mobile)
            ->where($this->table . '.deleted_flg', DELETED_DISABLE)
            ->first();
    }

    public function haveMailPc($mail_pc)
    {
        if (empty($mail_pc)) {
            return false;
        }

        $result = DB::table($this->table)
            ->where($this->table . '.mail_pc', '=', "%{$mail_pc}%")
            ->where($this->table . '.deleted_flg', DELETED_DISABLE)
            ->first();

        return is_null($result) ? false : true;
    }

    public function getUserSocial($provider_user_id)
    {
        return DB::table($this->table)
            ->where($this->table . '.provider_user_id', $provider_user_id)
            ->where($this->table . '.deleted_flg', DELETED_DISABLE)
            ->first();
    }

    public function countUser()
    {
        return DB::table($this->table)
            ->whereNotNull('users.register_time')
            ->where($this->table . '.deleted_flg', DELETED_DISABLE)
            ->count();
    }

    public function countUserByMediaCodeAndTime($year, $month, $media_code)
    {
        return DB::table($this->table)
            ->whereNotNull('users.register_time')
            ->whereRaw('YEAR(register_time) =' . $year . ' AND MONTH(register_time)=' . $month)
            ->where($this->table . '.media_code', 'like', "%{$media_code}%")
            //->where($this->table . '.deleted_flg', DELETED_DISABLE)
            ->count();
    }

    public function countUserByMediaCodePeriod($time_start, $time_end, $media_code)
    {
        return DB::table($this->table)
            ->whereNotNull('users.register_time')
            ->where('register_time', '>=', $time_start)
            ->where('register_time', '<=', $time_end)
            ->where($this->table . '.media_code', 'like', "%{$media_code}%")
            //->where($this->table . '.deleted_flg', DELETED_DISABLE)
            ->count();
    }

    public function countUserByMediaCodePeriodTime($time_start, $time_end, $media_code)
    {
        return DB::table($this->table)
            ->whereNotNull('users.register_time')
            ->where($this->table . '.created_at', '>=', $time_start)
            ->where($this->table . '.created_at', '<=', $time_end)
            ->where($this->table . '.media_code', 'like', "%{$media_code}%")
            //->where($this->table . '.deleted_flg', DELETED_DISABLE)
            ->count();
    }

    public function countUserInterimByMediaCodeAndTime($year, $month, $media_code)
    {
        return DB::table($this->table)
            ->whereNull('users.register_time')
            ->whereRaw('YEAR(created_at) =' . $year . ' AND MONTH(created_at)=' . $month)
            ->where($this->table . '.media_code', 'like', "%{$media_code}%")
            ->where($this->table . '.deleted_flg', DELETED_DISABLE)
            ->count();
    }

    public function countUserInterimByMediaCodePeriodTime($time_start, $time_end, $media_code)
    {
        return DB::table($this->table)
            ->whereNull('users.register_time')
            ->where($this->table . '.created_at', '>=', $time_start)
            ->where($this->table . '.created_at', '<=', $time_end)
            ->where($this->table . '.media_code', 'like', "%{$media_code}%")
            ->where($this->table . '.deleted_flg', DELETED_DISABLE)
            ->count();
    }

    public function countUserByMediaCodeDaily($year, $month, $media_code)
    {
        $result = DB::table($this->table)
            ->select(DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(id) as user_register'))
            ->whereNotNull('users.register_time')
            ->where('users.media_code', 'like', "%$media_code%")
            ->whereRaw('YEAR(created_at) =' . $year . ' AND MONTH(created_at)=' . $month)
            ->groupBy('date')
            ->get()
            ->toArray();

        return $result;
    }

    public function userByMediaCodeDaily($year, $month, $media_code)
    {
        $result = DB::table($this->table)
            ->select(DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(id) as user_register'))
            ->whereNotNull('users.register_time')
            ->where('users.media_code', $media_code)
            ->whereRaw('YEAR(created_at) =' . $year . ' AND MONTH(created_at)=' . $month)
            ->groupBy('date')
            ->get()
            ->toArray();

        return $result;
    }

    public function userInterimByMediaCodeDaily($year, $month, $media_code)
    {
        $result = DB::table($this->table)
            ->select(DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(id) as user_register'))
            ->whereNull('users.register_time')
            ->where('users.media_code', $media_code)
            ->whereRaw('YEAR(created_at) =' . $year . ' AND MONTH(created_at)=' . $month)
            ->groupBy('date')
            ->get()
            ->toArray();

        return $result;
    }

    public function countUserByEntrance($year, $month, $entrance_id)
    {
        return DB::table($this->table)
            ->whereNotNull('users.register_time')
            ->whereRaw('YEAR(created_at) =' . $year . ' AND MONTH(created_at)=' . $month)
            ->where($this->table . '.entrance_id', $entrance_id)
            ->where($this->table . '.deleted_flg', DELETED_DISABLE)
            ->count();
    }

    public function countUserInterimByEntrance($year, $month, $entrance_id)
    {
        return DB::table($this->table)
            ->whereNull('users.register_time')
            ->whereRaw('YEAR(created_at) =' . $year . ' AND MONTH(created_at)=' . $month)
            ->where($this->table . '.entrance_id', $entrance_id)
            ->where($this->table . '.deleted_flg', DELETED_DISABLE)
            ->count();
    }

    public function userByEntranceDetailDaily($year, $month, $entrance_id)
    {
        $result = DB::table($this->table)
            ->select(DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(id) as user_register'))
            ->whereNotNull('users.register_time')
            ->where('users.entrance_id', $entrance_id)
            ->whereRaw('YEAR(created_at) =' . $year . ' AND MONTH(created_at)=' . $month)
            ->groupBy('date')
            ->get()
            ->toArray();

        return $result;
    }

    public function userInterimByEntranceDetailDaily($year, $month, $entrance_id)
    {
        $result = DB::table($this->table)
            ->select(DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(id) as user_register'))
            ->whereNull('users.register_time')
            ->where('users.entrance_id', $entrance_id)
            ->whereRaw('YEAR(created_at) =' . $year . ' AND MONTH(created_at)=' . $month)
            ->groupBy('date')
            ->get()
            ->toArray();

        return $result;
    }

    public function countUserByUserStage($user_stage_id)
    {
        return DB::table($this->table)
            ->whereRaw("FIND_IN_SET('" . $user_stage_id . "'," . $this->table . ".user_stage_id)")
            ->where($this->table . '.deleted_flg', DELETED_DISABLE)
            ->whereNotNull('users.register_time')
            ->count();
    }

    public function countUserRegisterTime($year, $month)
    {
        return DB::table($this->table)
            ->whereNotNull('users.register_time')
            ->whereRaw('YEAR(created_at) =' . $year . ' AND MONTH(created_at)=' . $month)
            ->where($this->table . '.deleted_flg', DELETED_DISABLE)
            ->count();
    }

    public function addSendMailRegister($user_id, $mail_id)
    {
        $result = DB::table($this->table)->find($user_id);
        $mail_register = json_decode($result->mail_register, true);
        $mail_register[$mail_id] = $mail_id;

        $arr_user = [
            "send_mail" => (integer) $result->send_mail + 1,
            "mail_register" => json_encode($mail_register),
        ];
        $this->updateUser($user_id, $arr_user);
    }

    public function addSendMailInterim($user_id, $mail_id)
    {
        $result = DB::table($this->table)->find($user_id);
        $mail_interim = json_decode($result->mail_interim, true);
        $mail_interim[$mail_id] = $mail_id;

        $arr_user = [
            "send_mail_interim" => (integer) $result->send_mail_interim + 1,
            "mail_interim" => json_encode($mail_interim),
        ];
        $this->updateUser($user_id, $arr_user);
    }

    public function searchUserByCondition($input)
    {
        $result = DB::table($this->table)
            ->select("ua.*", "users.*")
            ->leftJoin('user_activity as ua', 'ua.user_id', '=', 'users.id')
            ->where('users.deleted_flg', DELETED_DISABLE);
        
       /* $obj_prediction = new Prediction();
        $list_prediction_by_type = $obj_prediction->getPredictionByType($input['prediction_type']);
        $list_prediction_id= array();
        foreach($list_prediction_by_type as $pr)
        array_push($list_prediction_id,$pr->id);*/
       
   
        

        // User have buy prediction
        if (isset($input['prediction_type']) && !is_null($input['prediction_type']) && (strlen($input['prediction_type']) > 0)) {
            $result->leftJoin('transaction_payment as tp', 'tp.user_id', '=', 'users.id')->Join('prediction as pr','tp.prediction_id','=','pr.id')
                ->addSelect('tp.point as trans_point', 'tp.prediction_id as prediction_id',
                    'tp.prediction_name as prediction_name', 'pr.prediction_type as prediction_type')
                ->where('pr.prediction_type', $input['prediction_type']);
             
             
        }

        // User have buy prediction with condition search
        if (isset($input['prediction_id']) && !is_null($input['prediction_id']) && (strlen($input['prediction_id']) > 0)) {
            $result->leftJoin('user_access_prediction as uap', 'uap.user_id', '=', 'users.id')
                ->addSelect('uap.number_access as number_access', 'uap.buy as buy', 'uap.access_result as access_result')
                ->where('uap.prediction_id', $input['prediction_id']);

            switch ($input['buy_prediction']) {
                case USER_BUY_PREDICTION_SUCCESS:
                    $result->where('uap.buy', BUY_PREDICTION);
                    break;

                case USER_BUY_PREDICTION_ERROR:
                    $result->where('uap.buy', BUY_PREDICTION_ERROR);
                    break;

                case USER_ACCESS_RESULT_SUCCESS:
                    $result->where('uap.access_result', ACCESS_RESULT_SEE);
                    break;

                case USER_ACCESS_RESULT_NOT:
                    $result->where('uap.access_result', ACCESS_RESULT_NOT_SEE);
                    break;

                default:
                    break;
            }
        }

        // User Key
        if (isset($input['user_key']) && !is_null($input['user_key']) && (strlen($input['user_key']) > 0)) {
            $result->where('users.user_key', 'like', "%{$input['user_key']}%");
        }
        // Login Id
        if (isset($input['login_id']) && !is_null($input['login_id']) && (strlen($input['login_id']) > 0)) {
            $result->where('users.login_id', 'like', "%{$input['login_id']}%");           
        }
        // nickname
        if (isset($input['nickname']) && !is_null($input['nickname']) && (strlen($input['nickname']) > 0)) {
            $result->where('users.nickname', 'like', "%{$input['nickname']}%");
        }
        // member_level
        if (isset($input['member_level']) && !is_null($input['member_level']) && (strlen($input['member_level']) > 0)) {
            $result->where('users.member_level', 'like', "%{$input['member_level']}%");
          
        }
        /*else
        {
            $result->where('users.member_level', '!=', MEMBER_LEVEL_EXCEPT);              
        }*/

        // stop_mail        
        if (isset($input['stop_mail']) && !is_null($input['stop_mail']) && (strlen($input['stop_mail']) > 0)) {
            $result->where('users.stop_mail', '=', $input['stop_mail']);
        }
        /*else
        {
            $result->where('users.stop_mail', '=', STOP_MAIL_DISABLE);
        }*/

        // mail_pc
        if (isset($input['mail_pc']) && !is_null($input['mail_pc']) && (strlen($input['mail_pc']) > 0))
        {
            if(strpos(strtolower(trim($input['mail_pc'])), strtolower('@gmail'))!==FALSE)
            {
                $mail_pc = $input['mail_pc'];
                $mail_pc_rep = $this->replaceMailGoogle($mail_pc);
                $result->where(function($q) use ($mail_pc, $mail_pc_rep)
                {
                    $q->where('users.mail_pc', 'like', "%{$mail_pc}%")
                    ->orWhere('users.mail_pc', 'like', "%{$mail_pc_rep}%");
                });
            }
            else
            {
                $result->where('users.mail_pc', 'like', "%{$input['mail_pc']}%");
            }
    
        }        
        // mail_mobile
        if (isset($input['mail_mobile']) && !is_null($input['mail_mobile']) && (strlen($input['mail_mobile']) > 0)) {
            $result->where('users.mail_mobile', 'like', "%{$input['mail_mobile']}%");
        }
        // Age
        if (isset($input['age']) && !is_null($input['age']) && (strlen($input['age']) > 0)) {
            $result->where('users.age', 'like', "%{$input['age']}%");
        }
        // Gender
        if (isset($input['gender']) && !is_null($input['gender'])) {
            $first = current($input['gender']);
            $arr_gender = $input['gender'];
            // Or where
            $result->where(function ($result) use ($arr_gender, $first) {
                $result->where('users.gender', $first);
                // Or where user stage
                foreach ($arr_gender as $gender) {
                    $result = $result->orWhere('users.gender', $gender);
                }
                return $result;
            });
        }

        // media code
        if (isset($input['media_code']) && !is_null($input['media_code']) && (strlen($input['media_code']) > 0)) {
            $result->where('users.media_code', 'like', "%{$input['media_code']}%");
        }

        // User stage           
        if (isset($input['user_stage_id']) && !is_null($input['user_stage_id']) && is_array($input['user_stage_id'])) {
          $list_search_user_stage_include = [];
          $list_search_user_stage_exclude = [];
          foreach ($input['user_stage_id'] as $key => $value) {
            $string_check_stage = explode('-', $value);
            if (isset($string_check_stage[1])) {
              if ($string_check_stage[1] == 1) {
                array_push($list_search_user_stage_include, $string_check_stage[0]);
              }
              if ($string_check_stage[1] == 0) {
                array_push($list_search_user_stage_exclude, $string_check_stage[0]);
              }
            }
          }

          if ($input['search_match_type'] == USER_STAGE_MATCH_ALL) {
            if (count($list_search_user_stage_exclude) > 0) {
              if ($list_search_user_stage_exclude[0] != '0') {
                $string_sql_search_user_stage = '';
                $string_sql_search_user_stage .= '(NOT FIND_IN_SET(' . $list_search_user_stage_exclude[0] . ',users.user_stage_id)';

                for ($i = 1; $i < count($list_search_user_stage_exclude); $i++) {
                  // stage exclusion
                  if ($list_search_user_stage_exclude[$i] != '0') {
                    $string_sql_search_user_stage .= ' OR NOT FIND_IN_SET(' . $list_search_user_stage_exclude[$i] . ',users.user_stage_id)';
                  }
                }
                $string_sql_search_user_stage .= ')';

                $result->whereRaw($string_sql_search_user_stage);
              }
            }
            if (count($list_search_user_stage_include) > 0) {
              if ($list_search_user_stage_include[0] != '0') {
                $string_sql_search_user_stage = '';
                $string_sql_search_user_stage .= '(FIND_IN_SET(' . $list_search_user_stage_include[0] . ',users.user_stage_id)';

                for ($i = 1; $i < count($list_search_user_stage_include); $i++) {
                  // stage inclusion
                  if ($list_search_user_stage_include[0] != '0') {
                    $string_sql_search_user_stage .= ' AND FIND_IN_SET(' . $list_search_user_stage_include[$i] . ',users.user_stage_id)';
                  }
                }
                $string_sql_search_user_stage .= ')';
                $result->whereRaw($string_sql_search_user_stage);
              }
            }
          }
          if ($input['search_match_type'] == USER_STAGE_MATCH_PORTION) {
            if (count($list_search_user_stage_exclude) > 0) {
              if ($list_search_user_stage_exclude[0] != '0') {
                $string_sql_search_user_stage = '';
                $string_sql_search_user_stage .= '(NOT FIND_IN_SET(' . $list_search_user_stage_exclude[0] . ',users.user_stage_id)';

                for ($i = 1; $i < count($list_search_user_stage_exclude); $i++) {
                  // stage exclusion
                  if ($list_search_user_stage_exclude[$i] != '0') {
                    $string_sql_search_user_stage .= ' AND NOT FIND_IN_SET(' . $list_search_user_stage_exclude[$i] . ',users.user_stage_id)';
                  }
                }
                $string_sql_search_user_stage .= ')';

                $result->whereRaw($string_sql_search_user_stage);
              }
            }
            if (count($list_search_user_stage_include) > 0) {
              if ($list_search_user_stage_include[0] != '0') {
                $string_sql_search_user_stage = '';
                $string_sql_search_user_stage .= '(FIND_IN_SET(' . $list_search_user_stage_include[0] . ',users.user_stage_id)';

                for ($i = 1; $i < count($list_search_user_stage_include); $i++) {
                  // stage inclusion
                  if ($list_search_user_stage_include[0] != '0') {
                    $string_sql_search_user_stage .= ' OR FIND_IN_SET(' . $list_search_user_stage_include[$i] . ',users.user_stage_id)';
                  }
                }
                $string_sql_search_user_stage .= ')';
                $result->whereRaw($string_sql_search_user_stage);
              }
            }
          }
        }

        // ip
        if (isset($input['ip']) && !is_null($input['ip']) && (strlen($input['ip']) > 0)) {
            $result->where('ua.ip', 'like', "%{$input['ip']}%");
        }
        // point_min
        if (isset($input['point_min']) && !is_null($input['point_min']) && (strlen($input['point_min']) > 0)) {
            $result->where('ua.point', '>=', $input['point_min']);
        }
        // point_max
        if (isset($input['point_max']) && !is_null($input['point_max']) && (strlen($input['point_max']) > 0)) {
            $result->where('ua.point', '<=', $input['point_max']);
        }
        // payment_total_amount_min
        if (isset($input['payment_total_amount_min']) && !is_null($input['payment_total_amount_min']) && (strlen($input['payment_total_amount_min']) > 0)) {
            $result->where('ua.payment_total_amount', '>=', $input['payment_total_amount_min']);
        }
        // payment_total_amount_max
        if (isset($input['payment_total_amount_max']) && !is_null($input['payment_total_amount_max']) && (strlen($input['payment_total_amount_max']) > 0)) {
            $result->where('ua.payment_total_amount', '<=', $input['payment_total_amount_max']);
        }
        // payment_total_number_min
        if (isset($input['payment_total_number_min']) && !is_null($input['payment_total_number_min']) && (strlen($input['payment_total_number_min']) > 0)) {
            $result->where('ua.payment_total_number', '>=', $input['payment_total_number_min']);
        }
        // payment_total_number_max
        if (isset($input['payment_total_number_max']) && !is_null($input['payment_total_number_max']) && (strlen($input['payment_total_number_max']) > 0)) {
            $result->where('ua.payment_total_number', '<=', $input['payment_total_number_max']);
        }
        // login_number_min
        if (isset($input['login_number_min']) && !is_null($input['login_number_min']) && (strlen($input['login_number_min']) > 0)) {
            $result->where('ua.login_number', '>=', $input['login_number_min']);
        }
        // login_number_max
        if (isset($input['login_number_max']) && !is_null($input['login_number_max']) && (strlen($input['login_number_max']) > 0)) {
            $result->where('ua.login_number', '<=', $input['login_number_max']);
        }
        // last_payment_time_start
        if (isset($input['last_payment_time_start']) && !is_null($input['last_payment_time_start']) && (strlen($input['last_payment_time_start']) > 0)) {
            $last_payment_time_start = $input["last_payment_time_start"] . " 00:00:00";
            $result->where('ua.last_payment_time', '>=', $last_payment_time_start);
        }
        // last_payment_time_end
        if (isset($input['last_payment_time_end']) && !is_null($input['last_payment_time_end']) && (strlen($input['last_payment_time_end']) > 0)) {
            $last_payment_time_end = $input["last_payment_time_end"] . " 23:59:59";
            $result->where('ua.last_payment_time', '<=', $last_payment_time_end);
        }

        // register_time_start
        if (isset($input['register_time_start']) && !is_null($input['register_time_start']) && (strlen($input['register_time_start']) > 0)) {
            $register_time_start = $input["register_time_start"] . " 00:00:00";
            $result->where('users.register_time', '>=', $register_time_start);
        }
        // register_time_end
        if (isset($input['register_time_end']) && !is_null($input['register_time_end']) && (strlen($input['register_time_end']) > 0)) {
            $register_time_end = $input["register_time_end"] . " 23:59:59";
            $result->where('users.register_time', '<=', $register_time_end);
        }

        // interim_register_time_start
        if (isset($input['interim_register_time_start']) && !is_null($input['interim_register_time_start']) && (strlen($input['interim_register_time_start']) > 0)) {
            $interim_register_time_start = $input["interim_register_time_start"] . " 00:00:00";
            $result->where('users.interim_register_time', '>=', $interim_register_time_start);
        }
        // interim_register_time_end
        if (isset($input['interim_register_time_end']) && !is_null($input['interim_register_time_end']) && (strlen($input['interim_register_time_end']) > 0)) {
            $interim_register_time_end = $input["interim_register_time_end"] . " 23:59:59";
            $result->where('users.interim_register_time', '<=', $interim_register_time_end);
        }

        // last_login_time_start
        if (isset($input['last_login_time_start']) && !is_null($input['last_login_time_start']) && (strlen($input['last_login_time_start']) > 0)) {
            $last_login_time_start = $input["last_login_time_start"] . " 00:00:00";
            $result->where('ua.last_login_time', '>=', $last_login_time_start);
        }
        // last_login_time_end
        if (isset($input['last_login_time_end']) && !is_null($input['last_login_time_end']) && (strlen($input['last_login_time_end']) > 0)) {
            $last_login_time_end = $input["last_login_time_end"] . " 23:59:59";
            $result->where('ua.last_login_time', '<=', $last_login_time_end);
        }

        // last_access_time_start
        if (isset($input['last_access_time_start']) && !is_null($input['last_access_time_start']) && (strlen($input['last_access_time_start']) > 0)) {
            $last_access_time_start = $input["last_access_time_start"] . " 00:00:00";
            $result->where('ua.last_access_time', '>=', $last_access_time_start);
        }
        // last_access_time_end
        if (isset($input['last_access_time_end']) && !is_null($input['last_access_time_end']) && (strlen($input['last_access_time_end']) > 0)) {
            $last_access_time_end = $input["last_access_time_end"] . " 23:59:59";
            $result->where('ua.last_access_time', '<=', $last_access_time_end);
        }

        // first_payment_time_start
        if (isset($input['first_payment_time_start']) && !is_null($input['first_payment_time_start']) && (strlen($input['first_payment_time_start']) > 0)) {
            $first_payment_time_start = $input["first_payment_time_start"] . " 00:00:00";
            $result->where('ua.first_payment_time', '>=', $first_payment_time_start);
        }
        // first payment_datetime_end
        if (isset($input['first_payment_time_end']) && !is_null($input['first_payment_time_end']) && (strlen($input['first_payment_time_end']) > 0)) {
            $first_payment_time_end = $input["first_payment_time_end"] . " 23:59:59";
            $result->where('ua.first_payment_time', '<=', $first_payment_time_end);
        }

        // Search user register
        if (isset($input["user_register"]) && $input["user_register"]) {
            $result->whereNotNull('users.register_time');
        }

        // Search user interim
        if (isset($input["user_interim"]) && $input["user_interim"]) {
            $result->whereNull('users.register_time');
        }

        if (isset($input["sns_register"]) && $input["sns_register"]) {
            if ($input["sns_register"] == SNS_REGISTER_TYPE_ALL) {
                $result->where('users.provider_user_id', '<>', '');
            } else {
                $result->where('users.provider_user_id', 'like', $input["sns_register"] . '%');
            }
        }

        // deposit_total_amount_min
        if (isset($input['deposit_total_amount_min']) && !is_null($input['deposit_total_amount_min']) && (strlen($input['deposit_total_amount_min']) > 0)) {
            $result->where('ua.deposit_amount', '>=', $input['deposit_total_amount_min']);
        }
        // deposit_total_amount_max
        if (isset($input['deposit_total_amount_max']) && !is_null($input['deposit_total_amount_max']) && (strlen($input['deposit_total_amount_max']) > 0)) {
            $result->where('ua.deposit_amount', '<=', $input['deposit_total_amount_max']);
        }
        
        // deposit_total_number_min
        if (isset($input['deposit_total_number_min']) && !is_null($input['deposit_total_number_min']) && (strlen($input['deposit_total_number_min']) > 0)) {
            $result->where('ua.deposit_number', '>=', $input['deposit_total_number_min']);
        }
        // deposit_total_number_max
        if (isset($input['deposit_total_number_max']) && !is_null($input['deposit_total_number_max']) && (strlen($input['deposit_total_number_max']) > 0)) {
            $result->where('ua.deposit_number', '<=', $input['deposit_total_number_max']);
        }

        // first_deposit_time_start
        if (isset($input['first_deposit_time_start']) && !is_null($input['first_deposit_time_start']) && (strlen($input['first_deposit_time_start']) > 0)) {
            $first_deposit_time_start = $input["first_deposit_time_start"] . " 00:00:00";
            $result->where('ua.first_deposit_time', '>=', $first_deposit_time_start);
        }
        // first payment_datetime_end
        if (isset($input['first_deposit_time_end']) && !is_null($input['first_deposit_time_end']) && (strlen($input['first_deposit_time_end']) > 0)) {
            $first_deposit_time_end = $input["first_deposit_time_end"] . " 23:59:59";
            $result->where('ua.first_deposit_time', '<=', $first_deposit_time_end);
        }

        // last_deposit_time_start
        if (isset($input['last_deposit_time_start']) && !is_null($input['last_deposit_time_start']) && (strlen($input['last_deposit_time_start']) > 0)) {
            $last_deposit_time_start = $input["last_deposit_time_start"] . " 00:00:00";
            $result->where('ua.last_deposit_time', '>=', $last_deposit_time_start);
        }
        // first payment_datetime_end
        if (isset($input['last_deposit_time_end']) && !is_null($input['last_deposit_time_end']) && (strlen($input['last_deposit_time_end']) > 0)) {
            $last_deposit_time_end = $input["last_deposit_time_end"] . " 23:59:59";
            $result->where('ua.last_deposit_time', '<=', $last_deposit_time_end);
        }

        //memo
        if (isset($input['summernote']) && !is_null($input['summernote']) && (strlen($input['summernote']) > 0)) {
          $summernote_arr = explode(',', rtrim($input['summernote'], ','));
          if ((int) $input['option_summer'] == USER_STAGE_MATCH_ALL) {
            // dd($summernote_arr);
            $string_sql_note = '';
            $string_sql_note .= "(FIND_IN_SET('" . trim($summernote_arr[0]) . "', users.memo)";

            for ($i = 1; $i < count($summernote_arr); $i++) {
              $string_sql_note .= " AND FIND_IN_SET('" . trim($summernote_arr[$i]) . "', users.memo)";
            }
            $string_sql_note .= ')';

            $result->whereRaw($string_sql_note);
          }

          if ((int) $input['option_summer'] == USER_STAGE_MATCH_PORTION) {
            $string_sql_note = '';
            $string_sql_note .= "(FIND_IN_SET('" . trim($summernote_arr[0]) . "', users.memo)";

            for ($i = 1; $i < count($summernote_arr); $i++) {
              $string_sql_note .= " OR FIND_IN_SET('" . trim($summernote_arr[$i]) . "', users.memo)";
            }
            $string_sql_note .= ')';

            $result->whereRaw($string_sql_note);
          }
        }

        //memo not
        if (isset($input['summernote_not']) && !is_null($input['summernote_not']) && (strlen($input['summernote_not']) > 0)) {
          $summernote_not_arr = explode(',', rtrim($input['summernote_not'], ','));

          if ((int) $input['option_summer_not'] == USER_STAGE_MATCH_ALL) {
            $string_sql_note_not = '';
            $string_sql_note_not .= "(NOT FIND_IN_SET('" . trim($summernote_not_arr[0]) . "', users.memo)";

            for ($i = 1; $i < count($summernote_not_arr); $i++) {
              $string_sql_note_not .= " OR NOT FIND_IN_SET('" . trim($summernote_not_arr[$i]) . "', users.memo)";
            }
            $string_sql_note_not .= ')';

            $result->whereRaw($string_sql_note_not);
          }

          if ((int) $input['option_summer_not'] == USER_STAGE_MATCH_PORTION) {
            $string_sql_note_not = '';
            $string_sql_note_not .= "(NOT FIND_IN_SET('" . trim($summernote_not_arr[0]) . "', users.memo)";

            for ($i = 1; $i < count($summernote_not_arr); $i++) {
              $string_sql_note_not .= " AND NOT FIND_IN_SET('" . trim($summernote_not_arr[$i]) . "', users.memo)";
            }
            $string_sql_note_not .= ')';

            $result->whereRaw($string_sql_note_not);
          }
        }

        // dd($result->toSql() .  print_r($result->getBindings(), true));

        // Get result 
        return $result
            ->get()
            ->toArray();

    }

    public function searchUserAjaxByCondition($input)
    {
      $result = DB::table($this->table)
        ->select("ua.*", "users.*")
        ->leftJoin('user_activity as ua', 'ua.user_id', '=', 'users.id')
        ->where('users.deleted_flg', DELETED_DISABLE);

      if (!is_null($input['iSortCol_0']) && $input['iSortCol_0'] == 0) {
        $result->orderBy('users.id', $input['sSortDir_0']);
      }

      if (!is_null($input['iSortCol_0']) && $input['iSortCol_0'] == 1) {
        $result->orderBy('users.login_id', $input['sSortDir_0']);
      }

      if (!is_null($input['iSortCol_0']) && $input['iSortCol_0'] == 2) {
        $result->orderBy('users.mail_pc', $input['sSortDir_0']);
      }

      if (!is_null($input['iSortCol_0']) && $input['iSortCol_0'] == 3) {
        $result->orderBy('users.media_code', $input['sSortDir_0']);
      }

      if (!is_null($input['iSortCol_0']) && $input['iSortCol_0'] == 4) {
        $result->orderBy('ua.point', $input['sSortDir_0']);
      }

      if (!is_null($input['iSortCol_0']) && $input['iSortCol_0'] == 5) {
        $result->orderBy('ua.deposit_amount', $input['sSortDir_0']);
      }

      if (!is_null($input['iSortCol_0']) && $input['iSortCol_0'] == 6) {
        $result->orderBy('ua.deposit_number', $input['sSortDir_0']);
      }

      if (!is_null($input['iSortCol_0']) && $input['iSortCol_0'] == 7) {
        $result->orderBy('users.register_time', $input['sSortDir_0']);
      }

      if (!is_null($input['iSortCol_0']) && $input['iSortCol_0'] == 8) {
        $result->orderBy('ua.login_number', $input['sSortDir_0']);
      }

      if (!is_null($input['iSortCol_0']) && $input['iSortCol_0'] == 9) {
        $result->orderBy('ua.first_deposit_time', $input['sSortDir_0']);
      }

      if (!is_null($input['iSortCol_0']) && $input['iSortCol_0'] == 10) {
        $result->orderBy('ua.last_deposit_time', $input['sSortDir_0']);
      }

      if (!is_null($input['iSortCol_0']) && $input['iSortCol_0'] == 11) {
        $result->orderBy('ua.last_login_time', $input['sSortDir_0']);
      }

      if (!is_null($input['iSortCol_0']) && $input['iSortCol_0'] == 12) {
        $result->orderBy('users.member_level', $input['sSortDir_0']);
      }

      if (!is_null($input['iSortCol_0']) && $input['iSortCol_0'] == 13) {
        $result->orderBy('users.user_stage_id', $input['sSortDir_0']);
      }

      // User have buy prediction
      if (isset($input['prediction_type']) && !is_null($input['prediction_type']) && (strlen($input['prediction_type']) > 0)) {
        $result->leftJoin('transaction_payment as tp', 'tp.user_id', '=', 'users.id')->Join('prediction as pr', 'tp.prediction_id', '=', 'pr.id')
        ->addSelect(
          'tp.point as trans_point',
          'tp.prediction_id as prediction_id',
          'tp.prediction_name as prediction_name',
          'pr.prediction_type as prediction_type'
        )
          ->where('pr.prediction_type', $input['prediction_type']);
      }

      // User have buy prediction with condition search
      if (isset($input['prediction_id']) && !is_null($input['prediction_id']) && (strlen($input['prediction_id']) > 0)) {
        $result->leftJoin('user_access_prediction as uap', 'uap.user_id', '=', 'users.id')
        ->addSelect('uap.number_access as number_access', 'uap.buy as buy', 'uap.access_result as access_result')
        ->where('uap.prediction_id', $input['prediction_id']);

        switch ($input['buy_prediction']) {
          case USER_BUY_PREDICTION_SUCCESS:
            $result->where('uap.buy', BUY_PREDICTION);
            break;

          case USER_BUY_PREDICTION_ERROR:
            $result->where('uap.buy', BUY_PREDICTION_ERROR);
            break;

          case USER_ACCESS_RESULT_SUCCESS:
            $result->where('uap.access_result', ACCESS_RESULT_SEE);
            break;

          case USER_ACCESS_RESULT_NOT:
            $result->where('uap.access_result', ACCESS_RESULT_NOT_SEE);
            break;

          default:
            break;
        }
      }

      // User Key
      if (isset($input['user_key']) && !is_null($input['user_key']) && (strlen($input['user_key']) > 0)) {
        $result->where('users.user_key', 'like', "%{$input['user_key']}%");
      }
      // Login Id
      if (isset($input['login_id']) && !is_null($input['login_id']) && (strlen($input['login_id']) > 0)) {
        $result->where('users.login_id', 'like', "%{$input['login_id']}%");
      }
      // nickname
      if (isset($input['nickname']) && !is_null($input['nickname']) && (strlen($input['nickname']) > 0)) {
        $result->where('users.nickname', 'like', "%{$input['nickname']}%");
      }
      // member_level
      if (isset($input['member_level']) && !is_null($input['member_level']) && (strlen($input['member_level']) > 0)) {
        $result->where('users.member_level', 'like', "%{$input['member_level']}%");
      }
      // stop_mail        
      if (isset($input['stop_mail']) && !is_null($input['stop_mail']) && (strlen($input['stop_mail']) > 0)) {
        $result->where('users.stop_mail', '=', $input['stop_mail']);
      }

      // mail_pc
      if (isset($input['mail_pc']) && !is_null($input['mail_pc']) && (strlen($input['mail_pc']) > 0)) {
        if (strpos(strtolower(trim($input['mail_pc'])), strtolower('@gmail')) !== FALSE) {
          $mail_pc = $input['mail_pc'];
          $mail_pc_rep = $this->replaceMailGoogle($mail_pc);
          $result->where(function ($q) use ($mail_pc, $mail_pc_rep) {
            $q->where('users.mail_pc', 'like', "%{$mail_pc}%")
            ->orWhere('users.mail_pc', 'like', "%{$mail_pc_rep}%");
          });
        } else {
          $result->where('users.mail_pc', 'like', "%{$input['mail_pc']}%");
        }
      }
      // mail_mobile
      if (isset($input['mail_mobile']) && !is_null($input['mail_mobile']) && (strlen($input['mail_mobile']) > 0)) {
        $result->where('users.mail_mobile', 'like', "%{$input['mail_mobile']}%");
      }
      // Age
      if (isset($input['age']) && !is_null($input['age']) && (strlen($input['age']) > 0)) {
        $result->where('users.age', 'like', "%{$input['age']}%");
      }
      // Gender
      if (isset($input['gender']) && !is_null($input['gender'])) {
        $first = current($input['gender']);
        $arr_gender = $input['gender'];
        // Or where
        $result->where(function ($result) use ($arr_gender, $first) {
          $result->where('users.gender', $first);
          // Or where user stage
          foreach ($arr_gender as $gender) {
            $result = $result->orWhere('users.gender', $gender);
          }
          return $result;
        });
      }

      // media code
      if (isset($input['media_code']) && !is_null($input['media_code']) && (strlen($input['media_code']) > 0)) {
        $result->where('users.media_code', 'like', "%{$input['media_code']}%");
      }

      // User stage           
      if (isset($input['user_stage_id']) && !is_null($input['user_stage_id']) && is_array($input['user_stage_id'])) {
        $list_search_user_stage_include = [];
        $list_search_user_stage_exclude = [];
        foreach ($input['user_stage_id'] as $key => $value) {
          $string_check_stage = explode('-', $value);
          if (isset($string_check_stage[1])) {
            if ($string_check_stage[1] == 1) {
              array_push($list_search_user_stage_include, $string_check_stage[0]);
            }
            if ($string_check_stage[1] == 0) {
              array_push($list_search_user_stage_exclude, $string_check_stage[0]);
            }
          }
        }

        if ($input['search_match_type'] == USER_STAGE_MATCH_ALL) {
          if (count($list_search_user_stage_exclude) > 0) {
            if ($list_search_user_stage_exclude[0] != '0') {
              $string_sql_search_user_stage = '';
              $string_sql_search_user_stage .= '(NOT FIND_IN_SET(' . $list_search_user_stage_exclude[0] . ',users.user_stage_id)';

              for ($i = 1; $i < count($list_search_user_stage_exclude); $i++) {
                // stage exclusion
                if ($list_search_user_stage_exclude[$i] != '0') {
                  $string_sql_search_user_stage .= ' OR NOT FIND_IN_SET(' . $list_search_user_stage_exclude[$i] . ',users.user_stage_id)';
                }
              }
              $string_sql_search_user_stage .= ')';

              $result->whereRaw($string_sql_search_user_stage);
            }
          }
          if (count($list_search_user_stage_include) > 0) {
            if ($list_search_user_stage_include[0] != '0') {
              $string_sql_search_user_stage = '';
              $string_sql_search_user_stage .= '(FIND_IN_SET(' . $list_search_user_stage_include[0] . ',users.user_stage_id)';

              for ($i = 1; $i < count($list_search_user_stage_include); $i++) {
                // stage inclusion
                if ($list_search_user_stage_include[0] != '0') {
                  $string_sql_search_user_stage .= ' AND FIND_IN_SET(' . $list_search_user_stage_include[$i] . ',users.user_stage_id)';
                }
              }
              $string_sql_search_user_stage .= ')';
              $result->whereRaw($string_sql_search_user_stage);
            }
          }
        }
        if ($input['search_match_type'] == USER_STAGE_MATCH_PORTION) {
          if (count($list_search_user_stage_exclude) > 0) {
            if ($list_search_user_stage_exclude[0] != '0') {
              $string_sql_search_user_stage = '';
              $string_sql_search_user_stage .= '(NOT FIND_IN_SET(' . $list_search_user_stage_exclude[0] . ',users.user_stage_id)';

              for ($i = 1; $i < count($list_search_user_stage_exclude); $i++) {
                // stage exclusion
                if ($list_search_user_stage_exclude[$i] != '0') {
                  $string_sql_search_user_stage .= ' AND NOT FIND_IN_SET(' . $list_search_user_stage_exclude[$i] . ',users.user_stage_id)';
                }
              }
              $string_sql_search_user_stage .= ')';

              $result->whereRaw($string_sql_search_user_stage);
            }
          }
          if (count($list_search_user_stage_include) > 0) {
            if ($list_search_user_stage_include[0] != '0') {
              $string_sql_search_user_stage = '';
              $string_sql_search_user_stage .= '(FIND_IN_SET(' . $list_search_user_stage_include[0] . ',users.user_stage_id)';

              for ($i = 1; $i < count($list_search_user_stage_include); $i++) {
                // stage inclusion
                if ($list_search_user_stage_include[0] != '0') {
                  $string_sql_search_user_stage .= ' OR FIND_IN_SET(' . $list_search_user_stage_include[$i] . ',users.user_stage_id)';
                }
              }
              $string_sql_search_user_stage .= ')';
              $result->whereRaw($string_sql_search_user_stage);
            }
          }
        }
      }

      // ip
      if (isset($input['ip']) && !is_null($input['ip']) && (strlen($input['ip']) > 0)) {
        $result->where('ua.ip', 'like', "%{$input['ip']}%");
      }
      // point_min
      if (isset($input['point_min']) && !is_null($input['point_min']) && (strlen($input['point_min']) > 0)) {
        $result->where('ua.point', '>=', $input['point_min']);
      }
      // point_max
      if (isset($input['point_max']) && !is_null($input['point_max']) && (strlen($input['point_max']) > 0)) {
        $result->where('ua.point', '<=', $input['point_max']);
      }
      // payment_total_amount_min
      if (isset($input['payment_total_amount_min']) && !is_null($input['payment_total_amount_min']) && (strlen($input['payment_total_amount_min']) > 0)) {
        $result->where('ua.payment_total_amount', '>=', $input['payment_total_amount_min']);
      }
      // payment_total_amount_max
      if (isset($input['payment_total_amount_max']) && !is_null($input['payment_total_amount_max']) && (strlen($input['payment_total_amount_max']) > 0)) {
        $result->where('ua.payment_total_amount', '<=', $input['payment_total_amount_max']);
      }
      // payment_total_number_min
      if (isset($input['payment_total_number_min']) && !is_null($input['payment_total_number_min']) && (strlen($input['payment_total_number_min']) > 0)) {
        $result->where('ua.payment_total_number', '>=', $input['payment_total_number_min']);
      }
      // payment_total_number_max
      if (isset($input['payment_total_number_max']) && !is_null($input['payment_total_number_max']) && (strlen($input['payment_total_number_max']) > 0)) {
        $result->where('ua.payment_total_number', '<=', $input['payment_total_number_max']);
      }
      // login_number_min
      if (isset($input['login_number_min']) && !is_null($input['login_number_min']) && (strlen($input['login_number_min']) > 0)) {
        $result->where('ua.login_number', '>=', $input['login_number_min']);
      }
      // login_number_max
      if (isset($input['login_number_max']) && !is_null($input['login_number_max']) && (strlen($input['login_number_max']) > 0)) {
        $result->where('ua.login_number', '<=', $input['login_number_max']);
      }
      // last_payment_time_start
      if (isset($input['last_payment_time_start']) && !is_null($input['last_payment_time_start']) && (strlen($input['last_payment_time_start']) > 0)) {
        $last_payment_time_start = $input["last_payment_time_start"] . " 00:00:00";
        $result->where('ua.last_payment_time', '>=', $last_payment_time_start);
      }
      // last_payment_time_end
      if (isset($input['last_payment_time_end']) && !is_null($input['last_payment_time_end']) && (strlen($input['last_payment_time_end']) > 0)) {
        $last_payment_time_end = $input["last_payment_time_end"] . " 23:59:59";
        $result->where('ua.last_payment_time', '<=', $last_payment_time_end);
      }

      // register_time_start
      if (isset($input['register_time_start']) && !is_null($input['register_time_start']) && (strlen($input['register_time_start']) > 0)) {
        $register_time_start = $input["register_time_start"] . " 00:00:00";
        $result->where('users.register_time', '>=', $register_time_start);
      }
      // register_time_end
      if (isset($input['register_time_end']) && !is_null($input['register_time_end']) && (strlen($input['register_time_end']) > 0)) {
        $register_time_end = $input["register_time_end"] . " 23:59:59";
        $result->where('users.register_time', '<=', $register_time_end);
      }

      // interim_register_time_start
      if (isset($input['interim_register_time_start']) && !is_null($input['interim_register_time_start']) && (strlen($input['interim_register_time_start']) > 0)) {
        $interim_register_time_start = $input["interim_register_time_start"] . " 00:00:00";
        $result->where('users.interim_register_time', '>=', $interim_register_time_start);
      }
      // interim_register_time_end
      if (isset($input['interim_register_time_end']) && !is_null($input['interim_register_time_end']) && (strlen($input['interim_register_time_end']) > 0)) {
        $interim_register_time_end = $input["interim_register_time_end"] . " 23:59:59";
        $result->where('users.interim_register_time', '<=', $interim_register_time_end);
      }

      // last_login_time_start
      if (isset($input['last_login_time_start']) && !is_null($input['last_login_time_start']) && (strlen($input['last_login_time_start']) > 0)) {
        $last_login_time_start = $input["last_login_time_start"] . " 00:00:00";
        $result->where('ua.last_login_time', '>=', $last_login_time_start);
      }
      // last_login_time_end
      if (isset($input['last_login_time_end']) && !is_null($input['last_login_time_end']) && (strlen($input['last_login_time_end']) > 0)) {
        $last_login_time_end = $input["last_login_time_end"] . " 23:59:59";
        $result->where('ua.last_login_time', '<=', $last_login_time_end);
      }

      // last_access_time_start
      if (isset($input['last_access_time_start']) && !is_null($input['last_access_time_start']) && (strlen($input['last_access_time_start']) > 0)) {
        $last_access_time_start = $input["last_access_time_start"] . " 00:00:00";
        $result->where('ua.last_access_time', '>=', $last_access_time_start);
      }
      // last_access_time_end
      if (isset($input['last_access_time_end']) && !is_null($input['last_access_time_end']) && (strlen($input['last_access_time_end']) > 0)) {
        $last_access_time_end = $input["last_access_time_end"] . " 23:59:59";
        $result->where('ua.last_access_time', '<=', $last_access_time_end);
      }

      // first_payment_time_start
      if (isset($input['first_payment_time_start']) && !is_null($input['first_payment_time_start']) && (strlen($input['first_payment_time_start']) > 0)) {
        $first_payment_time_start = $input["first_payment_time_start"] . " 00:00:00";
        $result->where('ua.first_payment_time', '>=', $first_payment_time_start);
      }
      // first payment_datetime_end
      if (isset($input['first_payment_time_end']) && !is_null($input['first_payment_time_end']) && (strlen($input['first_payment_time_end']) > 0)) {
        $first_payment_time_end = $input["first_payment_time_end"] . " 23:59:59";
        $result->where('ua.first_payment_time', '<=', $first_payment_time_end);
      }

      // Search user register
      if (isset($input["user_register"]) && $input["user_register"]) {
        $result->whereNotNull('users.register_time');
      }

      // Search user interim
      if (isset($input["user_interim"]) && $input["user_interim"]) {
        $result->whereNull('users.register_time');
      }

      if (isset($input["sns_register"]) && $input["sns_register"]) {
        if ($input["sns_register"] == SNS_REGISTER_TYPE_ALL) {
          $result->where('users.provider_user_id', '<>', '');
        } else {
          $result->where('users.provider_user_id', 'like', $input["sns_register"] . '%');
        }
      }

      // deposit_total_amount_min
      if (isset($input['deposit_total_amount_min']) && !is_null($input['deposit_total_amount_min']) && (strlen($input['deposit_total_amount_min']) > 0)) {
        $result->where('ua.deposit_amount', '>=', $input['deposit_total_amount_min']);
      }
      // deposit_total_amount_max
      if (isset($input['deposit_total_amount_max']) && !is_null($input['deposit_total_amount_max']) && (strlen($input['deposit_total_amount_max']) > 0)) {
        $result->where('ua.deposit_amount', '<=', $input['deposit_total_amount_max']);
      }

      // deposit_total_number_min
      if (isset($input['deposit_total_number_min']) && !is_null($input['deposit_total_number_min']) && (strlen($input['deposit_total_number_min']) > 0)) {
        $result->where('ua.deposit_number', '>=', $input['deposit_total_number_min']);
      }
      // deposit_total_number_max
      if (isset($input['deposit_total_number_max']) && !is_null($input['deposit_total_number_max']) && (strlen($input['deposit_total_number_max']) > 0)) {
        $result->where('ua.deposit_number', '<=', $input['deposit_total_number_max']);
      }

      // first_deposit_time_start
      if (isset($input['first_deposit_time_start']) && !is_null($input['first_deposit_time_start']) && (strlen($input['first_deposit_time_start']) > 0)) {
        $first_deposit_time_start = $input["first_deposit_time_start"] . " 00:00:00";
        $result->where('ua.first_deposit_time', '>=', $first_deposit_time_start);
      }
      // first payment_datetime_end
      if (isset($input['first_deposit_time_end']) && !is_null($input['first_deposit_time_end']) && (strlen($input['first_deposit_time_end']) > 0)) {
        $first_deposit_time_end = $input["first_deposit_time_end"] . " 23:59:59";
        $result->where('ua.first_deposit_time', '<=', $first_deposit_time_end);
      }

      // last_deposit_time_start
      if (isset($input['last_deposit_time_start']) && !is_null($input['last_deposit_time_start']) && (strlen($input['last_deposit_time_start']) > 0)) {
        $last_deposit_time_start = $input["last_deposit_time_start"] . " 00:00:00";
        $result->where('ua.last_deposit_time', '>=', $last_deposit_time_start);
      }
      // first payment_datetime_end
      if (isset($input['last_deposit_time_end']) && !is_null($input['last_deposit_time_end']) && (strlen($input['last_deposit_time_end']) > 0)) {
        $last_deposit_time_end = $input["last_deposit_time_end"] . " 23:59:59";
        $result->where('ua.last_deposit_time', '<=', $last_deposit_time_end);
      }

      if (isset($input['key_search']) && !is_null($input['key_search']) && (strlen($input['key_search']) > 0)) {
        $result->where('users.login_id', 'like', '%' . $input['key_search'] . '%')
        ->orWhere('users.mail_pc', 'like', '%' . $input['key_search'] . '%')
        ->orWhere('users.media_code', 'like', '%' . $input['key_search'] . '%')
        ->orWhere('ua.point', 'like', '%' . $input['key_search'] . '%')
        ->orWhere('ua.deposit_amount', 'like', '%' . $input['key_search'] . '%')
        ->orWhere('ua.deposit_number', 'like', '%' . $input['key_search'] . '%')
        ->orWhere('users.register_time', 'like', '%' . $input['key_search'] . '%')
        ->orWhere('ua.login_number', 'like', '%' . $input['key_search'] . '%')
        ->orWhere('ua.first_deposit_time', 'like', '%' . $input['key_search'] . '%')
        ->orWhere('ua.last_deposit_time', 'like', '%' . $input['key_search'] . '%')
        ->orWhere('ua.last_login_time', 'like', '%' . $input['key_search'] . '%');
      }

      //memo
      if (isset($input['summernote']) && !is_null($input['summernote']) && (strlen($input['summernote']) > 0)) {
        $summernote_arr = explode(',', rtrim($input['summernote'], ','));
        if ((int) $input['option_summer'] == USER_STAGE_MATCH_ALL) {
          // dd($summernote_arr);
          $string_sql_note = '';
          $string_sql_note .= "(FIND_IN_SET('" . trim($summernote_arr[0]) . "', users.memo)";

          for ($i = 1; $i < count($summernote_arr); $i++) {
            $string_sql_note .= " AND FIND_IN_SET('" . trim($summernote_arr[$i]) . "', users.memo)";
          }
          $string_sql_note .= ')';

          $result->whereRaw($string_sql_note);
        }

        if ((int) $input['option_summer'] == USER_STAGE_MATCH_PORTION) {
          $string_sql_note = '';
          $string_sql_note .= "(FIND_IN_SET('" . trim($summernote_arr[0]) . "', users.memo)";

          for ($i = 1; $i < count($summernote_arr); $i++) {
            $string_sql_note .= " OR FIND_IN_SET('" . trim($summernote_arr[$i]) . "', users.memo)";
          }
          $string_sql_note .= ')';

          $result->whereRaw($string_sql_note);
        }
      }

      //memo not
      if (isset($input['summernote_not']) && !is_null($input['summernote_not']) && (strlen($input['summernote_not']) > 0)) {
        $summernote_not_arr = explode(',', rtrim($input['summernote_not'], ','));

        if ((int) $input['option_summer_not'] == USER_STAGE_MATCH_ALL) {
          $string_sql_note_not = '';
          $string_sql_note_not .= "(NOT FIND_IN_SET('" . trim($summernote_not_arr[0]) . "', users.memo)";

          for ($i = 1; $i < count($summernote_not_arr); $i++) {
            $string_sql_note_not .= " OR NOT FIND_IN_SET('" . trim($summernote_not_arr[$i]) . "', users.memo)";
          }
          $string_sql_note_not .= ')';

          $result->whereRaw($string_sql_note_not);
        }

        if ((int) $input['option_summer_not'] == USER_STAGE_MATCH_PORTION) {
          $string_sql_note_not = '';
          $string_sql_note_not .= "(NOT FIND_IN_SET('" . trim($summernote_not_arr[0]) . "', users.memo)";

          for ($i = 1; $i < count($summernote_not_arr); $i++) {
            $string_sql_note_not .= " AND NOT FIND_IN_SET('" . trim($summernote_not_arr[$i]) . "', users.memo)";
          }
          $string_sql_note_not .= ')';

          $result->whereRaw($string_sql_note_not);
        }
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

    public function searchUserNotSendMailByCondition($input)
    {
        $result=[];
        if (isset($input["read_unread"])) 
        {
            if ($input["read_unread"]!=UNREAD) 
            {
                $result = DB::table($this->table)
                ->join('user_activity', 'users.id', '=', 'user_activity.user_id')
                ->leftjoin('mail_contact','users.id','=', 'mail_contact.user_id')
                ->select("users.id", "users.id as user_id","mail_contact.mail_from_address","mail_contact.mail_from_name","mail_contact.mail_to_address","mail_contact.mail_to_name","mail_contact.mail_title","mail_contact.mail_body","mail_contact.status","mail_contact.user_read_at","users.created_at as admin_read_at","mail_contact.deleted_flg","mail_contact.created_at","mail_contact.updated_at","users.login_id as login_id", "users.media_code as media_code",
                    "users.user_stage_id as user_stage_id",
                    "user_activity.deposit_number as deposit_number", "user_activity.payment_number as payment_number")
                ->where('users.deleted_flg', DELETED_DISABLE)
                ->whereNotIn('users.id',function($query){$query->select('user_id')->from('mail_bulk_detail');})
                ->whereNotIn('users.id',function($query) {
                    $query->select('user_id')->from('mail_contact');     
                });   
                
                
                 // start_date
                if (isset($input['start_date']) && !is_null($input['start_date']) && (strlen($input['start_date']) > 0))
                {
                    $result->where('mail_contact.created_at', '>=', $input['start_date']);
                }
                // start_end
                if (isset($input['start_end']) && !is_null($input['start_end']) && (strlen($input['start_end']) > 0))
                {
                    $result->where('mail_contact.created_at', '<=', $input['start_end']. " 23:59:59"); 
                }
                // Login Id
                if (isset($input['login_id']) && !is_null($input['login_id']) && (strlen($input['login_id']) > 0))
                {
                    $result->where('users.login_id', 'like', "%{$input['login_id']}%");
                }
                // Mail Pc
                if (isset($input['mail_pc']) && !is_null($input['mail_pc']) && (strlen($input['mail_pc']) > 0))
                {
                    
                    if(strpos(strtolower(trim($input['mail_pc'])), strtolower('@gmail'))!==FALSE)
                    {
                        $mail_pc = $input['mail_pc'];
                        $mail_pc_rep = $this->replaceMailGoogle($mail_pc);
                        $result->where(function($q) use ($mail_pc, $mail_pc_rep)
                        {
                            $q->where('users.mail_pc', 'like', "%{$mail_pc}%")
                            ->orWhere('users.mail_pc', 'like', "%{$mail_pc_rep}%");
                        });
                    }
                    else
                    {
                        $result->where('users.mail_pc', 'like', "%{$input['mail_pc']}%");
                    }
                }

                // member_level
                if (isset($input['member_level']) && !is_null($input['member_level']) && (strlen($input['member_level']) > 0))
                {
                    $result->where('users.member_level', '=', $input['member_level']);
                }

                // media_code
                if (isset($input['media_code']) && !is_null($input['media_code']) && (strlen($input['media_code']) > 0))
                {
                    $result->where('users.media_code', 'like', "%{$input['media_code']}%");
                }

                // User stage
                if (isset($input['user_stage']) && !is_null($input['user_stage']) && (strlen($input['user_stage']) > 0))
                {
                   
                   $list_search_user_stage = explode(",",$input['user_stage']);
                    if(count($list_search_user_stage)>0)
                    {
                        if($list_search_user_stage[0]!='0')
                        {                   
                            $string_sql_search_user_stage='';
                            $string_sql_search_user_stage.='(FIND_IN_SET('.$list_search_user_stage[0].',users.user_stage_id)';
                            for($i=1; $i<count($list_search_user_stage);$i++)
                            {
                                $string_sql_search_user_stage.=' OR FIND_IN_SET('.$list_search_user_stage[$i].',users.user_stage_id)';
                            }
                            $string_sql_search_user_stage.=')';
                            $result->whereRaw($string_sql_search_user_stage);
                        }
                    }
                }

                // keyword
                if (isset($input['keyword']) && !is_null($input['keyword']) && (strlen($input['keyword']) > 0))
                {
                    $keyword = trim($input['keyword']);
                    // Or where
                    $result->where(function ($result) use ($keyword)
                    {
                        return $result->where('mail_contact.mail_title', 'like', "%{$keyword}%")
                        ->orWhere('mail_contact.mail_body', 'like', "%{$keyword}%")
                        ->orWhere('mail_contact.mail_to_address', 'like', "%{$keyword}%")              
                        ->orWhere('mail_contact.mail_to_name', 'like', "%{$keyword}%")
                        ->orWhere('mail_contact.mail_from_address', 'like', "%{$keyword}%")
                        ->orWhere('mail_contact.mail_from_name', 'like', "%{$keyword}%");
                    });
                }
                 // Payment
                if (isset($input["payment"]))
                {
                    switch ($input["payment"]) 
                    {
                        case "deposit":
                            $result->where('user_activity.deposit_number', '>', 0);
                            break;

                        case "payment":
                            $result->where('user_activity.payment_number', '>', 0);
                            break;
                    }
                }
                $result = $result->get()->toArray();

            }
        }
        return $result;
    }

    public function searchUserIdSendMailByCondition($input)
    {
        $result=[];
        if (isset($input["read_unread"])) 
        {
            if ($input["read_unread"]!=UNREAD) 
            {
                $result = DB::table($this->table)
                ->join('user_activity', 'users.id', '=', 'user_activity.user_id')
                ->select('users.id')
                ->where('users.deleted_flg', DELETED_DISABLE);

                // Login Id
                if (isset($input['login_id']) && !is_null($input['login_id']) && (strlen($input['login_id']) > 0))
                {
                    $result->where('users.login_id', 'like', "%{$input['login_id']}%");
                }
                // Mail Pc
                if (isset($input['mail_pc']) && !is_null($input['mail_pc']) && (strlen($input['mail_pc']) > 0))
                {
                    
                    if(strpos(strtolower(trim($input['mail_pc'])), strtolower('@gmail'))!==FALSE)
                    {
                        $mail_pc = $input['mail_pc'];
                        $mail_pc_rep = $this->replaceMailGoogle($mail_pc);
                        $result->where(function($q) use ($mail_pc, $mail_pc_rep)
                        {
                            $q->where('users.mail_pc', 'like', "%{$mail_pc}%")
                            ->orWhere('users.mail_pc', 'like', "%{$mail_pc_rep}%");
                        });
                    }
                    else
                    {
                        $result->where('users.mail_pc', 'like', "%{$input['mail_pc']}%");
                    }
                }

                // member_level
                if (isset($input['member_level']) && !is_null($input['member_level']) && (strlen($input['member_level']) > 0))
                {
                    $result->where('users.member_level', '=', $input['member_level']);
                }

                // media_code
                if (isset($input['media_code']) && !is_null($input['media_code']) && (strlen($input['media_code']) > 0))
                {
                    $result->where('users.media_code', 'like', "%{$input['media_code']}%");
                }

                // User stage
                if (isset($input['user_stage']) && !is_null($input['user_stage']) && (strlen($input['user_stage']) > 0))
                {
                   
                   $list_search_user_stage = explode(",",$input['user_stage']);
                    if(count($list_search_user_stage)>0)
                    {
                        if($list_search_user_stage[0]!='0')
                        {                   
                            $string_sql_search_user_stage='';
                            $string_sql_search_user_stage.='(FIND_IN_SET('.$list_search_user_stage[0].',users.user_stage_id)';
                            for($i=1; $i<count($list_search_user_stage);$i++)
                            {
                                $string_sql_search_user_stage.=' OR FIND_IN_SET('.$list_search_user_stage[$i].',users.user_stage_id)';
                            }
                            $string_sql_search_user_stage.=')';
                            $result->whereRaw($string_sql_search_user_stage);
                        }
                    }
                }

                // keyword
                if (isset($input['keyword']) && !is_null($input['keyword']) && (strlen($input['keyword']) > 0))
                {
                    $keyword = trim($input['keyword']);
                    // Or where
                    $result->where(function ($result) use ($keyword)
                    {
                        return $result->where('users.mail_pc', 'like', "%{$keyword}%")              
                        ->orWhere('users.nickname', 'like', "%{$keyword}%");
                    });
                }
                 // Payment
                if (isset($input["payment"]))
                {
                    switch ($input["payment"]) 
                    {
                        case "deposit":
                            $result->where('user_activity.deposit_number', '>', 0);
                            break;

                        case "payment":
                            $result->where('user_activity.payment_number', '>', 0);
                            break;
                    }
                }
                $result = $result->distinct()->get()->toArray();

            }
        }
        return $result;
    }

    public function getSummaryUserRegisterDaily($year, $month)
    {
      $result = DB::table($this->table)
        ->select(
          DB::raw('DATE(register_time) as date'),
          DB::raw('COUNT(register_time) as number_register_user')
        )
        ->where($this->table . '.deleted_flg', DELETED_DISABLE)
        ->whereRaw('YEAR(register_time) =' . $year . ' AND MONTH(register_time)=' . $month)
        ->groupBy('date')
        ->get()
        ->toArray();

      return $result;
    }
}
