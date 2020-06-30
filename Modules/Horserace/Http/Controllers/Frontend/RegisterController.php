<?php
/**
 * Date: 2018-10-09
 */

namespace Modules\Horserace\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Horserace\Entities\User;
use Modules\Horserace\Http\Requests\frontend\RegisterRequest;
use Modules\Horserace\Http\Requests\frontend\FogetPasswordRequest;
use Modules\Horserace\Repositories\MailBanRepositories;
use Modules\Horserace\Repositories\UserRepositories;
use Modules\Horserace\Entities\MailRegisterDetail;

class RegisterController extends Controller
{
    public function registerUser(RegisterRequest $request,
        UserRepositories $userRepositories,
        MailBanRepositories $mailBanRepositories) {
        $input = $request->all();
        
        // Check mail ban
        $result = $mailBanRepositories->checkMailBan(trim($input["email"]));       
        

        if ($result["status"] == "danger") {
            $data["status"] = $result;
            return view('horserace::frontend.before_login.entry', compact('data'));
        }
        $obj_user = new User();
        $obj_mail_register = new MailRegisterDetail();
        $mail_new = strtolower(trim($input["email"]));

        if(strpos(strtolower($mail_new), strtolower('@gmail'))!==FALSE)
        {
            $mail_new = $obj_user->replaceMailGoogle($mail_new);         
            $list_user_mail_pc_google = $obj_user->getUserByMailPcGoogle();
            foreach($list_user_mail_pc_google as $user_mail)
            {
                $mail_exit = $obj_user->replaceMailGoogle($user_mail->mail_pc);                
                if(strcmp(strtoupper($mail_exit), strtoupper($mail_new))==0) 
                {
                    $data["status"] = "exit";
                    return view('horserace::frontend.before_login.entry', compact('data'));
                }
            }  
            
            
            $list_user_mail_mobile_google = $obj_user->getUserByMailMobileGoogle();
            foreach($list_user_mail_mobile_google as $user_mail)
            {
                $mail_exit = $obj_user->replaceMailGoogle($user_mail->mail_pc);
                if(strcmp(strtoupper($mail_exit), strtoupper($mail_new))==0) 
                {
                    $data["status"] = "exit";
                    return view('horserace::frontend.before_login.entry', compact('data'));
                }
            }
            
           /* $list_user_mail_register_google = $obj_mail_register->getMailRegisterDetailByMailToAddressGoogle();
            foreach($list_user_mail_register_google as $mail_reg)
            {
                $mail_exit = $obj_user->replaceMailGoogle($mail_reg->mail_to_address);
                if(strcmp(strtoupper($mail_exit), strtoupper($mail_new))==0) 
                {
                    $data["status"] = "exit";
                    return view('horserace::frontend.before_login.entry', compact('data'));
                }
            }*/    
                 
        }
        else
        {
            if($obj_user->getUserByMailPcNew($mail_new) || $obj_user->getUserByMailMobile($mail_new)||$obj_mail_register->getMailRegisterDetailByMailToAddress($mail_new))
            {
               $data["status"] = "exit";
               return view('horserace::frontend.before_login.entry', compact('data'));
            }

        }


        /*$obj_mail_register = new MailRegisterDetail();
        $input["email"] = trim($input["email"]);
        if(strpos($input["email"], '@gmail')!==FALSE)
        {            
            $mail_name_before = substr($input["email"],0,strpos($input["email"], '@gmail')+1);
            $mail_name_before_replace = str_replace('.','',$mail_name_before); 
            $input["email"] = str_replace($mail_name_before, $mail_name_before_replace, $input["email"]);
        }
        if($obj_user->getUserByMailPcNew($input["email"]) || $obj_user->getUserByMailMobile($input["email"])||$obj_mail_register->getMailRegisterDetailByMailToAddress($input["email"]))
        {
            $data["status"] = "exit";
            return view('horserace::frontend.before_login.entry', compact('data'));
        }*/        

        //get ip address
        $ip = $_SERVER['REMOTE_ADDR'];

        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }

        // Data create user
        $data = [
            "mail_pc" => $mail_new,
            "ip" => $ip,
            "user_agent" => $_SERVER['HTTP_USER_AGENT'],
            "media_code" => $input["ref"],
        ];
        $userRepositories->feRegisterUser($data);

        $data["status"] = "success";

        return view('horserace::frontend.before_login.entry', compact('data'));
    }

    public function registerUserBySendMail($mail)
    {
        // Check have mail
        $obj_user = new User();
        $obj_user_rep = new UserRepositories();

        if (!($obj_user->haveMailPc($mail))) {
            $data = [
                "mail_pc" => $mail,
                "ip" => null,
                "user_agent" => null,
                "media_code" => MEDIA_DEFAULT,
            ];
            $obj_user_rep->feRegisterUser($data);
        } else {
            nghia_log('mail register mail da dang ky::::' . $mail);
        }
    }

    public function forgetPassword(FogetPasswordRequest $request)
    {
        $inputs = $request->all();
        $mail = trim($inputs['email']);

        $obj_user_rep = new UserRepositories();

        $result = $obj_user_rep->sendMailForgetPassword($mail);

        return view('horserace::frontend.before_login.pass', compact('result'));
    }
}
