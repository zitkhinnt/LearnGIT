<?php

namespace Modules\Horserace\Http\Controllers\Cron;

use Exception;
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
use Modules\Horserace\Repositories\MailBanRepositories;
use Modules\Horserace\Repositories\MailContactRepositories;
use Modules\Horserace\Repositories\UserActivityRepositories;

class CronMailContactController extends Controller
{

    public function cronMailContact()
    {
        // Log
        $time = date('Y-m-d H:i:s a');
        $log['time'] = 'Mail Contact: ' . $time;

        // Connect server mail
        // $mbox = imap_open("{mail25539.maychuemail.com}", 'info@oniboat.net', '826515Sr4')
        // or die("can't connect: " . imap_last_error());

        //Connect server mail
        $mbox = imap_open("{" .
            env('MAIL_CONTACT_HOST', '') . "}",
            env('MAIL_CONTACT_USERNAME', 'no_user'),
            env('MAIL_CONTACT_PASSWORD', 'no_password')
        )
        or die("can't connect: " . imap_last_error());

        // get all email within 7 day
        $emails = imap_search($mbox, 'SINCE "' . date("j F Y", strtotime("-2 days")) . '"');
        $arr_mail_contact = array();
        $arr_mail_daemon = array();

        /* if emails are returned, cycle through each... */
        if ($emails) {

            /* put the newest emails on top */
            rsort($emails);

            /* for every email... */
            foreach ($emails as $email_number) {
                $arr_mail_contact[$email_number] = $this->getEmailMessage($mbox, $email_number);
            }
        }

        imap_close($mbox);

        // Log
        $log["mail_contact"] = $arr_mail_contact;
        $obj_mail_ban = new MailBan();
        $arr_mail_contact_tmp = []; 
        // Remove mail address no-reply, daemon
        foreach ($arr_mail_contact as $key => $mail) {
            // remove empty
            if(!$mail){
                unset($arr_mail_contact[$key]);
                continue;
            }

            if (strpos(strtoupper($mail["mail_address"]), strtoupper('no-reply')) !== false) {
                // $arr_mail_daemon[] = $mail;
                continue;
            }
            if (strpos(strtoupper($mail["mail_address"]), strtoupper('DAEMON')) !== false) {
                $arr_mail_daemon[] = $mail;
                continue;
            }
            if (strpos(strtoupper($mail["mail_address"]), strtoupper('POSTMASTER')) !== false) {
                // $arr_mail_daemon[] = $mail;
                continue;
            }
            // Check mail ban
            $is_mail_ban = $obj_mail_ban->isMailBan($mail["mail_address"]);
            if ($is_mail_ban) {
                continue;
            }
            $arr_mail_contact_tmp[] = $mail;
        }

        $arr_mail_contact = $arr_mail_contact_tmp;
        // Log
        $log["mail_contact"] = $arr_mail_contact;

        // Save mail contact
        $obj_mail_contact_rep = new MailContactRepositories();
        $obj_user = new User();

        foreach ($arr_mail_contact as $mail) {
            $user = $obj_user->getUserByMailPc($mail["mail_address"]);
            if (is_null($user)) {
                // GUEST
                $input['user_id'] = GUEST_0;
                $input['mail_from_address'] = $mail["mail_address"];
                $input['mail_from_name'] = GUEST_NICKNAME;
            } else {
                // User register
                $input['user_id'] = $user->id;
                $input['mail_from_address'] = $user->mail_pc;
                $input['mail_from_name'] = $user->nickname;
            }

            $input['mail_to_address'] = MAIL_FROM_ADDRESS;
            $input['mail_to_name'] = MAIL_FROM_NAME;
            $input['mail_title'] = MAIL_TITLE_CONTACT;
            $input['mail_body'] = nl2br($mail["mail_text"]);
            $input['mail_html'] = $mail['mail_html'];
            $input['mail_attachments'] = json_encode($mail['mail_attachments']);
            $input['user_read_at'] = \Carbon\Carbon::now()->toDateTimeString();

            // Import mail contact
            $obj_mail_contact_rep->mailContactStore($input);
        }

        // Mail daemon
        $log_daemon['time'] = 'Mail daemon: ' . $time;

        // $obj_user = new User();

        // if (count($arr_mail_daemon) < 30) {
        //     foreach ($arr_mail_daemon as $mail) {
        //         foreach (getAllEmailFromText($mail['mail_text']) as $match_daemon_email) {
        //             $user_info = $obj_user->getUserByMailPcNew($match_daemon_email);
    
        //             if (isset($user_info->id)) {
        //                 $log_daemon["daemon_mail"][] = $user_info->mail_pc;
        //                 $arr_user['stop_mail'] = STOP_MAIL_ENABLE;
        //                 $obj_user->updateUser($user_info->id, $arr_user);
        //             } else {
        //                 $log_daemon["daemon_mail_not_found"][] = $match_daemon_email;
        //             }
        //         }
        //     }
        // } else {
        //     foreach ($arr_mail_daemon as $mail) {
        //         foreach (getAllEmailFromText($mail['mail_text']) as $match_daemon_email) {
        //             $log_daemon["daemon_mail_too_many"][] = $match_daemon_email;
        //         }
        //     }
        //     report(new Exception('too many daemon mail' . print_r($log_daemon['daemon_mail_too_many'], true)));
        // }

        // Update mail bulk done
        /*$mail_bulk_done = $obj_mail_bulk_done->getMailBulkDoneByMailBulkId($mail_bulk->id);
        $arr_mail_bulk_done["send_success_number"] = (integer)$mail_bulk_done->send_success_number - $number_mail_daemon;
        $obj_mail_bulk_done->updateMailBulkDone($mail_bulk_done->id, $arr_mail_bulk_done);*/

        mail_demon_log(print_r($log_daemon, true));
        mail_contact_log(print_r($log, true));

    }

