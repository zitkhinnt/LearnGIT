<?php
/**
 * Date 2018-09-10
 */

namespace Modules\Horserace\Repositories;

use Hash;
use DB;
use Modules\Horserace\Entities\Entrance;
use Modules\Horserace\Entities\MailTemplate;
use Modules\Horserace\Entities\Media;
use Modules\Horserace\Entities\TransactionDeposit;
use Modules\Horserace\Entities\TransactionGift;
use Modules\Horserace\Entities\TransactionPayment;
use Modules\Horserace\Entities\User;
use Modules\Horserace\Entities\UserActivity;
use Modules\Horserace\Entities\UserStage;
use Modules\Horserace\Http\Controllers\Backend\MailableController;
use Modules\Horserace\Http\Controllers\Backend\MailController;
use Modules\Horserace\Entities\MailRegisterDetail;
use Modules\Horserace\Repositories\UserDailyAccessHistoryRepositories;
class UserRepositories
{
    public function userStore($input)
    {
        $obj_user = new User();
        $obj_entrance = new Entrance();
        $obj_entrance_repositories = new EntranceRepositories();
        $obj_user_activity = new UserActivity();
        $entrance_default = $obj_entrance->getEntranceDefault();

        // User
        $arr_user = [
            'login_id' => trim($input['login_id']),
            'user_key' => trim($input['user_key']),
            'password' => Hash::make($input['password']),
            'nickname' => trim($input['nickname']),
            'password_text' => trim($input['password']),
            'member_level' => isset($input["member_level"]) ? $input["member_level"] : MEMBER_LEVEL_TRIAL,
            'mail_pc' => trim($input['mail_pc']),
            'stop_mail' => isset($input["stop_mail"]) ? $input["stop_mail"] : STOP_MAIL_DISABLE,
            'mail_mobile' => trim($input['mail_mobile']),
            'age' => empty($input['age']) ? AGE_USER_UNKNOW : trim($input['age']),
            'gender' => isset($input['gender']) ? trim($input['gender']) : SEX_UNKNOW,
            'memo' => trim($input['memo']),
            'media_code' => trim($input["media_code"]),
            'entrance_id' => isset($input["entrance_id"]) ? $input["entrance_id"] : $entrance_default->id,
            'provider_user_id' => $input['provider_user_id'] ?? '',
        ];

        if (!empty($input['register_time'])) {
            $arr_user['register_time'] = $input['register_time'];
        }

        // User stage
       // $arr_user["user_stage_id"] = (isset($input["user_stage_id"]) && is_array($input["user_stage_id"])) ? '0,' . implode(SEPARATE, $input["user_stage_id"]) : '0';
        

        if (trim($input["id"]) != 0) {
            // Edit

             // User stage
            if(isset($input["user_stage_id"]) )
            { 
                if(is_array($input["user_stage_id"]))
                    $arr_user["user_stage_id"]='0,' . implode(SEPARATE, $input["user_stage_id"]); 
                else
                    $arr_user["user_stage_id"] = $input["user_stage_id"];

            }  
            // Update user            
            $obj_user->updateUser(trim($input["id"]), $arr_user);

            $result = [
                'user' => [
                    'id' => $input["id"],
                    'login_id' => $input['login_id'],
                ],
                'status' => 'success',
                'message' => __("horserace::be_msg.edit_user_success"),
            ];
        } else {
            // Add
            // User send mail
            $arr_user["send_mail"] = SEND_MAIL_NOT;

            // User activity
            $arr_user_activity = [
                "point" => 0,
                "user_agent" => $input['user_agent'],
                "ip" => $input['ip'],
            ];          
            
            // Create user
            // User stage
            if(isset($input["user_stage_id"]) )
            { 
                if(is_array($input["user_stage_id"]))
                    $arr_user["user_stage_id"]='0,' . implode(SEPARATE, $input["user_stage_id"]); 
                else
                    $arr_user["user_stage_id"] = $input["user_stage_id"];

            }  
            else
                $arr_user["user_stage_id"] = '0';

            $user_id = $obj_user->insertUser($arr_user);
            $arr_user_activity['user_id'] = $user_id;

            // Create user active
            $obj_user_activity->insertUserActivity($arr_user_activity);

            // Entrance
            $obj_entrance_repositories->userRegisterEntrance($user_id);

            $result = [
                'user' => [
                    'id' => $user_id,
                    'login_id' => $input['login_id'],
                ],
                "status" => "success",
                "message" => __("horserace::be_msg.add_user_success"),
            ];
        }

        return $result;
    }

