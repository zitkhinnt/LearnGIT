<?php

namespace Modules\Horserace\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Mail;
use Modules\Horserace\Emails\SendMail;
use Modules\Horserace\Emails\VerifyEmail;
use Modules\Horserace\Entities\User;
use Exception;

class MailableController extends Controller
{
  public function sendMailByMailable($data, $data_replace, $mail_bulk_id = null, $count = 0)
  {
    $count ++;
    if ($count > 3)
      return SEND_MAIL_STATUS_FAIL;
    
    if (!filter_var($data["mail_to_address"], FILTER_VALIDATE_EMAIL)) {
      mail_bulk_log('email invalid format, please check and stop mail:::' . $data["mail_to_address"]);
      report(new Exception('email invalid format, please check and stop mail:::' . $data["mail_to_address"], true));
      return SEND_MAIL_STATUS_FAIL;
    }

    // Replace mail
    $data['mail_body'] = $this->replaceMail($data['mail_body'], $data_replace, $mail_bulk_id);

    // Send mail by mailable
    try {
      usleep(500000);
      Mail::to($data['mail_to_address'])->send(new SendMail($data));
      mail_bulk_log('Mail send success:::' . $data["mail_to_address"]);
      return SEND_MAIL_STATUS_SUCCESS;
    } catch (\Exception $e) {
      mail_bulk_log('Mail send fail:::' . $e->getMessage() . ':::' . $data["mail_to_address"]);
      report(new Exception('Send mail ' . $data["mail_to_address"] . ' fail::::Msg: ' . $e->getMessage(), true));
      
      if ($e->getCode() == 530){
        $obj_user = new User();
        $user_info = $obj_user->getUserByMailPcNew($data['mail_to_address']);
        if ($user_info != null){
          $arr_user['stop_mail'] = STOP_MAIL_ENABLE;
          $obj_user->updateUser($user_info->id, $arr_user);
        }
        return SEND_MAIL_STATUS_FAIL;
      }

      if (strpos($e->getMessage(), 'Broken pipe') !== false) {
        Mail::getSwiftMailer()->getTransport()->stop();
        sleep(10);
      }

      sleep(5);
      return $this->sendMailByMailable($data, $data_replace, $mail_bulk_id, $count);
      // return SEND_MAIL_STATUS_FAIL;
    }
  }

  public function sendMailBulkByMailable($data, $data_replace, $mail_bulk_id = null)
  {
    $status = SEND_MAIL_STATUS_FAIL; // failed
    // Verify email
    //$verifyEmail = new VerifyEmail($data['mail_to_address'], $data['mail_from_address']);
    // Replace mail
    $data['mail_body'] = $this->replaceMail($data['mail_body'], $data_replace, $mail_bulk_id);

    $obj_user = new User();
    // Send mail by mailable
    try {
      Mail::to($data['mail_to_address'])->send(new SendMail($data));
      $data_send['status'] = SEND_MAIL_STATUS_SUCCESS;
      $data_send['log_error'] = NULL;
    } catch (\Exception $e) {
      $data_send['status'] = SEND_MAIL_STATUS_FAIL;
      $data_send['log_error'] = $e->getMessage();
    }
    return $data_send;
  }

