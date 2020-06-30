<?php

namespace Modules\Horserace\Entities;

use Illuminate\Database\Eloquent\Model as Model;
use Illuminate\Support\Facades\DB;
use Modules\Horserace\Entities\User;

class MailBulkDetail
{
  protected $table = 'mail_bulk_detail';

  public function insertMailBulkDetail($data)
  {
    $data['created_at'] = \Carbon\Carbon::now()->toDateTimeString();
    $data['updated_at'] = \Carbon\Carbon::now()->toDateTimeString();
    return DB::table($this->table)->insert($data);
  }

  public function getMailBulkDetail()
  {
    return DB::table($this->table)
      ->where($this->table . '.deleted_flg', DELETED_DISABLE)
      ->orderBy('id', 'DESC')
      ->get()
      ->toArray();
  }

  public function getMailBulkDetailById($id)
  {
    return DB::table($this->table)->find($id);
  }

  public function updateMailBulkDetail($id, $data)
  {
    $data['updated_at'] = \Carbon\Carbon::now()->toDateTimeString();
    DB::table($this->table)
      ->where('id', $id)
      ->update($data);
  }

  public function deleteMailBulkDetail($id)
  {
    $data['deleted_flg'] = DELETED_ENABLE;
    DB::table($this->table)
      ->where('id', $id)
      ->update($data);
  }

  public function getMailBulkDetailByUserId($user_id)
  {
    return DB::table($this->table)
      ->where($this->table . '.user_id', $user_id)
      ->where($this->table . '.deleted_flg', DELETED_DISABLE)
      ->get()
      ->toArray();
  }

  public function changeMailBulkReadAt($user_id, $id)
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

  public function getMailBulkDetailByIdUser($user_id, $mail_id)
  {
    $result = DB::table($this->table)
      ->where($this->table . '.id', $mail_id)
      ->where($this->table . '.user_id', $user_id)
      ->where($this->table . '.deleted_flg', DELETED_DISABLE)
      ->first();

    return $result;
  }
  public function getMailBulkDetailByIdUserIdMailBulk($user_id, $mail_bulk_id)
  {
    $result = DB::table($this->table)
      ->where($this->table . '.mail_bulk_id', $mail_bulk_id)
      ->where($this->table . '.user_id', $user_id)
      ->where($this->table . '.deleted_flg', DELETED_DISABLE)
      ->first();

    return $result;
  }