    public function deleteMailServer()
    {
        // Log
        $time = date('Y-m-d H:i:s a');
        $log['time'] = 'Mail Delete: ' . $time;

        // Connect server mail
        //$mbox = imap_open("{" . MAIL_BOX . "}", CONTACT_USERNAME, CONTACT_PASSWORD)
        //or die("can't connect: " . imap_last_error());

        // Connect server mail
        $mbox = imap_open("{" .
            env('MAIL_CONTACT_HOST', 'smtp.mailgun.org') . "}",
            env('MAIL_CONTACT_USERNAME', 'no_user'),
            env('MAIL_CONTACT_PASSWORD', 'no_password')
        )
        or die("can't connect: " . imap_last_error());

        $emails = imap_search($mbox, 'ALL');
        $arr_mail_reg = array();
        //file_put_contents(base_path() . '/storage/logs/nghia.log', date("r") . ":\n" . 'contact deleteMailServer:emails:'.print_r($emails, true) . "\n---\n", FILE_APPEND);

        /* if emails are returned, cycle through each... */
        if ($emails) {

            /* put the newest emails on top */
            rsort($emails);

            /* for every email... */
            foreach ($emails as $email_number) {
                /* get information specific to this email */
                $overview = imap_fetch_overview($mbox, $email_number, 0);

                // Set seen, 1 seen, 0 not seen
                //if ($overview[0]->seen == 1) {
                //imap_delete($mbox, $email_number);
                // imap_setflag_full($mbox, $email_number, "\\Deleted");
                $temp_from = $overview[0]->from;

                $start = strpos($temp_from, "<");
                $end = strpos($temp_from, ">");
                $mail = substr($temp_from, $start + 1, ($end - $start - 1));
                //$arr_mail_reg[] = $mail;
                if (strpos(strtoupper($temp_from), "MAILER-DAEMON") !== false
                    || strpos(strtoupper($temp_from), "DAEMON") !== false
                    || strpos(strtoupper($temp_from), "POSTMASTER") !== false
                    || strpos(strtoupper($temp_from), "NO-REPLY") !== false) {
                    imap_delete($mbox, $email_number);
                }

                //file_put_contents(base_path() . '/storage/logs/nghia.log', date("r") . ":\n" . 'contact deleteMailServer:mail:'.print_r($mail, true) . "\n---\n", FILE_APPEND);
                //}
            }
        }
        imap_expunge($mbox);
        imap_close($mbox);

        // Log
        //$log["mail_reg"] = $arr_mail_reg;
        //mail_register_log(print_r($log, true));
    }

    public function cron()
    {
        if (env("APP_ENV") != "local") {
            $this->cronMailContact();
        }
    }

    public function cronDelete()
    {
        if (env("APP_ENV") != "local") {
            $this->deleteMailServer();
        }
    }

    public function testCronMailContact()
    {
        $this->cronMailContact();
    }

