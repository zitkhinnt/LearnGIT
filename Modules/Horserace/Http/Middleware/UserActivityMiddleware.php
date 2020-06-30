<?php

namespace Modules\Horserace\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Horserace\Entities\UserActivity;
use Modules\Horserace\Entities\UserDailyAccessHistory;
use Modules\Horserace\Entities\MailBulkDetail;
use Modules\Horserace\Entities\MailBulkDone;

class UserActivityMiddleware
{
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request $request
   * @param  \Closure $next
   * @return mixed
   */
  public function handle(Request $request, Closure $next)
  {
    // check member_level except
    if (Auth::user()->member_level == MEMBER_LEVEL_EXCEPT) {
      Auth::guard('web')->logout();
      return redirect()->route('login', '#a02')->with([
        'flash_level' => "danger",
        'flash_message' => __('horserace::be_msg.account_fail_member_level_except')
      ]);
    }

    if (Auth::check()) {
      $obj_user_activity = new UserActivity();
      $obj_user_daily_access_history = new UserDailyAccessHistory();

      Auth::user()->user_point = $obj_user_activity->getUserActivityByUserId(Auth::user()->id)->point;

      /**
       * update user_activity: last_access_time
       * update user_daily_access_history: number_access
       */
      $date = \Carbon\Carbon::now()->toDateTimeString();
      $date_format = date("Y-m-d", strtotime($date));

      // update user_activity
      $data_user_activity = [
        'last_access_time' => $date,
      ];
      $obj_user_activity->updateUserActivity(Auth::user()->id, $data_user_activity);

      // update user_daily_access_history
      $user_daily_access_history_id = $obj_user_daily_access_history->getUserDailyAccessHistoryByLoginIdAndAccessDate(Auth::user()->login_id, $date_format);

      //get ip address
      $ip = $_SERVER['REMOTE_ADDR'];

      if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
      } else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
      }

      $arr_user_daily_access = [
        'login_id' => Auth::user()->login_id,
        'ip' => $ip,
        'user_agent' => $_SERVER['HTTP_USER_AGENT'],
        'user_id' => Auth::user()->id,
        'access_date' => $date_format,
      ];      
      if (is_null($user_daily_access_history_id)) {
        $arr_user_daily_access["number_access"] = 1;
        $obj_user_daily_access_history->insertUserDailyAccessHistory($arr_user_daily_access);
      } else {
        $increase_number_access = $user_daily_access_history_id->number_access + 1;
        $arr_user_daily_access["number_access"] = $increase_number_access;
        $obj_user_daily_access_history->updateUserDailyAccessHistory($user_daily_access_history_id->id, $arr_user_daily_access);
      }
      
      if(isset($request->session()->all()["_previous"]))
      {
        if(isset($request->session()->all()["_previous"]["url"]))
        {     
          $url = $request->session()->all()["_previous"]["url"]; 
          if($url!=null)
          {
            $index_mail_id = strpos($url,'mail_id=');
            if($index_mail_id!==FALSE)
            {
              $mail_id = substr($url,$index_mail_id+8, strlen($url)-$index_mail_id-8);
              $array_mail_id = explode('&',$mail_id);
              $mail_id = $array_mail_id[0];
              if($mail_id!=null && is_numeric($mail_id))
              {
                  $obj_mail_bulk_detail = new MailBulkDetail();     
                  $obj_mail_bulk_done = new MailBulkDone();

                  $mail_bulk_detal = $obj_mail_bulk_detail->getMailBulkDetailByIdUserIdMailBulk(Auth::user()->id, $mail_id);
                  if ($mail_bulk_detal!=null)
                  {     
                    $array_mail_bulk_detail=[];        
                    if(is_null($mail_bulk_detal->read_at))
                    {
                      $obj_mail_bulk_done->addNumberReadByMailBulkId($mail_id);
                      $array_mail_bulk_detail = (array)$mail_bulk_detal;
                      $array_mail_bulk_detail['read_at'] = \Carbon\Carbon::now()->toDateTimeString();
                      $obj_mail_bulk_detail->changeMailBulkReadAt(Auth::user()->id, $mail_bulk_detal->id); 
                      sleep(1);
                      $obj_mail_bulk_detail->updateMailBulkDetail($mail_bulk_detal->id, $array_mail_bulk_detail);          
                    }
                    else
                    {
                      $read_at = $mail_bulk_detal->read_at;
                      $updated_at = $mail_bulk_detal->updated_at;
                      if($updated_at<=$read_at)
                      {
                        $array_mail_bulk_detail = (array)$mail_bulk_detal;
                        $obj_mail_bulk_done->addNumberReadByMailBulkId($mail_id);
                        $obj_mail_bulk_detail->updateMailBulkDetail($mail_bulk_detal->id, $array_mail_bulk_detail);
                      }
                    }
                  }
                  
              }
            }

          }
        }
      }
      
      return $next($request);
    } else {
      return true;
      // return redirect('/admin/dashboard');
    }
  }
}