    public function getEditUser($id)
    {
        $obj_user = new User();
        $user = $obj_user->getDetailUserById($id);
        // User stage
        $user_stage = explode(",", $user->user_stage_id);

        $arr_user_stage = array();
        foreach ($user_stage as $item) {
            $arr_user_stage[$item] = $item;
        }

        $user->arr_user_stage = $arr_user_stage;
        return $user;
    }

    public function getListUser()
    {
        $obj_user = new User();
        $list_user = $obj_user->getUser();
        return $list_user;
    }

    public function getSearchUser($data)
    {
        $obj_user = new User();
        $obj_user_stage = new UserStage();
        $list_user = $obj_user->searchUserByCondition($data);
        $userDailyAccessHistoryRepo = new UserDailyAccessHistoryRepositories();
        // User stage
        $list_user_stage = $obj_user_stage->getUserStage();
        $arr_user_stage = array();
        foreach ($list_user_stage as $item) {
            $arr_user_stage[$item->id] = $item;
        }

        // Stage to string
        foreach ($list_user as $key => $user) {
            $stage = explode(",", $user->user_stage_id);
            $user_stage_str = '';
            foreach ($stage as $item) {
                if (isset($arr_user_stage[$item])) {
                    $user_stage_str .= $arr_user_stage[$item]->name . ', ';
                }
            }
            $list_user[$key]->user_stage_str = rtrim($user_stage_str, ", ");

            // user access history
            $sumAccess = $userDailyAccessHistoryRepo->sumUserAccessHistorybyUser($user->id);
            $list_user[$key]->last_access_date = $sumAccess['last_access_date'];
            $list_user[$key]->total_number_access = $sumAccess['total_number_access'];
        }

        return $list_user;
    }

    public function getSearchUserAjax($data)
    {
      $obj_user = new User();
      $obj_user_stage = new UserStage();
      $list_user = $obj_user->searchUserAjaxByCondition($data);
      // User stage
      $list_user_stage = $obj_user_stage->getUserStage();
      $arr_user_stage = array();
      foreach ($list_user_stage as $item) {
        $arr_user_stage[$item->id] = $item;
      }
      // Stage to string
      foreach ($list_user['result'] as $key => $user) {
        $stage = explode(",", $user->user_stage_id);
        $user_stage_str = '';
        foreach ($stage as $item) {
          if (isset($arr_user_stage[$item])) {
            $user_stage_str .= $arr_user_stage[$item]->name . ', ';
          }
        }
        $list_user['result'][$key]->user_stage_str = rtrim($user_stage_str, ", ");
      }

      return $list_user;
    }

    public function deletedUserById($user_id)
    {
        $obj_user = new User();
        $obj_user->deleteUser($user_id);

        $result = [
            "status" => "success",
            "message" => __("horserace::be_msg.deleted_user_interim_success"),
        ];

        return $result;
    }

    public function deletedUserInterim($input)
    {
        $obj_user = new User();

        if (isset($input["deleted"])) {
            // List user deleted
            $list_user_deleted = $input["deleted"];
            foreach ($list_user_deleted as $user_id) {
                // Deleted user
                $obj_user->deleteUser($user_id);
            }
        }

        $result = [
            "status" => "success",
            "message" => __("horserace::be_msg.deleted_user_interim_success"),
        ];

        return $result;
    }