  public function replaceMail($content, $data_replace, $mail_bulk_id = null)
  {
    $arr_mail_replace = [
      '%login_id%' => isset($data_replace["login_id"]) ? $data_replace["login_id"] : '',
      //'https://keirin-ch.com/free?h=%user_key%' => (isset($data_replace["user_key"]) ? 'https://keirin-ch.com/free?h='.$data_replace["user_key"] : '').($mail_bulk_id!=null?'&mail_id='.$mail_bulk_id:''),
      //'https://keirin-ch.com/free?h=%user_key%' =>'<a href="' . (isset($data_replace["user_key"]) ? 'https://keirin-ch.com/free?h='.$data_replace["user_key"] : '').($mail_bulk_id!=null?'&mail_id='.$mail_bulk_id:'') . '">' . (isset($data_replace["user_key"]) ? 'https://keirin-ch.com/free?h='.$data_replace["user_key"] : '').($mail_bulk_id!=null?'&mail_id='.$mail_bulk_id:'') . '</a>',
      url('free?h=%user_key%') => '<a href="' . (isset($data_replace["user_key"]) ? url('free?h=') . $data_replace["user_key"] : '') . ($mail_bulk_id != null ? '&mail_id=' . $mail_bulk_id : '') . '">' . (isset($data_replace["user_key"]) ? url('free?h=') . $data_replace["user_key"] : '') . ($mail_bulk_id != null ? '&mail_id=' . $mail_bulk_id : '') . '</a>',
      '%user_key%' => isset($data_replace["user_key"]) ? $data_replace["user_key"] : '',
      '%password%' => isset($data_replace["password_text"]) ? $data_replace["password_text"] : '',
      '%nickname%' => isset($data_replace["nickname"]) ? $data_replace["nickname"] : '',
      '%gender%' => isset($data_replace["gender"]) ? $data_replace["gender"] : '',
      '%media_code%' => isset($data_replace["media_code"]) ? $data_replace["media_code"] : '',
      '%age%' => isset($data_replace["age"]) ? ageToStr($data_replace["age"]) : '',
      '%member_level%' => isset($data_replace["member_level"]) ? memberLevelStr($data_replace["member_level"]) : '',
      '%mail_pc%' => isset($data_replace["mail_pc"]) ? $data_replace["mail_pc"] : '',
      '%mail_mobile%' => isset($data_replace["mail_mobile"]) ? $data_replace["mail_mobile"] : '',
      '%register_time%' => isset($data_replace["register_time"]) ? $data_replace["register_time"] : '',
      '%interim_register_time%' => isset($data_replace["interim_register_time"]) ? $data_replace["interim_register_time"] : '',
      '%user_deleted%' => isset($data_replace["user_deleted"]) ? $data_replace["user_deleted"] : '',
      '%user_point%' => isset($data_replace["user_point"]) ? number_format($data_replace["user_point"]) : '',
      '%login_number%' => isset($data_replace["login_number"]) ? $data_replace["login_number"] : '',
      '%last_login_time%' => isset($data_replace["last_login_time"]) ? $data_replace["last_login_time"] : '',
      '%last_access_time%' => isset($data_replace["last_access_time"]) ? $data_replace["last_access_time"] : '',
      '%first_payment_time%' => isset($data_replace["first_payment_time"]) ? $data_replace["first_payment_time"] : '',
      '%last_payment_time%' => isset($data_replace["last_payment_time"]) ? $data_replace["last_payment_time"] : '',
      '%prediction_name%' => isset($data_replace["prediction_name"]) ? $data_replace["prediction_name"] : '',
      '%prediction_point%' => isset($data_replace["prediction_point"]) ? number_format($data_replace["prediction_point"]) : '',
      '%gift_point%' => isset($data_replace["gift_point"]) ? number_format($data_replace["gift_point"]) : '',
      '%trans_point%' => isset($data_replace["trans_point"]) ? number_format($data_replace["trans_point"]) : '',
      '%trans_amount%' => isset($data_replace["trans_amount"]) ? number_format($data_replace["trans_amount"]) : '',
      '%prediction_id%' => isset($data_replace["prediction_id"]) ? $data_replace["prediction_id"] : '',
      '%keylogin%' => isset($data_replace["user_key"]) ? $data_replace["user_key"] : '',
      '%deposit_method%' => isset($data_replace["deposit_method"]) ? methodDepositStr($data_replace["deposit_method"]) : '',

      '%url_prediction_detail%' => isset($data_replace["url_prediction_detail"]) ?
        '<a href="' . $data_replace["url_prediction_detail"] . ($mail_bulk_id != null ? '?mail_id=' . $mail_bulk_id : '') . '">' . $data_replace["url_prediction_detail"] . ($mail_bulk_id != null ? '?mail_id=' . $mail_bulk_id : '') . '</a>' :
        '',
      '%url_reference_media%' => isset($data_replace["media_code"]) ? route("login", 'ref=' . trim($data_replace['media_code'])) : '',

      //      '%url_prediction%' => url("/prediction-detail/") . '/',
      //      '%url_blog%' => url("/blog-detail/") . '/',

      '%url_login%' => isset($data_replace["user_key"]) ? '<a href="' . url("/login/" .
        $data_replace["user_key"]) . ($mail_bulk_id != null ? '?mail_id=' . $mail_bulk_id : '') . '">' . url("/login/" . $data_replace["user_key"]) . ($mail_bulk_id != null ? '?mail_id=' . $mail_bulk_id : '') . '</a>' : '',

      // Need to change string
      '%venue_id%' => isset($data_replace["venue_id"]) ? $data_replace["venue_id"] : '',
      '%race_no%' => isset($data_replace["race_no"]) ? $data_replace["race_no"] : '',

      '%hit_race%' => isset($data_replace["hit_race"]) ? $data_replace["hit_race"] : '',
      '%prediction_result_amount%' => isset($data_replace["prediction_result_amount"]) ? $data_replace["prediction_result_amount"] : '',
      '%prediction_result_point%' => isset($data_replace["prediction_result_point"]) ? $data_replace["prediction_result_point"] : '',
      '%race_date%' => isset($data_replace["race_date"]) ? $data_replace["race_date"] : '',
    ];

    foreach ($arr_mail_replace as $key => $value) {
      $content = str_replace($key, $value, $content);
    }

    // URL Blog
    $start_url_blog = strpos($content, "%url_blog_");
    if ($start_url_blog !== false) {
      $start_str = 0;
      while (true) {
        // Find url blog
        $start = strpos($content, "%url_blog_", $start_str);
        // Not found
        if ($start === false) {
          break;
        }

        // Fin url blog id
        $end = strpos($content, "%", $start + 1);
        $start_str = $end;
        $url_blog_id = substr($content, $start, ($end - $start + 1));

        // Find id
        $start_id = strrpos($url_blog_id, '_');
        $end_id = strpos($url_blog_id, "%", $start_id + 1);
        $id = (int) substr($url_blog_id, $start_id + 1, ($end_id - $start_id - 1));

        // Check id is integer
        if ($id == 0) {
          continue;
        }

        // string replace
        $link_replace = '/user_key/' . $data_replace["user_key"] . '?c=blog-detail&id=' . $id . ($mail_bulk_id != null ? '&mail_id=' . $mail_bulk_id : '');
        $str_replace = '<a href="' . url($link_replace) . '">' . url($link_replace) . '</a>';
        $content = str_replace($url_blog_id, $str_replace, $content);
      }
    }

    // URL prediction
    $start_url_prediction = strpos($content, "%url_prediction_");
    if ($start_url_prediction !== false) {
      $start_str = 0;
      while (true) {
        // Find url blog
        $start = strpos($content, "%url_prediction_", $start_str);
        // Not found
        if ($start === false) {
          break;
        }

        // Fin url blog id
        $end = strpos($content, "%", $start + 1);
        $start_str = $end;
        $url_blog_id = substr($content, $start, ($end - $start + 1));

        // Find id
        $start_id = strrpos($url_blog_id, '_');
        $end_id = strpos($url_blog_id, "%", $start_id + 1);
        $id = (int) substr($url_blog_id, $start_id + 1, ($end_id - $start_id - 1));

        // Check id is integer
        if ($id == 0) {
          continue;
        }

        // string replace
        $link_replace = '/user_key/' . $data_replace["user_key"] . '?c=prediction-detail&id=' . $id . ($mail_bulk_id != null ? '&mail_id=' . $mail_bulk_id : '');
        $str_replace = '<a href="' . url($link_replace) . '">' . url($link_replace) . '</a>';
        $content = str_replace($url_blog_id, $str_replace, $content);
      }
    }

    // URL result
    $start_url_result = strpos($content, "%url_result%");
    if ($start_url_result !== false) {
      // string replace
      $link_replace = '/user_key/' . $data_replace["user_key"] . '?c=result' . ($mail_bulk_id != null ? '&mail_id=' . $mail_bulk_id : '');
      $str_replace = '<a href="' . url($link_replace) . '">' . url($link_replace) . '</a>';
      $content = str_replace('%url_result%', $str_replace, $content);
    }

    // URL Column
    $start_url_result = strpos($content, "%url_column%");
    if ($start_url_result !== false) {
      // string replace
      $link_replace = '/user_key/' . $data_replace["user_key"] . '?c=column' . ($mail_bulk_id != null ? '&mail_id=' . $mail_bulk_id : '');
      $str_replace = '<a href="' . url($link_replace) . '">' . url($link_replace) . '</a>';
      $content = str_replace('%url_column%', $str_replace, $content);
    }

    // change mail pc
    $start_url_result = strpos($content, "%url_change_mail_pc%");
    if ($start_url_result !== false) {
      // string replace
      $link_replace = '/change-mail-pc-verify?keylogin=' . $data_replace["key_login"] . '&mail_pc=' . $data_replace["mail_pc"] . "&new_mail_pc=" . $data_replace["new_mail_pc"] . "&user_id=" . $data_replace["id"];
      $str_replace = '<a href="' . url($link_replace) . '">' . url($link_replace) . '</a>';
      $content = str_replace('%url_change_mail_pc%', $str_replace, $content);
    }
    return $content;
  }
}