  public function deleteMailBulkDetailUser($user_id, $mail_id)
  {
    $data['deleted_flg'] = DELETED_ENABLE;
    DB::table($this->table)
      ->where('user_id', $user_id)
      ->where('id', $mail_id)
      ->update($data);
  }
  public function searchMailBulkDetailToShowMailCotactPageByCondition($input, $page, $limit)
  { 

    $offset = $page * $limit;
    $result=[];
    if (isset($input["read_unread"])) 
    {
      if ($input["read_unread"]!=UNREAD && !isset($input['start_date']) && !isset($input['start_end'])) 
      {
        
          $result = DB::table($this->table)
          ->join('users', 'mail_bulk_detail.user_id', '=', 'users.id')
          //->join('user_activity', 'mail_bulk_detail.user_id', '=', 'user_activity.user_id')
          ->select("mail_bulk_detail.id","mail_bulk_detail.user_id", "mail_bulk_detail.mail_from_address","mail_bulk_detail.mail_from_name","mail_bulk_detail.mail_to_address","mail_bulk_detail.mail_to_name","mail_bulk_detail.mail_title","mail_bulk_detail.mail_body", "mail_bulk_detail.status", "mail_bulk_detail.read_at as user_read_at", "mail_bulk_detail.created_at as admin_read_at", "mail_bulk_detail.deleted_flg","mail_bulk_detail.created_at","mail_bulk_detail.updated_at", "users.login_id as login_id", "users.media_code as media_code",
            "users.user_stage_id as user_stage_id")
            //"user_activity.deposit_number as deposit_number", "user_activity.payment_number as payment_number")
          ->where('mail_bulk_detail.deleted_flg', DELETED_DISABLE);
          /*->whereNotIn('mail_bulk_detail.user_id',function($query) {
            $query->select('user_id')->from('mail_contact');     
          });*/
           //->orderBy('mail_bulk_detail.created_at','DESC');

          // start_date
          if (isset($input['start_date']) && !is_null($input['start_date']) && (strlen($input['start_date']) > 0))
          {
            $result->where('mail_bulk_detail.created_at', '>=', $input['start_date']);
          }
          // start_end
          if (isset($input['start_end']) && !is_null($input['start_end']) && (strlen($input['start_end']) > 0))
          {
            $result->where('mail_bulk_detail.created_at', '<=', $input['start_end']. " 23:59:59"); 
          }
          // Login Id
          if (isset($input['login_id']) && !is_null($input['login_id']) && (strlen($input['login_id']) > 0))
          {
            $result->where('users.login_id', '=', $input['login_id']);
          }
          // Mail Pc
          /*if (isset($input['mail_pc']) && !is_null($input['mail_pc']) && (strlen($input['mail_pc']) > 0))
          {
            if(strpos(strtolower(trim($input['mail_pc'])), strtolower('@gmail'))!==FALSE)
            {
              $user = new User();
              
              $mail_pc = $input['mail_pc'];
              $mail_pc_rep = $user->replaceMailGoogle($mail_pc);
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
          }*/

          // member_level
          /*if (isset($input['member_level']) && !is_null($input['member_level']) && (strlen($input['member_level']) > 0))
          {
            $result->where('users.member_level', '=', $input['member_level']);
          }

          // media_code
          if (isset($input['media_code']) && !is_null($input['media_code']) && (strlen($input['media_code']) > 0))
          {
            $result->where('users.media_code', 'like', "%{$input['media_code']}%");
          }*/

          // User stage
          /*if (isset($input['user_stage']) && !is_null($input['user_stage']) && (strlen($input['user_stage']) > 0))
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
          }*/

          // keyword
          /*if (isset($input['keyword']) && !is_null($input['keyword']) && (strlen($input['keyword']) > 0))
          {
            $keyword = trim($input['keyword']);
            //dd($keyword);
            // Or where
            $result->where(function ($result) use ($keyword)
            {
              return $result->where('mail_bulk_detail.mail_title', 'like', "%{$keyword}%")
              ->orWhere('mail_bulk_detail.mail_body', 'like', "%{$keyword}%")
              ->orWhere('mail_bulk_detail.mail_to_address', 'like', "%{$keyword}%")              
              ->orWhere('mail_bulk_detail.mail_to_name', 'like', "%{$keyword}%")
              ->orWhere('mail_bulk_detail.mail_from_address', 'like', "%{$keyword}%")
              ->orWhere('mail_bulk_detail.mail_from_name', 'like', "%{$keyword}%");
            });
          }*/

          // Payment
          /*f (isset($input["payment"])) {
            switch ($input["payment"]) {
              case "deposit":
                $result->where('user_activity.deposit_number', '>', 0);
                break;

              case "payment":
                $result->where('user_activity.payment_number', '>', 0);
                break;
            }
          }*/

          // order 
          if (isset($input["order"])) {
            switch ($input["order"]) {
              case "created_at_asc":
                $result->orderBy('mail_bulk_detail.created_at', 'ASC');
                break;
              case "created_at_desc":
                $result->orderBy('mail_bulk_detail.created_at', 'DESC');
                break;
            }
          } else {
            $result->orderBy('mail_bulk_detail.created_at', 'DESC');
          }

          $result = $result->limit($limit)->offset($offset)->get()->toArray();
     }
   }
    return $result;
  }  
  