    public function getTransUser($user_id)
    {
        $obj_trans_depsoit = new TransactionDeposit();
        $obj_trans_payment = new TransactionPayment();
        $obj_trans_gift = new TransactionGift();

        $trans = [
            "all" => array(),
            "deposit" => array(),
            "payment" => array(),
            "gift" => array(),
        ];

        // Deposit
        $trans_deposit = $obj_trans_depsoit->getTransactionDepositByUserId($user_id);
        foreach ($trans_deposit as $deposit) {
            $deposit->type = TRANSACTION_DEPOSIT;
            $trans["all"][] = (array) $deposit;
            $trans["deposit"][] = (array) $deposit;
        }

        // Payment
        $trans_payment = $obj_trans_payment->getTransactionPaymentByUserId($user_id);
        foreach ($trans_payment as $payment) {
            $payment->type = TRANSACTION_PAYMENT;
            $trans["all"][] = (array) $payment;
            $trans["payment"][] = (array) $payment;
        }

        // Payment
        $trans_gift = $obj_trans_gift->getTransactionGiftByUserId($user_id);
        foreach ($trans_gift as $gift) {
            $gift->type = TRANSACTION_GIFT;
            $trans["all"][] = (array) $gift;
            $trans["gift"][] = (array) $gift;
        }

        sortArrayByKey($trans["all"], "updated_at", true, false);

        return $trans;
    }

    // update infomation user
    public function feRegisterUser($input)
    {
        $obj_user = new User();
        $obj_media = new Media();

        // check media_code ? get : default
        $media = $obj_media->getMediaByCode($input["media_code"]);
        $media_code = $input["media_code"];
        if (empty($media)) {
            $media_code = MEDIA_DEFAULT;
        }

        // Check mail pc
        if ($obj_user->haveMailPc(trim($input["mail_pc"]))) {

            $obj_mail_controller = new MailController();
            // Send mail for user
            $user = $obj_user->getUserByMailPc(trim($input["mail_pc"]));

            $obj_mail_controller->sendMailRegister($user->id);

        } else {
            $login_id = getUniqueCodeNumber(LENGTH_LOGIN_ID, 'users', 'login_id');
            $user_key = getUniqueString(LENGTH_USER_KEY, 'users', 'user_key');
            $password = generatePassword(LENGTH_PASSWORD);

            $arr_user = [
                'id' => 0,
                'login_id' => $login_id,
                'user_key' => $user_key,
                'password' => trim($password),
                'nickname' => null,
                'member_level' => MEMBER_LEVEL_TRIAL,
                'mail_pc' => $input["mail_pc"],
                'mail_mobile' => null,
                'age' => AGE_USER_20,
                'gender' => MALE,
                'memo' => null,
                'user_agent' => $input["user_agent"],
                'ip' => $input["ip"],
                //add media code
                'media_code' => $media_code,                
                //'register_time' => \Carbon\Carbon::now()->toDateTimeString(),
            ];

            nghia_log('feRegisterUser::::' . print_r($arr_user, true));
            $this->userStore($arr_user);

            // $obj_mail_controller->sendMailRegister($user->id);
        }
    }

// update infomation user
    public function feUserForgetPass($mail)
    {
        $obj_user = new User();
        $obj_media = new Media();

        // check media_code ? get : default
        //$media = $obj_media->getMediaByCode($input["media_code"]);
        //$media_code = $input["media_code"];
        //if (empty($media)) {
        //  $media_code = MEDIA_DEFAULT;
        //}

        $user = $obj_user->getUserByMailPc($mail);
        if (!$user || !isset($user->id)) {
            return;
        } else {
            $obj_mail_controller = new MailController();
            $obj_mail_controller->sendMailRegister($user->id);
        }
    }

