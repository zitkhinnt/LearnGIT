<?php

namespace Modules\Horserace\Entities;

use Illuminate\Database\Eloquent\Model as Model;
use Illuminate\Support\Facades\DB;
use Modules\Horserace\Entities\User;

class MailContact
{
  protected $table = 'mail_contact';

  public function insertMailContact($data)
  {
    $data['created_at'] = \Carbon\Carbon::now()->toDateTimeString();
    $data['updated_at'] = \Carbon\Carbon::now()->toDateTimeString();
    return DB::table($this->table)->insert($data);
  }

  public function getMailContact($input)
  {
    $result =  DB::table($this->table)
      ->leftJoin('users', 'mail_contact.user_id', '=', 'users.id')
      ->where('mail_contact.deleted_flg', DELETED_DISABLE)
      ->orderBy('mail_contact.created_at', 'DESC')
      ->select('users.login_id', 'users.id', 'mail_contact.mail_title', 'mail_contact.mail_body', 'mail_contact.created_at');

    if (isset($input['key_search']) && !is_null($input['key_search']) && (strlen($input['key_search']) > 0)) {
      $result->where('users.id', 'like', '%' . $input['key_search'] . '%')
        ->orWhere('mail_contact.mail_title', 'like', '%' . $input['key_search'] . '%')
        ->orWhere('mail_contact.mail_body', 'like', '%' . $input['key_search'] . '%')
        ->orWhere('mail_contact.created_at', 'like', '%' . $input['key_search'] . '%');
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

  public function getMailContactById($id)
  {
    return DB::table($this->table)->find($id);
  }

  public function updateMailContact($id, $data)
  {
    $data['updated_at'] = \Carbon\Carbon::now()->toDateTimeString();
    DB::table($this->table)
      ->where('id', $id)
      ->update($data);
  }

  public function deleteMailContact($id)
  {
    $data['deleted_flg'] = DELETED_ENABLE;
    DB::table($this->table)
      ->where('id', $id)
      ->update($data);
  }

  public function adminDeletedMailByUserId($user_id)
  {
    $data['deleted_flg'] = DELETED_ENABLE;
    DB::table($this->table)
      ->where('user_id', $user_id)
      ->update($data);
  }

  public function adminDeletedMailGuest($mail_guest)
  {
    $data['deleted_flg'] = DELETED_ENABLE;
    DB::table($this->table)
      ->where('mail_from_address', $mail_guest)
      ->update($data);

    DB::table($this->table)
      ->where('mail_to_address', $mail_guest)
      ->update($data);
  }

  public function getMailContactByUserId($user_id)
  {
    return DB::table($this->table)
      ->where($this->table . '.user_id', $user_id)
      ->where($this->table . '.deleted_flg', DELETED_DISABLE)
      ->get()
      ->toArray();
  }

  public function getMailContactAdminUnreadByUserId($user_id, $page, $limit)
  {
     
    $result = DB::table($this->table)
    ->where($this->table . '.user_id', $user_id)
    ->whereNotNull('admin_read_at')
    ->where($this->table . '.deleted_flg', DELETED_DISABLE)
    ->orderBy('created_at', 'DESC');
      if($page!==null && $limit!==null)
      {
        $offset = $page * $limit;
        $result->limit($limit)->offset($offset);
      }

      return $result->get()
        ->toArray();
  }
  public function getMailContactAdminReadByUserIdByCondition($user_id, $input, $page, $limit)
  {
     
    $result = DB::table($this->table)
    ->where($this->table . '.user_id', $user_id)
    ->whereNotNull('admin_read_at')
    ->where($this->table . '.deleted_flg', DELETED_DISABLE);

    if (isset($input["order"])) {
      switch ($input["order"]) {
        case "created_at_asc":
          $result->orderBy('created_at', 'ASC');
          break;
        case "created_at_desc":
          $result->orderBy('created_at', 'DESC');
          break;
      }
    } else {
      $result->orderBy('created_at', 'DESC');
    }
    
   /* ->orderBy('created_at', 'DESC');*/
    if($page!==null && $limit!==null)
    {
      $offset = $page * $limit;
      $result->limit($limit)->offset($offset);
    }

    return $result->get()
      ->toArray();
  }

  public function getMailContactAdminUnreadByMailPc($mail_pc, $page, $limit)
  {
    
      
    $result =  DB::table($this->table)
      ->where('mail_from_address', 'like', "%,{$mail_pc},%")
      ->whereNotNull('admin_read_at')
      ->where($this->table . '.deleted_flg', DELETED_DISABLE)
      ->orderBy('created_at', 'DESC');
      if($page!==null && $limit!==null)
      {
        $offset = $page * $limit;
        $result->limit($limit)->offset($offset);
      }
     return $result->get() ->toArray();
  }

  public function getMailContactAdminReadByMailPcByCondition($mail_pc, $input, $page, $limit)
  {
    
      
    $result =  DB::table($this->table)
      ->where('mail_from_address', 'like', "%,{$mail_pc},%")
      ->whereNotNull('admin_read_at')
      ->where($this->table . '.deleted_flg', DELETED_DISABLE);

      if (isset($input["order"])) {
        switch ($input["order"]) {
          case "created_at_asc":
            $result->orderBy('created_at', 'ASC');
            break;
          case "created_at_desc":
            $result->orderBy('created_at', 'DESC');
            break;
        }
      } else {
        $result->orderBy('created_at', 'DESC');
      }
      //>orderBy('created_at', 'DESC');
      if($page!==null && $limit!==null)
      {
        $offset = $page * $limit;
        $result->limit($limit)->offset($offset);
      }
     return $result->get() ->toArray();
  }

  public function deleteMailContactByUserId($user_id)
  {
    $data['deleted_flg'] = DELETED_ENABLE;
    DB::table($this->table)
      ->where('user_id', $user_id)
      ->update($data);
  }

  public function changeMailContactUserReadAt($user_id, $id)
  {
    $result = DB::table($this->table)
      ->where($this->table . '.id', $id)
      ->where($this->table . '.user_id', $user_id)
      ->where($this->table . '.deleted_flg', DELETED_DISABLE)
      ->first();

    if (is_null($result->user_read_at)) {
      $data['user_read_at'] = \Carbon\Carbon::now()->toDateTimeString();
      DB::table($this->table)
        ->where('id', $id)
        ->update($data);
    }
  }

  public function getMailContactByIdUser($user_id, $mail_id)
  {
    $result = DB::table($this->table)
      ->where($this->table . '.id', $mail_id)
      ->where($this->table . '.user_id', $user_id)
      ->where($this->table . '.deleted_flg', DELETED_DISABLE)
      ->first();

    return $result;
  }

  public function adminReadMailByUserId($user_id)
  {
    $data['updated_at'] = \Carbon\Carbon::now()->toDateTimeString();
    $data['admin_read_at'] = \Carbon\Carbon::now()->toDateTimeString();

    DB::table($this->table)
      ->where('user_id', $user_id)
      ->where('status', MAIL_CONTACT_USER_SEND)
      ->where('deleted_flg', DELETED_DISABLE)
      ->update($data);
  }

  public function adminReadMailGuest($mail_guest)
  {
    $data['updated_at'] = \Carbon\Carbon::now()->toDateTimeString();
    $data['admin_read_at'] = \Carbon\Carbon::now()->toDateTimeString();

    DB::table($this->table)
      ->where('mail_from_address', $mail_guest)
      ->where('status', MAIL_CONTACT_USER_SEND)
      ->where('deleted_flg', DELETED_DISABLE)
      ->update($data);
  }

  public function deleteMailContactUser($user_id, $mail_id)
  {
    $data['deleted_flg'] = DELETED_ENABLE;
    DB::table($this->table)
      ->where('user_id', $user_id)
      ->where('id', $mail_id)
      ->update($data);
  }

  public function getMailGuest($input)
  {
    $result = DB::table($this->table)
      ->where($this->table . '.user_id', GUEST_0)
      ->where($this->table . '.deleted_flg', DELETED_DISABLE);

    // start_date
    if (isset($input['start_date']) && !is_null($input['start_date']) && (strlen($input['start_date']) > 0)) {
      $result->where('created_at', '>=', $input['start_date']);
    }

    // start_end
    if (isset($input['start_end']) && !is_null($input['start_end']) && (strlen($input['start_end']) > 0)) {
      $result->where('created_at', '<=', $input['start_end']);
    }

    // Mail Pc
    if (isset($input['mail_pc']) && !is_null($input['mail_pc']) && (strlen($input['mail_pc']) > 0)) 
    {
      if(strpos(strtolower(trim($input['mail_pc'])), strtolower('@gmail'))!==FALSE)
      {
        $user = new User();
        $mail_pc = trim($input['mail_pc']);
        $mail_pc_rep = $user->replaceMailGoogle($mail_pc);
        $result->where(function($q) use ($mail_pc, $mail_pc_rep)
        {
            $q->where('mail_from_address', 'like', "%{$mail_pc}%")
            ->orWhere('mail_from_address', 'like', "%{$mail_pc_rep}%");
        })
        ->orWhere(function ($q) use ($mail_pc, $mail_pc_rep)
        {
          $q->where('mail_to_address', 'like', "%{$mail_pc}%")
            ->orWhere('mail_to_address', 'like', "%{$mail_pc_rep}%");          
        }
        );
      }
      else
      {
         // Or where         
       $mail_pc = trim($input['mail_pc']);
        $result->where(function ($result) use ($mail_pc) {
          return $result->where('mail_from_address', 'like', "%{$mail_pc}%")
            ->orWhere('mail_to_address', 'like', "%{$mail_pc}%");
        });
      }      
     
    }


    // keyword
    if (isset($input['keyword']) && !is_null($input['keyword']) && (strlen($input['keyword']) > 0)) {
      $keyword = trim($input['keyword']);
      // Or where
      $result->where(function ($result) use ($keyword) {
        return $result->where('mail_title', 'like', "%{$keyword}%")
          ->orWhere('mail_body', 'like', "%{$keyword}%")
          ->orWhere('mail_from_address', 'like', "%{$keyword}%")
          ->orWhere('mail_from_name', 'like', "%{$keyword}%");
      });
    }

    // read unread
    if (isset($input["read_unread"])) {
      switch ($input["read_unread"]) {
        case READ:
          $result->whereNotNull('admin_read_at');
          break;

        case UNREAD:
          $result->whereNull('admin_read_at');
          break;
      }
    }

    // order
    if (isset($input["order"])) {
      switch ($input["order"]) {
        case "created_at_asc":
          $result->orderBy('created_at', 'ASC');
          break;

        case "created_at_desc":
          $result->orderBy('created_at', 'DESC');
          break;
      }
    } else {
      $result->orderBy('created_at', 'DESC');
    }

    $result = $result
      ->get()
      ->toArray();
    return $result;
  }

  public function searchMailContactByCondition($input, $page, $limit)
  {    
    $result = DB::table($this->table)
      ->join('users', 'mail_contact.user_id', '=', 'users.id')
      ->join('user_activity', 'mail_contact.user_id', '=', 'user_activity.user_id')
      ->select("mail_contact.*", "users.login_id as login_id", "users.media_code as media_code",
        "users.user_stage_id as user_stage_id",
        "user_activity.deposit_number as deposit_number", "user_activity.payment_number as payment_number")
      ->where('mail_contact.deleted_flg', DELETED_DISABLE);
    // ->orderBy('mail_contact.created_at','DESC');
    // start_date
    if (isset($input['start_date']) && !is_null($input['start_date']) && (strlen($input['start_date']) > 0)) {
      $result->where('mail_contact.created_at', '>=', $input['start_date']);
    }
    // start_end
    if (isset($input['start_end']) && !is_null($input['start_end']) && (strlen($input['start_end']) > 0)) {
      $result->where('mail_contact.created_at', '<=', $input['start_end']. " 23:59:59"); 
    }
    // Login Id
    if (isset($input['login_id']) && !is_null($input['login_id']) && (strlen($input['login_id']) > 0)) {
      $result->where('users.login_id', 'like', "%{$input['login_id']}%");
    }
    // Mail Pc
    if (isset($input['mail_pc']) && !is_null($input['mail_pc']) && (strlen($input['mail_pc']) > 0))
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
    }

    // member_level
    if (isset($input['member_level']) && !is_null($input['member_level']) && (strlen($input['member_level']) > 0)) {
      $result->where('users.member_level', '=',$input['member_level'] );//'like', "%{$input['member_level']}%");
    }

    // media_code
    if (isset($input['media_code']) && !is_null($input['media_code']) && (strlen($input['media_code']) > 0)) {
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
         
          //$result->where('users.user_stage_id', 'like', "%{$input['user_stage']}%");
        }
      }
    }