    public function cronMailContactTest()
    {
        // Log
        $time = date('Y-m-d H:i:s a');
        $log['time'] = 'Mail Contact: ' . $time;

        // Connect server mail
        $mbox = imap_open("{" .
            env('MAIL_CONTACT_HOST', 'smtp.mailgun.org') . "}",
            env('MAIL_CONTACT_USERNAME', 'no_user'),
            env('MAIL_CONTACT_PASSWORD', 'no_password')
        )
        or die("can't connect: " . imap_last_error());

        // get all email within 14 day
        // $emails = imap_search($mbox, 'SINCE "' . date("j F Y", strtotime("-7 days")) . '"');
        $emails = imap_search($mbox, 'FROM "ys1213@amber.plala.or.jp"');
        $email_array = [];

        // $mimetype = array("text","multipart","message","application","audio","image","video","other","unknow");
        // $encode = array("7BIT","8BIT","BINARY","BASE64","QUOTED-PRINTABLE","OTHER");
        // $chaset = array("utf8", "iso-2022-jp", "iso-2022-jp-ms");

        /* if emails are returned, cycle through each... */
        if ($emails) {
            /* put the newest emails on top */
            rsort($emails);

            /* for every email... */
            foreach ($emails as $email_number) {
                // get message overview
                $structure = array();
                $overview = array();
                $header = array();
                try {
                    $structure = imap_fetchstructure($mbox, $email_number, 0);
                    $overview = imap_fetch_overview($mbox, $email_number, 0);
                    $header = imap_fetchheader($mbox, $email_number, 0);
                } catch (\Exception $e) {
                    $email_array[$email_number] = "------error ---: number: " . $email_number . ' ---Msg--:::' . $e->getMessage();
                    continue;
                }

                // conver structure to message part
                if (isset($structure->parts)) {
                    $structure = $this->flattenParts($structure->parts);
                } else {
                    $structure = ["1" => $structure];
                }

                $email_array[$email_number]['structure'] = $structure;
                $email_array[$email_number]['overview'] = $overview[0];
                $email_array[$email_number]['header'] = $header;

                // get message part content
                foreach ($structure as $part_number => $part_structure) {
                    $email_array[$email_number]['messages'][$part_number] = $this->getMessagePartContent($mbox, $email_number, $part_number, $part_structure);
                }
            }
        } else {
            $log['error'] = 'emails not found!';
        }

        imap_close($mbox);

        $log['result'] = $email_array;

        dd($log);
    }

    function flattenParts($messageParts, $flattenedParts = array(), $prefix = '', $index = 1, $fullPrefix = true)
    {
        foreach ($messageParts as $part) {
            $flattenedParts[$prefix . $index] = $part;
            if (isset($part->parts)) {
                if ($part->type == 2) {
                    $flattenedParts = $this->flattenParts($part->parts, $flattenedParts, $prefix . $index . '.', 0, false);
                } elseif ($fullPrefix) {
                    $flattenedParts = $this->flattenParts($part->parts, $flattenedParts, $prefix . $index . '.');
                } else {
                    $flattenedParts = $this->flattenParts($part->parts, $flattenedParts, $prefix);
                }
                unset($flattenedParts[$prefix . $index]->parts);
            }
            $index++;
        }

        return $flattenedParts;
    }

    private function getEmailMessage($mbox, $email_number){
        try
        {   
            $result = [];

            // get message overview
            $structure = array();
            $overview = array();
            $header = array();
            try {
                $overview = imap_fetch_overview($mbox, $email_number, 0);

                // email aready save to database
                if ($overview[0]->draft == 1) return [];

                $structure = imap_fetchstructure($mbox, $email_number, 0);
                $header = imap_rfc822_parse_headers(imap_fetchheader($mbox, $email_number, 0));
            } catch (\Exception $e) {
                mail_contact_log("------error ---: number: " . $email_number . ' ---Msg--:::' . $e->getMessage());
                return[];
            }

            // conver structure to message part
            if (isset($structure->parts)) {
                $structure = $this->flattenParts($structure->parts);
            } else {
                $structure = ["1" => $structure];
            }

            // get mail andress
            $result['mail_address'] = $this->pasteMailAddressFromOverview($overview);
            $result['date'] = $overview[0]->date;
            $result['structure'] = $structure;
            $result['overview'] = $overview[0];
            $result['header'] = $header;

            $result['mail_text']  = '';
            $result['mail_html'] = '';
            $result['mail_attachments'] = [];

            // get message part content
            foreach ($structure as $part_number => $part_structure) {
                $part_content = $this->getMessagePartContent($mbox, $email_number, $part_number, $part_structure);
                if($part_content['error']) return [];

                // filter all message part to get mail_text, mail_html, mail_attachments
                switch ($part_content['type']) {
                    case 'text/plain':
                        if(!$result['mail_text']) $result['mail_text']  = $part_content['message'];
                        break;
                    
                    case 'text/html':
                        if(!$result['mail_html']) $result['mail_html'] = $part_content['message'];
                        break;

                    // attachment
                    case 'media/application':
                    case 'media/audio':
                    case 'media/image':
                    case 'media/video':
                    case 'media/other':    
                        $result['mail_attachments'][] = $part_content['file'];
                        break;

                    default:
                        break;
                }
            }

            // set email is read
            imap_setflag_full($mbox, $email_number, "\\Draft");
            // imap_delete($mbox, $email_number,false);

            return $result;

        } catch (\Exception $e) {
            mail_contact_log("------Cron Mail error ---: number: " . $email_number . "-mail: " . $overview[0]->from . " - body: " . $email_body);
            return [];
        }
    }