    public function feRegisterUserBySocialite($input)
    {
        $obj_user = new User();        
        $obj_entrance = new Entrance();
        $entrance_default = $obj_entrance->getEntranceDefault();

        $checkEmail = $obj_user->getUserByMailPc($input["mail_pc"]);
        if($checkEmail){
            return false;
        }
        // Register or Update User
        if ($user = $obj_user->getUserSocial(trim($input["provider_user_id"]))) {
            // Update user
            $arr_user = [
                'id' => $user->id,
                'login_id' => $user->login_id,
                'user_key' => $user->user_key,
                'password' => $user->password_text,
                'password_text' => $user->password_text,
                'nickname' => $input['nickname'] ?? $user->nickname,
                'provider_user_id' => $user->provider_user_id,
                'member_level' => $user->member_level,
                'mail_pc' => $input["mail_pc"] ?? $user->mail_pc,
                'mail_mobile' => $input["mail_mobile"] ?? $user->mail_mobile,
                'age' => AGE_USER_UNKNOW,
                'gender' => SEX_UNKNOW,
                'memo' => null,
                'user_agent' => $input["user_agent"] ?? '',
                'ip' => $input["ip"] ?? '',
                //add media code
                'media_code' => $input["media_code"] ?? $user->media_code,
                'entrance_id' => isset($input["entrance_id"]) ? $input["entrance_id"] : $entrance_default->id,
                'user_stage_id' => $user->user_stage_id,
            ];

            // Check user register
            if (is_null($user->register_time)) {
                $arr_user["register_time"] = \Carbon\Carbon::now()->toDateTimeString();
            }

        } else {
            // Register user
            $login_id = getUniqueCodeNumber(LENGTH_LOGIN_ID, 'users', 'login_id');
            $user_key = getUniqueString(LENGTH_USER_KEY, 'users', 'user_key');
            $password = generatePassword(LENGTH_PASSWORD);

            $arr_user = [
                'id' => 0,
                'login_id' => $login_id,
                'user_key' => $user_key,
                'password' => trim($password),
                'password_text' => trim($password),
                'nickname' => $input['nickname'] ?? '',
                'provider_user_id' => $input['provider_user_id'],
                'member_level' => MEMBER_LEVEL_TRIAL,
                'mail_pc' => $input["mail_pc"] ?? '',
                'mail_mobile' => null,
                'age' => AGE_USER_UNKNOW,
                'gender' => SEX_UNKNOW,
                'memo' => null,
                'user_agent' => $input["user_agent"] ?? '',
                'ip' => $input["ip"] ?? '',
                //add media code
                'media_code' => $input["media_code"] ?? MEDIA_DEFAULT,
                'entrance_id' => isset($input["entrance_id"]) ? $input["entrance_id"] : $entrance_default->id,
                'register_time' => \Carbon\Carbon::now()->toDateTimeString(),
            ];

        }

        $result = $this->userStore($arr_user)['user'];

        $arr_user['id'] = $result['id'];
        $arr_user['login_id'] = $result['login_id'];

        return $arr_user;
    }

    public function updateInfo($input)
    {
        $obj_user = new User();

        $arr_user = [
            'nickname' => trim($input['nickname']),
            'gender' => isset($input['gender']) ? trim($input['gender']): SEX_UNKNOW,
            'age' => empty($input['age']) ? AGE_USER_UNKNOW : trim($input['age']),
        ];

        $obj_user->updateUser(trim($input['id']), $arr_user);
        $result = [
            'status' => 'success',
            'message' => __("horserace::be_msg.update_info_user_success"),
        ];
        return $result;
    }