    // keyword
    if (isset($input['keyword']) && !is_null($input['keyword']) && (strlen($input['keyword']) > 0)) {
      $keyword = trim($input['keyword']);
      // Or where
      $result->where(function ($result) use ($keyword) {
        return $result->where('users.login_id', 'like', "%{$keyword}%")
          ->orWhere('mail_contact.mail_title', 'like', "%{$keyword}%")
          ->orWhere('mail_contact.mail_body', 'like', "%{$keyword}%")
          ->orWhere('mail_contact.mail_from_address', 'like', "%{$keyword}%")
          ->orWhere('mail_contact.mail_from_name', 'like', "%{$keyword}%")
          ->orWhere('users.media_code', 'like', "%{$keyword}%")
          ->orWhere('users.mail_pc', 'like', "%{$keyword}%");
      });
    }    

    // read unread
    if (isset($input["read_unread"])) {
      switch ($input["read_unread"]) {
        case READ:
          $result->whereNotNull('mail_contact.admin_read_at');
          break;

        case UNREAD:
          $result->whereNull('mail_contact.admin_read_at');
          break;
      }
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
    if (isset($input["order"])) {
      switch ($input["order"]) {
        case "created_at_asc":
          $result->orderBy('mail_contact.created_at', 'ASC');
          break;

        case "created_at_desc":
          $result->orderBy('mail_contact.created_at', 'DESC');
          break;
      }
    } else {
      $result->orderBy('mail_contact.created_at', 'DESC');
    }

    if($page!==null && $limit!==null)
    {
      $offset = $page * $limit;
      $result->limit($limit)->offset($offset);
    }
    $result = $result->get()->toArray();
    return $result;
  }

