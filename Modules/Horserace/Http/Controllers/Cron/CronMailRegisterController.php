<?php

namespace Modules\Horserace\Http\Controllers\Cron;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Horserace\Entities\Gift;
use Modules\Horserace\Entities\MailBan;
use Modules\Horserace\Entities\MailBulk;
use Modules\Horserace\Entities\MailBulkDone;
use Modules\Horserace\Entities\MailSchedule;
use Modules\Horserace\Entities\MailScheduleDone;
use Modules\Horserace\Entities\Prediction;
use Modules\Horserace\Entities\PredictionResult;
use Modules\Horserace\Entities\TransactionDeposit;
use Modules\Horserace\Entities\TransactionGift;
use Modules\Horserace\Entities\TransactionPayment;
use Modules\Horserace\Entities\User;
use Modules\Horserace\Entities\UserActivity;
use Modules\Horserace\Http\Controllers\Backend\MailController;
use Modules\Horserace\Http\Controllers\Frontend\RegisterController;
use Modules\Horserace\Repositories\GiftRepositories;
use Modules\Horserace\Repositories\UserActivityRepositories;


class CronMailRegisterController extends Controller
{

  public function cronMailRegister()
  {
//     nghia_log('cronMailRegister-----');
//     // Log
//     $time = date('Y-m-d H:i:s a');
//     $log['time'] = 'Mail register: ' . $time;

//     // Connect server mail
//     $mbox = imap_open("{" .
//       env('MAIL_CONTACT_HOST', 'smtp.mailgun.org') . "}",
//       env('MAIL_CONTACT_USERNAME', 'no_user'),
//       env('MAIL_CONTACT_PASSWORD', 'no_password')
//   )
//   or die("can't connect: " . imap_last_error());

//     $emails = imap_search($mbox, 'ALL');
//     $arr_mail_reg = array();

// //file_put_contents(base_path() . '/storage/logs/nghia.log', date("r") . ":\n" . 'cronMailRegister:'.print_r($emails, true) . "\n---\n", FILE_APPEND);

//     /* if emails are returned, cycle through each... */
//     if ($emails) {

//       /* put the newest emails on top */
//       rsort($emails);

//       /* for every email... */
//       foreach ($emails as $email_number) {
//         /* get information specific to this email */
//         $overview = imap_fetch_overview($mbox, $email_number, 0);
//         // Set seen, 1 seen, 0 not seen
//         if ($overview[0]->draft == 1) {
//           imap_setflag_full($mbox, $email_number, "\\Draft");
//           $temp_from = $overview[0]->from;
//           $start = strpos($temp_from, "<");
//           $end = strpos($temp_from, ">");
//           if ($end == false) {
//             $arr_mail_reg[] = $temp_from;
//           } else {
//             $mail = substr($temp_from, $start + 1, ($end - $start - 1));
//             $arr_mail_reg[] = $mail;
//           }
//         }
//       }
//     }

//     imap_close($mbox);
//     // Log
//     $log["mail_reg"] = $arr_mail_reg;

//     $obj_mail_ban = new MailBan();
//     // Remove mail address no-reply, daemon
//     foreach ($arr_mail_reg as $key => $mail) {
//       if ((strpos($mail, 'no-reply') !== false)) {
//         unset($arr_mail_reg[$key]);
//       }
//       if ((strpos($mail, 'DAEMON') !== false)) {
//         unset($arr_mail_reg[$key]);
//       }
//       // Check mail ban
//       $is_mail_ban = $obj_mail_ban->isMailBan($mail);
//       if ($is_mail_ban) {
//         unset($arr_mail_reg[$key]);
//       }
//     }

//     $obj_user = new User();
//     $obj_reg_controller = new RegisterController();
//     foreach ($arr_mail_reg as $mail)
//     {
//       if(!$obj_user->getUserByMailPcNew($mail))
//         $obj_reg_controller->registerUserBySendMail($mail);
//     }

    //mail_register_log(print_r($log, true));
  }

  public function deleteMailServer()
  {
    // Log
    $time = date('Y-m-d H:i:s a');
    $log['time'] = 'Mail Delete: ' . $time;

    // Connect server mail
    $mbox = imap_open("{" .
      env('MAIL_CONTACT_HOST', 'smtp.mailgun.org') . "}",
      env('MAIL_CONTACT_USERNAME', 'no_user'),
      env('MAIL_CONTACT_PASSWORD', 'no_password')
  )
  or die("can't connect: " . imap_last_error());

    $emails = imap_search($mbox, 'ALL');
    $arr_mail_reg = array();
file_put_contents(base_path() . '/storage/logs/nghia.log', date("r") . ":\n" . 'deleteMailServer:emails:'.print_r($emails, true) . "\n---\n", FILE_APPEND);

    /* if emails are returned, cycle through each... */
    if ($emails) {

      /* put the newest emails on top */
      rsort($emails);

      /* for every email... */
      foreach ($emails as $email_number) {
        /* get information specific to this email */
        $overview = imap_fetch_overview($mbox, $email_number, 0);
file_put_contents(base_path() . '/storage/logs/nghia.log', date("r") . ":\n" . 'deleteMailServer:overview:'.print_r($overview, true) . "\n---\n", FILE_APPEND);

        // Set seen, 1 seen, 0 not seen
        if ($overview[0]->seen == 1) {
          //imap_delete($mbox, $email_number);
          // imap_setflag_full($mbox, $email_number, "\\Deleted");
          $temp_from = $overview[0]->from;
file_put_contents(base_path() . '/storage/logs/nghia.log', date("r") . ":\n" . 'deleteMailServer:temp_from:'.print_r($temp_from, true) . "\n---\n", FILE_APPEND);

          $start = strpos($temp_from, "<");
          $end = strpos($temp_from, ">");
          $mail = substr($temp_from, $start + 1, ($end - $start - 1));
          $arr_mail_reg[] = $mail;
//file_put_contents(base_path() . '/storage/logs/nghia.log', date("r") . ":\n" . 'deleteMailServer:'.print_r($mail, true) . "\n---\n", FILE_APPEND);

        }
      }
    }
    imap_expunge($mbox);
    imap_close($mbox);

    // Log
    $log["mail_reg"] = $arr_mail_reg;
    mail_register_log(print_r($log, true));
  }

  public function cron()
  {
    echo 'CronMailRegisterController   cron ';
    if (env("APP_ENV") != "local") {
      $this->cronMailRegister();
    }
  }

  public function cronDelete()
  {
    if (env("APP_ENV") != "local") {
      $this->cronMailRegister();
      $this->deleteMailServer();
    }
  }

  public function testCronMailRegister()
  {
    $this->deleteMailServer();
  }
}