    // update mail pc user
    public function updateMailPC($input)
    {
        $obj_user = new User();
        $obj_mail_register = new MailRegisterDetail();
        $mail_new = strtolower(trim($input["mail_pc"]));

        if(strpos(strtolower($mail_new), strtolower('@gmail'))!==FALSE)
        {
            $mail_new = $obj_user->replaceMailGoogle($mail_new);                      
            $list_user_mail_pc_google = $obj_user->getUserByMailPcGoogle();
            foreach($list_user_mail_pc_google as $user_mail)
            {
                $mail_exit = $obj_user->replaceMailGoogle($user_mail->mail_pc);
                if(strcmp(strtoupper($mail_exit), strtoupper($mail_new))==0) 
                {
                    $result = [
                        'status' => 'exit',
                        'message' => __("horserace::be_msg.email_exit"),
                    ];
                    return $result;
                }
            }  
            
            
            $list_user_mail_mobile_google = $obj_user->getUserByMailMobileGoogle();
            foreach($list_user_mail_mobile_google as $user_mail)
            {
                $mail_exit = $obj_user->replaceMailGoogle($user_mail->mail_pc);
                if(strcmp(strtoupper($mail_exit), strtoupper($mail_new))==0) 
                {
                    $result = [
                        'status' => 'exit',
                        'message' => __("horserace::be_msg.email_exit"),
                    ];
                    return $result;
                }
            }
            
           /* $list_user_mail_register_google = $obj_mail_register->getMailRegisterDetailByMailToAddressGoogle();
            foreach($list_user_mail_register_google as $mail_reg)
            {
                $mail_exit = $obj_user->replaceMailGoogle($mail_reg->mail_to_address);
                if(strcmp(strtoupper($mail_exit), strtoupper($mail_new))==0) 
                {
                    $result = [
                        'status' => 'exit',
                        'message' => __("horserace::be_msg.email_exit"),
                    ];
                    return $result;
                }
            } */      
                 
        }
        else
        {
            if($obj_user->getUserByMailPcNew($mail_new) || $obj_user->getUserByMailMobile($mail_new)||$obj_mail_register->getMailRegisterDetailByMailToAddress($mail_new))
            {
                $result = [
                    'status' => 'exit',
                    'message' => __("horserace::be_msg.email_exit"),
                ];
                return $result;
            }

        }

        $arr_user = [
            'mail_pc' => $mail_new,
        ];

        $obj_user->updateUser(trim($input['id']), $arr_user);
        $result = [
            'status' => 'success',
            'message' => __("horserace::be_msg.update_info_user_success"),
        ];
        return $result;
    }

    // update mail mobile user
    public function updateMailMobile($input)
    {
        $obj_user = new User();       
        
        $obj_mail_register = new MailRegisterDetail();
        $mail_new = strtolower(trim($input["mail_mobile"]));

        if(strpos(strtolower($mail_new), strtolower('@gmail'))!==FALSE)
        {   
            $mail_new = $obj_user->replaceMailGoogle($mail_new);        
            $list_user_mail_pc_google = $obj_user->getUserByMailPcGoogle();
            foreach($list_user_mail_pc_google as $user_mail)
            {
                $mail_exit = $obj_user->replaceMailGoogle($user_mail->mail_pc);
                if(strcmp(strtoupper($mail_exit), strtoupper($mail_new))==0) 
                {
                    $result = [
                        'status' => 'exit_email_mobile',
                        'message' => __("horserace::be_msg.email_exit"),
                    ];
                    return $result;
                }
            }  
            
            
            $list_user_mail_mobile_google = $obj_user->getUserByMailMobileGoogle();
            foreach($list_user_mail_mobile_google as $user_mail)
            {
                $mail_exit = $obj_user->replaceMailGoogle($user_mail->mail_pc);
                if(strcmp(strtoupper($mail_exit), strtoupper($mail_new))==0) 
                {
                    $result = [
                        'status' => 'exit_email_mobile',
                        'message' => __("horserace::be_msg.email_exit"),
                    ];
                    return $result;
                }
            }
            
            /*$list_user_mail_register_google = $obj_mail_register->getMailRegisterDetailByMailToAddressGoogle();
            foreach($list_user_mail_register_google as $mail_reg)
            {
                $mail_exit = $obj_user->replaceMailGoogle($mail_reg->mail_to_address);
                if(strcmp(strtoupper($mail_exit), strtoupper($mail_new))==0) 
                {
                    $result = [
                        'status' => 'exit_email_mobile',
                        'message' => __("horserace::be_msg.email_exit"),
                    ];
                    return $result;
                }
            } */        
                 
        }
        else
        {
            if($obj_user->getUserByMailPcNew($mail_new) || $obj_user->getUserByMailMobile($mail_new)||$obj_mail_register->getMailRegisterDetailByMailToAddress($mail_new))
            {
                $result = [
                    'status' => 'exit',
                    'message' => __("horserace::be_msg.email_exit"),
                ];
                return $result;
            }

        }

        $arr_user = [
            'mail_mobile' => $mail_new,
        ];

        $obj_user->updateUser(trim($input['id']), $arr_user);
        $result = [
            'status' => 'success',
            'message' => __("horserace::be_msg.update_info_user_success"),
        ];
        return $result;
    }