   public function getNumberMailUnread()
  {
    $obj_mail_ban = new MailBan();
    $arr_mail = DB::table($this->table)
      ->join('users', $this->table . '.user_id', '=', 'users.id')
      ->whereNull($this->table . '.admin_read_at')
      ->where($this->table . '.deleted_flg', DELETED_DISABLE)
      ->get()
      ->toArray();

    foreach ($arr_mail as $key => $item) {
      $is_mail_ban = $obj_mail_ban->isMailBan($item->mail_from_address);
      if ($is_mail_ban) {
        unset($arr_mail[$key]);
      }
    }

    $number = count($arr_mail);

    $number_mail_guest = DB::table($this->table)
      ->where($this->table . '.user_id', GUEST_0)
      ->where($this->table . '.deleted_flg', DELETED_DISABLE)
      ->whereNull($this->table . '.admin_read_at')
      ->count();
    
    return $number + $number_mail_guest;
  }

  public function searchUserIdSendMailContactByCondition($input)
  {
    $result = DB::table($this->table)
      ->join('user_activity', 'mail_contact.user_id', '=', 'user_activity.user_id')
      ->join('users', 'mail_contact.user_id', '=', 'users.id')      
      ->select("users.id")
      ->where('mail_contact.deleted_flg', DELETED_DISABLE);
    // ->orderBy('mail_contact.created_at','DESC');
    // start_date
    if (isset($input['start_date']) && !is_null($input['start_date']) && (strlen($input['start_date']) > 0)) {
      $result->where('mail_contact.created_at', '>=', $input['start_date']);
    }
    // start_end
    if (isset($input['start_end']) && !is_null($input['start_end']) && (strlen($input['start_end']) > 0)) {
      $result->where('mail_contact.created_at', '<=', $input['start_end']. " 23:59:59"); 
    }
    // Login Id
    if (isset($input['login_id']) && !is_null($input['login_id']) && (strlen($input['login_id']) > 0)) {
      $result->where('users.login_id', '=', $input['login_id']);
    }
    // Mail Pc
    if (isset($input['mail_pc']) && !is_null($input['mail_pc']) && (strlen($input['mail_pc']) > 0))
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
    }