  public function searchUserIdSendMailBulkByCondition($input)
  { 
    $result=[];
    if (isset($input["read_unread"])) 
    {
      if ($input["read_unread"]!=UNREAD && !isset($input['start_date']) && !isset($input['start_end'])) 
      {
        $result = DB::table($this->table)
          ->join('user_activity', 'mail_bulk_detail.user_id', '=', 'user_activity.user_id')
          ->join('users', 'mail_bulk_detail.user_id', '=', 'users.id')          
          ->select("users.id")
          ->where('mail_bulk_detail.deleted_flg', DELETED_DISABLE);
         

          // start_date
          if (isset($input['start_date']) && !is_null($input['start_date']) && (strlen($input['start_date']) > 0))
          {
            $result->where('mail_bulk_detail.created_at', '>=', $input['start_date']);
          }
          // start_end
          if (isset($input['start_end']) && !is_null($input['start_end']) && (strlen($input['start_end']) > 0))
          {
            $result->where('mail_bulk_detail.created_at', '<=', $input['start_end']. " 23:59:59"); 
          }
          // Login Id
          if (isset($input['login_id']) && !is_null($input['login_id']) && (strlen($input['login_id']) > 0))
          {
            $result->where('users.login_id', '=', $input['login_id']);
          }
          // Mail Pc
          if (isset($input['mail_pc']) && !is_null($input['mail_pc']) && (strlen($input['mail_pc']) > 0))
          {
            $result->where('users.mail_pc', 'like', "%{$input['mail_pc']}%");
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
            //dd($keyword);
            // Or where
            $result->where(function ($result) use ($keyword)
            {
              return $result->where('mail_bulk_detail.mail_title', 'like', "%{$keyword}%")
              ->orWhere('mail_bulk_detail.mail_body', 'like', "%{$keyword}%")
              ->orWhere('mail_bulk_detail.mail_to_address', 'like', "%{$keyword}%")              
              ->orWhere('mail_bulk_detail.mail_to_name', 'like', "%{$keyword}%")
              ->orWhere('mail_bulk_detail.mail_from_address', 'like', "%{$keyword}%")
              ->orWhere('mail_bulk_detail.mail_from_name', 'like', "%{$keyword}%");
            });
          }

          // Payment
          if (isset($input["payment"])) {
            switch ($input["payment"]) {
              case "deposit":
                $result->where('user_activity.deposit_number', '>', 0);
                break;

              case "payment":
                $result->where('user_activity.payment_number', '>', 0);
                break;
            }
          }

          // order 
         /* if (isset($input["order"])) {
            switch ($input["order"]) {
              case "created_at_asc":
                $result->orderBy('mail_bulk_detail.created_at', 'ASC');
                break;
              case "created_at_desc":
                $result->orderBy('mail_bulk_detail.created_at', 'DESC');
                break;
            }
          } else {
            $result->orderBy('mail_bulk_detail.created_at', 'DESC');
          }*/

        $result = $result->distinct()->get()->toArray();
      }
    }
    
    return $result;
  }


  public function getMailBulkDetailByUserIdToShowMailContactPage($user_id, $page, $limit)
  { 

    $result = DB::table($this->table)
    ->select("mail_bulk_detail.id","mail_bulk_detail.user_id", "mail_bulk_detail.mail_from_address","mail_bulk_detail.mail_from_name","mail_bulk_detail.mail_to_address","mail_bulk_detail.mail_to_name","mail_bulk_detail.mail_title","mail_bulk_detail.mail_body", "mail_bulk_detail.status", "mail_bulk_detail.read_at as user_read_at", "mail_bulk_detail.created_at as admin_read_at", "mail_bulk_detail.deleted_flg","mail_bulk_detail.created_at","mail_bulk_detail.updated_at")
    ->where('mail_bulk_detail.user_id', $user_id)
    ->where('mail_bulk_detail.deleted_flg', DELETED_DISABLE)
    ->orderBy('created_at', 'DESC'); 
    if($page!==null && $limit!==null)
    {
      $offset = $page * $limit;
      $result->limit($limit)->offset($offset);
    }
    $result = $result->get()->toArray();
    return $result;   
  }

}