    // update password user
    public function updatePassword($input)
    {
        $obj_user = new User();

        $arr_user = [
            'password' => Hash::make(trim($input['password'])),
            'password_text' => trim($input['password']),
        ];

        $obj_user->updateUser(trim($input['id']), $arr_user);
        $result = [
            'status' => 'success',
            'message' => __("horserace::be_msg.update_info_user_success"),
        ];
        return $result;
    }

    public function sendMailForgetPassword($mail)
    {
        khanh_log('forget pass mail::::::' . $mail);
        if (empty($mail)) {
            return false;
        }

        $obj_user = new User();

        // Check mail pc
        if ($user = $obj_user->getUserByMailPcNew(trim($mail))) {
            khanh_log('forget pass user::::' . print_r($user, true));

            // send mail foget password
            $mail_template = new MailTemplate();
            $obj_mailable_controller = new MailableController();

            // forget mail template
            $forget_template = $mail_template->getMailTemplateByType(MAIL_TEMPLATE_TYPE_FORGET_PASSWORD);

            khanh_log('forget pass template::::' . print_r($forget_template, true));

            if (empty($forget_template) || !isset($forget_template[0])) {
                return false;
            } else {
                // get first template
                $forget_template = $forget_template[0];
            }

            // mail data
            $input = [
                "mail_template_register_id" => $forget_template->id,
                "mail_from_address" => $forget_template->mail_from_address,
                "mail_from_name" => $forget_template->mail_from_name,
                "mail_to_address" => $user->mail_pc,
                "mail_to_name" => $user->nickname,
                "mail_title" => $forget_template->mail_title,
                "mail_body" => $forget_template->mail_body,
            ];
            $data_replace = [
                'login_id' => $user->login_id,
                'password_text' => $user->password_text,
            ];

            // Send mail
            return $obj_mailable_controller->sendMailByMailable($input, $data_replace);

        } else {
            return false;
        }
    }

    public function sendMailChangePC($data)
    {
        // dd($input);
        if (empty($data['mail_pc'])) {
            return false;
        }

        $obj_user = new User();

        // Check mail pc
        if ($user = $obj_user->getUserByMailPcNew(trim($data['mail_pc']))) {
            // khanh_log('forget pass user::::' . print_r($user, true));

            // send mail foget password
            $mail_template = new MailTemplate();
            $obj_mailable_controller = new MailableController();

            // forget mail template
            $forget_template = $mail_template->getMailTemplateByType(MAIL_TEMPLATE_TYPE_CHANGE_MAIL_PC);

            khanh_log('forget pass template::::' . print_r($forget_template, true));

            if (empty($forget_template) || !isset($forget_template[0])) {
                return false;
            } else {
                // get first template
                $forget_template = $forget_template[0];
            }

            // mail data
            $input = [
                "mail_template_register_id" => $forget_template->id,
                "mail_from_address" => $forget_template->mail_from_address,
                "mail_from_name" => $forget_template->mail_from_name,
                "mail_to_address" => $data['new_mail_pc'],
                "mail_to_name" => $user->nickname,
                "mail_title" => $forget_template->mail_title,
                "mail_body" => $forget_template->mail_body,
            ];
            $data_replace = [
                'id' => $data['id'],
                'key_login' => $data['key_login'],
                'mail_pc' => $data['mail_pc'],
                'new_mail_pc' => $data['new_mail_pc'],
            ];

            // Send mail
            return $obj_mailable_controller->sendMailByMailable($input, $data_replace);

        } else {
            return false;
        }
    }
    public function searchUserNotSendMail($input)
    {
        $obj_user = new User();
        $list_user_not_send_mail = $obj_user->searchUserNotSendMailByCondition($input);
        return $list_user_not_send_mail;
    }