    // member_level
    if (isset($input['member_level']) && !is_null($input['member_level']) && (strlen($input['member_level']) > 0)) {
      $result->where('users.member_level', '=',$input['member_level'] );//'like', "%{$input['member_level']}%");
    }

    // media_code
    if (isset($input['media_code']) && !is_null($input['media_code']) && (strlen($input['media_code']) > 0)) {
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
         
          //$result->where('users.user_stage_id', 'like', "%{$input['user_stage']}%");
        }
      }
    }

    // keyword
    if (isset($input['keyword']) && !is_null($input['keyword']) && (strlen($input['keyword']) > 0)) {
      $keyword = trim($input['keyword']);
      // Or where
      $result->where(function ($result) use ($keyword) {
        return $result->where('users.login_id', 'like', "%{$keyword}%")
          ->orWhere('mail_contact.mail_title', 'like', "%{$keyword}%")
          ->orWhere('mail_contact.mail_body', 'like', "%{$keyword}%")
          ->orWhere('mail_contact.mail_from_address', 'like', "%{$keyword}%")
          ->orWhere('mail_contact.mail_from_name', 'like', "%{$keyword}%")
          ->orWhere('users.media_code', 'like', "%{$keyword}%")
          ->orWhere('users.mail_pc', 'like', "%{$keyword}%");
      });
    }    

    // read unread
    if (isset($input["read_unread"])) {
      switch ($input["read_unread"]) {
        case READ:
          $result->whereNotNull('mail_contact.admin_read_at');
          break;

        case UNREAD:
          $result->whereNull('mail_contact.admin_read_at');
          break;
      }
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
    /*if (isset($input["order"])) {
      switch ($input["order"]) {
        case "created_at_asc":
          $result->orderBy('mail_contact.created_at', 'ASC');
          break;

        case "created_at_desc":
          $result->orderBy('mail_contact.created_at', 'DESC');
          break;
      }
    } else {
      $result->orderBy('mail_contact.created_at', 'DESC');
    }*/

    $result = $result->distinct()->get()->toArray();
    return $result;
  }  
}