    private function getMessagePartContent($mbox, $email_number, $part_number, $part_structure)
    {
        try
        {
            // get charset
            $data_charset = '';
            if ($part_structure->ifparameters == 1) {
                foreach ($part_structure->parameters as $part_param) {
                    if ($part_param->attribute == 'charset') {
                        $data_charset = $part_param->value;
                    }
                }
            }

            // get message content
            $message = '';
            $type = '';
            $file = array();
            switch ($part_structure->type) {
                case 0: // the HTML or plain text part of the email
                    $message = $this->getMessagePartTextOrHTML($mbox, $email_number, $part_number, $part_structure->encoding, $data_charset);
                    $type = 'text/' . strtolower($part_structure->subtype);
                    break;

                case 1: // multi-part headers, can ignore
                case 2: // attached message headers, can ignore
                    break;

                case 3: // application
                case 4: // audio
                case 5: // image
                case 6: // video
                case 7: // other
                    // $filename = getFilenameFromPart($part_structure);
                    // if($filename) {
                    //   // it's an attachment
                    //   $attachment = getMessagePart($mbox, $email_number, $part_number, $part_structure->encoding);
                    //   // now do something with the attachment, e.g. save it somewhere
                    // }
                    // else {
                    //   // don't know what it is
                    // }
                    $file['filename'] = 'todo';
                    $type = 'media/' . strtolower($part_structure->subtype);
                    break;
            }

            return [
                'error' => '',
                'type' => $type,
                'message' => $message,
                'file' => $file,
            ];
        } catch (\Exception $e) {
            return [
                'error' => "------error ---: number: " . $email_number . ' ---Msg--:::' . $e->getMessage(),
            ];
        }
    }

    private function getMessagePartTextOrHTML($mbox, $email_number, $part_number, $encoding, $chaset)
    {
        $email_body = imap_fetchbody($mbox, $email_number, $part_number);
        $message = '';

        // convert encode
        switch ($encoding) {
            case 0:
                $message = $email_body;
                break; // 7BIT
            case 1:
                $message = $email_body;
                break; // 8BIT
            case 2:
                $message = $email_body;
                break; // BINARY
            case 3:
                $message = base64_decode($email_body);
                break; // BASE64
            case 4:
                $message = quoted_printable_decode($email_body);
                break; // QUOTED_PRINTABLE
            case 5:
                $message = $email_body;
                break; // OTHER
            default:
                $message = $email_body; // unknow
        }

        // convert charset
        switch ($chaset) {
            case 'utf8':
            case 'iso-8859-1': // latin1
                return $message;

            case 'jis': //japanese
            case 'iso-2022-jp': //japanese
                return mb_convert_encoding($message, 'UTF-8', 'ISO-2022-JP-MS');

            case 'big5': //china
                return ''; // mb_convert_encoding($message, 'UTF-8', 'auto'); // ko biet

            default:
                return mb_convert_encoding($message, 'UTF-8', 'auto');
        }
    }

    private function pasteMailAddressFromOverview($overview) {
      if(!isset($overview[0]->from) || !$overview[0]->from) {
        mail_contact_log("------Cron Mail error ---: mail address overview[0]->from: not has any value");
        return '';
      }

      $email_andress = '';
      $temp_from = trim($overview[0]->from);

      //1) try to get mail between < and >;
      $start = strpos($temp_from, "<");
      $end = strpos($temp_from, ">");
      if ($start && $end) {
        $email_andress = trim(substr($temp_from, $start + 1, ($end - $start - 1)));
        // check and return if email is validate
        if (filter_var($email_andress, FILTER_VALIDATE_EMAIL) !== false) return $email_andress;
      }

      //2) try to remove illegal from email string
      $email_andress = filter_var($temp_from, FILTER_SANITIZE_EMAIL);
      if ($email_andress) {
        // check and return if email is validate
        if (filter_var($email_andress, FILTER_VALIDATE_EMAIL) !== false) return $email_andress;
      }
      
      mail_contact_log("------Cron Mail error ---: mail address: " . $overview[0]->from. ':::try to return origin string');
      return $temp_from;
    }
}