    public function summaryMediaDepositByNewPaymentUsersPeriod($time_start, $time_end)
    {
      $new_deposit_user = DB::table('transaction_deposit')
      ->select(DB::raw('user_id, updated_at, MIN(updated_at)'))
      ->where('status', APPLY)
        ->where('deleted_flg', DELETED_DISABLE)
        ->groupBy('user_id');

      return DB::table('users')
      ->select(DB::raw('users.media_code, count(DISTINCT td.user_id) as total_new_user_deposit'))
      ->joinSub($new_deposit_user, 'td', function ($join) {
        $join->on('users.id', '=', 'td.user_id');
      })
        ->where('td.updated_at', '>=', $time_start)
        ->where('td.updated_at', '<=', $time_end)
        ->where('users.deleted_flg', DELETED_DISABLE)
        ->groupBy('users.media_code')
        ->get()
        ->toArray();
    }

    public function summaryMediaDepositByNewPaymentUsers($year, $month)
    {
      $new_deposit_user = DB::table('transaction_deposit')
      ->select(DB::raw('user_id, updated_at, MIN(updated_at)'))
      ->where('status', APPLY)
        ->where('deleted_flg', DELETED_DISABLE)
        ->groupBy('user_id');

      return DB::table('users')
      ->select(DB::raw('users.media_code, count(DISTINCT td.user_id) as total_new_user_deposit'))
      ->joinSub($new_deposit_user, 'td', function ($join) {
        $join->on('users.id', '=', 'td.user_id');
      })
        ->whereRaw('YEAR(td.updated_at) =' . $year . ' AND MONTH(td.updated_at)=' . $month)
        ->where('users.deleted_flg', DELETED_DISABLE)
        ->groupBy('users.media_code')
        ->get()
        ->toArray();
    }

    public function summaryMediaDepositByNewPaymentAndNewRegisterUsersPeriod($time_start, $time_end)
    {
      $new_deposit_user = DB::table('transaction_deposit')
      ->select(DB::raw('user_id, updated_at, MIN(updated_at)'))
      ->where('status', APPLY)
        ->where('deleted_flg', DELETED_DISABLE)
        ->groupBy('user_id');

      return DB::table('users')
      ->select(DB::raw('users.media_code, count(DISTINCT td.user_id) as total_new_user_deposit_payment'))
      ->joinSub($new_deposit_user, 'td', function ($join) {
        $join->on('users.id', '=', 'td.user_id');
      })
        ->where('td.updated_at', '>=', $time_start)
        ->where('td.updated_at', '<=', $time_end)
        ->where('users.created_at', '>=', $time_start)
        ->where('users.created_at', '<=', $time_end)
        ->where('users.deleted_flg', DELETED_DISABLE)
        ->groupBy('users.media_code')
        ->get()
        ->toArray();
    }

    public function getDataSummaryRegisterDatetime($year, $month)
    {
      $obj_user = new User();
      $data = $obj_user->getSummaryUserRegisterDaily($year, $month);
      return $data;
    }

    public function summaryMediaDepositByNewPaymentAndNewRegisterUsers($year, $month)
    {
      $new_deposit_user = DB::table('transaction_deposit')
      ->select(DB::raw('user_id, updated_at, MIN(updated_at)'))
      ->where('status', APPLY)
        ->where('deleted_flg', DELETED_DISABLE)
        ->groupBy('user_id');

      return DB::table('users')
      ->select(DB::raw('users.media_code, count(DISTINCT td.user_id) as total_new_user_deposit_payment'))
      ->joinSub($new_deposit_user, 'td', function ($join) {
        $join->on('users.id', '=', 'td.user_id');
      })
        ->whereRaw('YEAR(td.updated_at) =' . $year . ' AND MONTH(td.updated_at)=' . $month)
        ->whereRaw('YEAR(users.created_at) =' . $year . ' AND MONTH(users.created_at)=' . $month)
        ->where('users.deleted_flg', DELETED_DISABLE)
        ->groupBy('users.media_code')
        ->get()
        ->toArray();
    }

}
