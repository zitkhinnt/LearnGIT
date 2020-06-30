<?php

namespace Modules\Horserace\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Routing\Controller;
use Modules\Horserace\Entities\Gift;
use Modules\Horserace\Entities\MailBulk;
use Modules\Horserace\Entities\MailSchedule;
use Modules\Horserace\Entities\MailTemplate;
use Modules\Horserace\Entities\Prediction;
use Modules\Horserace\Entities\TransactionDeposit;
use Modules\Horserace\Entities\TransactionPayment;
use Modules\Horserace\Entities\User;
use Modules\Horserace\Http\Requests\MailBulkRequest;
use Modules\Horserace\Http\Requests\MailScheduleRequest;
use Modules\Horserace\Http\Requests\MailTemplateRequest;
use Modules\Horserace\Repositories\EntranceRepositories;
use Modules\Horserace\Repositories\GiftRepositories;
use Modules\Horserace\Repositories\MailBanRepositories;
use Modules\Horserace\Repositories\MailBulkDetailRepositories;
use Modules\Horserace\Repositories\MailBulkRepositories;
use Modules\Horserace\Repositories\MailContactRepositories;
use Modules\Horserace\Repositories\MailDepositRepositories;
use Modules\Horserace\Repositories\MailGiftRepositories;
use Modules\Horserace\Repositories\MailInterimRepositories;
use Modules\Horserace\Repositories\MailPaymentRepositories;
use Modules\Horserace\Repositories\MailPredictionOpenRepositories;
use Modules\Horserace\Repositories\MailPredictionResultRepositories;
use Modules\Horserace\Repositories\MailRegisterRepositories;
use Modules\Horserace\Repositories\MailScheduleDetailRepositories;
use Modules\Horserace\Repositories\MailScheduleRepositories;
use Modules\Horserace\Repositories\MailTemplateRepositories;
use Modules\Horserace\Repositories\MediaRepositories;
use Modules\Horserace\Repositories\PredictionTypeRepositories;
use Modules\Horserace\Repositories\UserStageRepositories;
use Modules\Horserace\Repositories\UserRepositories;

class MailController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('admin');
    }

    public function mailTemplate(Request $request,
        MailTemplateRepositories $mailTemplateRepositories) {
        $data["list_mail_template"] = $mailTemplateRepositories->getMailTemplate();
        return view('horserace::backend.mail.mail_template', compact("data"));
    }

    public function addMailTemplate(Request $request)
    {
        return view('horserace::backend.mail.add_mail_template');
    }

    public function editMailTemplate(Request $request,
        MailTemplateRepositories $mailTemplateRepositories,
        $id_mail_template) {
        $data["mail_template"] = $mailTemplateRepositories->getMailTemplateById($id_mail_template);
        return view('horserace::backend.mail.edit_mail_template', compact("data"));
    }

    public function storeMailTemplate(MailTemplateRequest $request,
        MailTemplateRepositories $mailTemplateRepositories) {
        $input = $request->all();
        $result = $mailTemplateRepositories->storeMailTemplate($input);
        return redirect()->route("admin.mail_template")->with([
            "flash_level" => $result["status"],
            "flash_message" => $result["message"],
        ]);
    }

    public function deleteMailTemplate(Request $request,
        MailTemplateRepositories $mailTemplateRepositories) {
        $input = $request->all();
        $result = $mailTemplateRepositories->deleteMailTemplate(trim($input["id_delete"]));
        return redirect()->route('admin.mail_template')->with([
            'flash_level' => $result["status"],
            'flash_message' => $result["message"],
        ]);
    }

    public function ajaxGetMailTemplate(Request $request,
        MailTemplateRepositories $mailTemplateRepositories) {
        $input = $request->all();
        $id_mail_template = trim($input["mail_template_id"]);
        $data["mail_template"] = $mailTemplateRepositories->getMailTemplateById($id_mail_template);
        $mail_template = (array) $data["mail_template"];
        return $mail_template;
    }

    public function sendMailRegister($user_id)
    {
        $mailRegisterRepositories = new MailRegisterRepositories();
        $obj_user = new User();
        $obj_gift_repositories = new GiftRepositories();
        $obj_mail_schedule = new MailSchedule();
        $obj_mailable_controller = new MailableController();

        // Get user
        $user = $obj_user->getDetailUserById($user_id);

        nghia_log('user detail 22222:::::'.print_r($user, true));

        $user_mail_register = json_decode($user->mail_register, true);
        $data_replace = (array) $user;
        $data_replace["user_point"] = $data_replace["point"];

        // Get mail register
        $list_mail_register = $obj_mail_schedule->getMailScheduleTarget(MAIL_SCHEDULE_TARGET_REGISTER);
        $user_register_time = $user->interim_register_time;
        $now = \Carbon\Carbon::now()->timestamp;

        // Send mail register
        foreach ($list_mail_register as $mail_register) {
            $elapsed_time = explode(":", $mail_register->elapsed_time);
            $data_elapsed_day = $elapsed_time[0];
            $data_elapsed_hour = $elapsed_time[1];
            $data_elapsed_minute = $elapsed_time[2];
            // Time send
            $time_send = date('Y-m-d H:i:s', strtotime('+' . $data_elapsed_day . ' day +' . $data_elapsed_hour .
                ' hour + ' . $data_elapsed_minute . ' minutes', strtotime($user_register_time)));
            // Check time
            if ($now >= strtotime($time_send) && !isset($user_mail_register[$mail_register->id])) {
                $input = [
                    "mail_template_register_id" => $mail_register->id,
                    "mail_from_address" => $mail_register->mail_from_address,
                    "mail_from_name" => $mail_register->mail_from_name,
                    "mail_to_address" => $user->mail_pc,
                    "mail_to_name" => $user->nickname,
                    "mail_title" => $mail_register->mail_title,
                    "mail_body" => $mail_register->mail_body,
                ];

                // Send mail
                $send_status = $obj_mailable_controller->sendMailByMailable($input, $data_replace);

                // Data mail register detail
                $input["user_id"] = $user->user_id;
                $input["id"] = 0;
                $input["status"] = $send_status;
                $input["read_at"] = null;
                $input["mail_body"] = $obj_mailable_controller->replaceMail($input["mail_body"], $data_replace);

                // Save mail register detail
                $mailRegisterRepositories->storeMailRegister($input);
                unset($input);

                if ($user->send_mail < 1) {
                    // Gift register and send mail gift
                    $obj_gift_repositories->giftAddPointByType($user->user_id, GIFT_TYPE_REGISTER);
                }

                // Update user send mail
                $obj_user->addSendMailRegister($user->user_id, $mail_register->id);
            }

        }
    }

    public function sendMailUserInterim($user_id)
    {
        $mailInterimRepositories = new MailInterimRepositories();
        $obj_user = new User();
        $obj_mail_schedule = new MailSchedule();
        $obj_mailable_controller = new MailableController();

        // Get user
        $user = $obj_user->getDetailUserById($user_id);
        $user_mail_interim = json_decode($user->mail_interim, true);
        $data_replace = (array) $user;
        $data_replace["user_point"] = $data_replace["point"];

        // Get mail register
        $list_mail_interim = $obj_mail_schedule->getMailScheduleTarget(MAIL_SCHEDULE_TARGET_USER_INTERIM);
        $user_register_time = $user->interim_register_time;
        $now = \Carbon\Carbon::now()->timestamp;

        // Send mail register
        foreach ($list_mail_interim as $mail_interim) {
            $elapsed_time = explode(":", $mail_interim->elapsed_time);
            $data_elapsed_day = $elapsed_time[0];
            $data_elapsed_hour = $elapsed_time[1];
            $data_elapsed_minute = $elapsed_time[2];

            // Time send
            $time_send = date('Y-m-d H:i:s', strtotime('+' . $data_elapsed_day . ' day +' . $data_elapsed_hour .
                ' hour + ' . $data_elapsed_minute . ' minutes', strtotime($user_register_time)));

            // Check time
            if ($now >= strtotime($time_send) && !isset($user_mail_interim[$mail_interim->id])) {
                $input = [
                    "mail_template_interim_id" => $mail_interim->id,
                    "mail_from_address" => $mail_interim->mail_from_address,
                    "mail_from_name" => $mail_interim->mail_from_name,
                    "mail_to_address" => $user->mail_pc,
                    "mail_to_name" => $user->nickname,
                    "mail_title" => $mail_interim->mail_title,
                    "mail_body" => $mail_interim->mail_body,
                ];

                // Send mail
                $send_status = $obj_mailable_controller->sendMailByMailable($input, $data_replace);

                // Data mail register detail
                $input["user_id"] = $user->user_id;
                $input["id"] = 0;
                $input["status"] = $send_status;
                $input["read_at"] = null;
                $input["mail_body"] = $obj_mailable_controller->replaceMail($input["mail_body"], $data_replace);

                // Save mail register detail
                $mailInterimRepositories->storeMailInterim($input);
                unset($input);

                // Update user send mail
                $obj_user->addSendMailInterim($user->user_id, $mail_interim->id);
            }
        }
    }

    public function sendMailGiftByType($user_id, $gift_id)
    {
        $mailGiftRepositories = new MailGiftRepositories();
        $obj_user = new User();
        $obj_gift = new Gift();
        $obj_mailable_controller = new MailableController();

        // Get user
        $user = $obj_user->getDetailUserById($user_id);
        $data_replace = (array) $user;
        $data_replace["user_point"] = $data_replace["point"];

        // Get mail register
        $gift = $obj_gift->getGiftById($gift_id);

        // mail gift
        $input = [
            "gift_id" => $gift->id,
            "mail_from_address" => MAIL_FROM_ADDRESS,
            "mail_from_name" => MAIL_FROM_NAME,
            "mail_to_address" => $user->mail_pc,
            "mail_to_name" => $user->nickname,
            "mail_title" => $gift->name,
            "mail_body" => $gift->content,
        ];

        // Send mail
        $data_replace["gift_point"] = $gift->point;
        $send_status = $obj_mailable_controller->sendMailByMailable($input, $data_replace);

        // Data mail gift detail
        $input["user_id"] = $user->user_id;
        $input["id"] = 0;
        $input["status"] = $send_status;
        $input["read_at"] = null;
        $input["mail_body"] = $obj_mailable_controller->replaceMail($input["mail_body"], $data_replace);

        // Save mail gift detail
        $mailGiftRepositories->storeMailGift($input);
        unset($input);
    }

    public function sendMailGiftBonus($user_id, $mail_bonus)
    {
        $mailGiftRepositories = new MailGiftRepositories();
        $obj_user = new User();
        $obj_gift = new Gift();
        $obj_mailable_controller = new MailableController();

        // Get user
        $user = $obj_user->getDetailUserById($user_id);
        $data_replace = (array) $user;
        $data_replace["user_point"] = $data_replace["point"];

        // mail gift
        $input = [
            "gift_id" => 0,
            "mail_from_address" => MAIL_FROM_ADDRESS,
            "mail_from_name" => MAIL_FROM_NAME,
            "mail_to_address" => $user->mail_pc,
            "mail_to_name" => $user->nickname,
            "mail_title" => $mail_bonus->mail_title,
            "mail_body" => $mail_bonus->mail_body,
        ];

        // Send mail
        $data_replace["gift_point"] = $mail_bonus->point;
        $send_status = $obj_mailable_controller->sendMailByMailable($input, $data_replace);

        // Data mail gift detail
        $input["user_id"] = $user->user_id;
        $input["id"] = 0;
        $input["status"] = $send_status;
        $input["read_at"] = null;
        $input["mail_body"] = $obj_mailable_controller->replaceMail($input["mail_body"], $data_replace);

        // Save mail gift detail
        $mailGiftRepositories->storeMailGift($input);
        unset($input);
    }

    public function sendMailDeposit($trans_deposit)
    {
        $mailDepositRepositories = new MailDepositRepositories();
        $obj_user = new User();
        $obj_mail_schedule = new MailSchedule();
        $obj_trans_deposit = new TransactionDeposit();
        $obj_mailable_controller = new MailableController();

        // Get user
        $user = $obj_user->getDetailUserById($trans_deposit->user_id);
        $data_replace = (array) $user;
        $data_replace["user_point"] = $data_replace["point"];
        $data_replace["trans_point"] = $trans_deposit->point;
        $data_replace["trans_amount"] = $trans_deposit->amount;

        // Get mail deposit
        $list_mail_deposit = $obj_mail_schedule->getMailScheduleTarget(MAIL_SCHEDULE_TARGET_DEPOSIT);
        $trans_register_time = $trans_deposit->updated_at;
        $now = \Carbon\Carbon::now()->timestamp;

        // Mail trans deposit
        $trans_mail_deposit = json_decode($trans_deposit->mail_deposit);

        // Send mail deposit
        foreach ($list_mail_deposit as $mail_deposit) {
            $elapsed_time = explode(":", $mail_deposit->elapsed_time);
            $data_elapsed_day = $elapsed_time[0];
            $data_elapsed_hour = $elapsed_time[1];
            $data_elapsed_minute = $elapsed_time[2];

            // Time send
            $time_send = date('Y-m-d H:i:s', strtotime('+' . $data_elapsed_day . ' day +' . $data_elapsed_hour .
                ' hour + ' . $data_elapsed_minute . ' minutes', strtotime($trans_register_time)));

            // Check time
            if ($now >= strtotime($time_send) && !isset($trans_mail_deposit[$mail_deposit->id])) {
                $input = [
                    "transaction_deposit_id" => $trans_deposit->id,
                    "mail_template_deposit_id" => $mail_deposit->id,
                    "mail_from_address" => $mail_deposit->mail_from_address,
                    "mail_from_name" => $mail_deposit->mail_from_name,
                    "mail_to_address" => $user->mail_pc,
                    "mail_to_name" => $user->nickname,
                    "mail_title" => $mail_deposit->mail_title,
                    "mail_body" => $mail_deposit->mail_body,
                ];

                // Send mail
                $send_status = $obj_mailable_controller->sendMailByMailable($input, $data_replace);

                // Data mail register detail
                $input["user_id"] = $user->user_id;
                $input["id"] = 0;
                $input["status"] = $send_status;
                $input["read_at"] = null;
                $input["mail_body"] = $obj_mailable_controller->replaceMail($input["mail_body"], $data_replace);

                // Save mail register deposit
                $mailDepositRepositories->storeMailDeposit($input);
                unset($input);

                // Update transaction deposit
                $obj_trans_deposit->addSendMailDeposit($trans_deposit->id, $mail_deposit->id);
            }
        }
    }

    public function sendMailPayment($trans_payment)
    {
        $mailPaymentRepositories = new MailPaymentRepositories();
        $obj_user = new User();
        $obj_mail_schedule = new MailSchedule();
        $obj_trans_payment = new TransactionPayment();
        $obj_mailable_controller = new MailableController();
        $obj_prediction = new Prediction();

        // Get user
        $user = $obj_user->getDetailUserById($trans_payment->user_id);
        $data_replace = (array) $user;
        $data_replace["user_point"] = $data_replace["point"];
        $data_replace["trans_point"] = $trans_payment->point;
        $link_replace = '/user_key/' . $user->user_key . '?c=prediction-detail&id=' . $trans_payment->prediction_id;
        $data_replace["url_prediction_detail"] = url($link_replace);

        // Get prediction
        $prediction = $obj_prediction->getPredictionById($trans_payment->prediction_id);
        $data_replace["prediction_name"] = $prediction->name;

        // Get mail payment
        $list_mail_payment = $obj_mail_schedule->getMailScheduleTarget(MAIL_SCHEDULE_TARGET_PAYMENT);
        $trans_register_time = $trans_payment->updated_at;
        $now = \Carbon\Carbon::now()->timestamp;

        // Mail trans payment
        $trans_mail_payment = json_decode($trans_payment->mail_payment);

        // Send mail register
        foreach ($list_mail_payment as $mail_payment) {
            $elapsed_time = explode(":", $mail_payment->elapsed_time);
            $data_elapsed_day = $elapsed_time[0];
            $data_elapsed_hour = $elapsed_time[1];
            $data_elapsed_minute = $elapsed_time[2];

            // Time send
            $time_send = date('Y-m-d H:i:s', strtotime('+' . $data_elapsed_day . ' day +' . $data_elapsed_hour .
                ' hour + ' . $data_elapsed_minute . ' minutes', strtotime($trans_register_time)));

            // Check time
            if ($now >= strtotime($time_send) && !isset($trans_mail_payment[$mail_payment->id])) {
                $input = [
                    "transaction_payment_id" => $trans_payment->id,
                    "mail_template_payment_id" => $mail_payment->id,
                    "mail_from_address" => $mail_payment->mail_from_address,
                    "mail_from_name" => $mail_payment->mail_from_name,
                    "mail_to_address" => $user->mail_pc,
                    "mail_to_name" => $user->nickname,
                    "mail_title" => $mail_payment->mail_title,
                    "mail_body" => $mail_payment->mail_body,
                ];

                // Send mail
                $send_status = $obj_mailable_controller->sendMailByMailable($input, $data_replace);

                // Data mail register detail
                $input["user_id"] = $user->user_id;
                $input["id"] = 0;
                $input["status"] = $send_status;
                $input["read_at"] = null;
                $input["mail_body"] = $obj_mailable_controller->replaceMail($input["mail_body"], $data_replace);

                // Save mail deposit
                $mailPaymentRepositories->storeMailPayment($input);
                unset($input);

                // Update transaction payment
                $obj_trans_payment->addSendMailPayment($trans_payment->id, $mail_payment->id);
            }
        }
    }

    public function sendMailBulk($user_id, $mail_bulk)
    {
        $mailBulkDetailRepositories = new MailBulkDetailRepositories();
        $obj_user = new User();
        $obj_mailable_controller = new MailableController();

        // Get user
        $user = $obj_user->getDetailUserById($user_id);
        $data_replace = (array) $user;

        // Send mail register
        $input = [
            "mail_bulk_id" => $mail_bulk->id,
            // "mail_from_address" => $mail_bulk->mail_from_address,
            "mail_from_address" => "info@rewrite.com",
            "mail_from_name" => $mail_bulk->mail_from_name,
            "mail_to_address" => $user->mail_pc,
            "mail_to_name" => $user->nickname,
            "mail_title" => $mail_bulk->mail_title,
            "mail_body" => $mail_bulk->mail_body,
        ];
        // // Send mail
        // if(strpos(strtoupper($user->mail_pc), strtoupper('gmail')) !== false){
        // // Send mail
        //     $status = $obj_mailable_controller->sendMailByMailableWithAmazon($input, $data_replace, $mail_bulk->id);
        // //    $send_status = SEND_MAIL_STATUS_SUCCESS;
        // } else {
            $status = $obj_mailable_controller->sendMailByMailable($input, $data_replace, $mail_bulk->id);
        // }
        //    $send_status = SEND_MAIL_STATUS_SUCCESS;

        // Data mail register detail
        $input["user_id"] = $user->user_id;
        $input["id"] = 0;
        // luu log vao data
        $input["status"] = $status;
        // 
        $input["read_at"] = null;
        $input["mail_body"] = $obj_mailable_controller->replaceMail($input["mail_body"], $data_replace,$mail_bulk->id);

        // Save mail bulk detail
        $mailBulkDetailRepositories->storeMailBulkDetail($input);

        return $status;
    }

    public function sendMailSchedule($user_id, $mail_schedule)
    {
        $mailScheduleDetailRepositories = new MailScheduleDetailRepositories();
        $obj_user = new User();
        $obj_mailable_controller = new MailableController();

        // Get user
        $user = $obj_user->getDetailUserById($user_id);
        $data_replace = (array) $user;

        // Send mail register
        $input = [
            "mail_schedule_id" => $mail_schedule->id,
            // "mail_from_address" => $mail_schedule->mail_from_address,
            "mail_from_address" => "info@rewrite.com",
            "mail_from_name" => $mail_schedule->mail_from_name,
            "mail_to_address" => $user->mail_pc,
            "mail_to_name" => $user->nickname,
            "mail_title" => $mail_schedule->mail_title,
            "mail_body" => $mail_schedule->mail_body,
        ];

        // Send mail
        $send_status = $obj_mailable_controller->sendMailByMailable($input, $data_replace);

        // Data mail register detail
        $input["user_id"] = $user->user_id;
        $input["id"] = 0;
        $input["status"] = $send_status;
        $input["read_at"] = null;
        $input["mail_body"] = $obj_mailable_controller->replaceMail($input["mail_body"], $data_replace);

        // Save mail schedule detail
        $mailScheduleDetailRepositories->storeMailScheduleDetail($input);

        return $send_status;
    }

    public function sendMailPredictionResult($user_id, $pre_result, $trans_id)
    {
        $mailPredictionResultRepositories = new MailPredictionResultRepositories();
        $obj_user = new User();
        $obj_mailable_controller = new MailableController();

        // Get user
        $user = $obj_user->getDetailUserById($user_id);
        $data_replace = (array) $user;
        $data_replace["prediction_id"] = $pre_result->id;
        $link_replace = '/user_key/' . $user->user_key . '?c=prediction-detail&id=' . $pre_result->id;
        $data_replace["url_prediction_detail"] = url($link_replace);

        // Send mail register
        $input = [
            "prediction_id" => $pre_result->id,
            "transaction_prediction_result_id" => $trans_id,
            "mail_from_address" => MAIL_FROM_ADDRESS,
            "mail_from_name" => MAIL_FROM_NAME,
            "mail_to_address" => $user->mail_pc,
            "mail_to_name" => $user->nickname,
            "mail_title" => $pre_result->mail_title,
            "mail_body" => $pre_result->mail_body . $data_replace["url_prediction_detail"],
        ];

        // Send mail
        $send_status = $obj_mailable_controller->sendMailByMailable($input, $data_replace);

        // Data mail register detail
        $input["user_id"] = $user->user_id;
        $input["id"] = 0;
        $input["status"] = $send_status;
        $input["read_at"] = null;
        $input["mail_body"] = $obj_mailable_controller->replaceMail($input["mail_body"], $data_replace);

        // Save mail prediction result detail
        $mailPredictionResultRepositories->storeMailPredictionResult($input);

        return $send_status;
    }

    public function sendMailPredictionOpen($user_id, $pre_open)
    {
        $mailPredictionOpenRepositories = new MailPredictionOpenRepositories();
        $obj_user = new User();
        $obj_mailable_controller = new MailableController();

        // Get user
        $user = $obj_user->getDetailUserById($user_id);
        $data_replace = (array) $user;
        $data_replace["prediction_id"] = $pre_open->id;
        $link_replace = '/user_key/' . $user->user_key . '?c=prediction-detail&id=' . $pre_open->id;
        $data_replace["url_prediction_detail"] = url($link_replace);

        // Send mail register
        $input = [
            "prediction_id" => $pre_open->id,
            "mail_from_address" => MAIL_FROM_ADDRESS,
            "mail_from_name" => MAIL_FROM_NAME,
            "mail_to_address" => $user->mail_pc,
            "mail_to_name" => $user->nickname,
            "mail_title" => $pre_open->mail_title,
            "mail_body" => $pre_open->mail_body . $data_replace["url_prediction_detail"],
        ];

        // Send mail
        $send_status = $obj_mailable_controller->sendMailByMailable($input, $data_replace);

        // Data mail register detail
        $input["user_id"] = $user->user_id;
        $input["id"] = 0;
        $input["status"] = $send_status;
        $input["read_at"] = null;
        $input["mail_body"] = $obj_mailable_controller->replaceMail($input["mail_body"], $data_replace);

        // Save mail prediction result detail
        $mailPredictionOpenRepositories->storeMailPredictionOpen($input);

        return $send_status;
    }

    public function mailBulk(Request $request,
        MediaRepositories $mediaRepositories,
        UserStageRepositories $userStageRepositories,
        PredictionTypeRepositories $predictionTypeRepositories,
        MailBulkRepositories $mailBulkRepositories,
        EntranceRepositories $entranceRepositories) {
        $data["mail_bulk"] = $mailBulkRepositories->getInfoMailBulk();
        $data["user_stage"] = $userStageRepositories->getListUserStage();
        $data["media"] = $mediaRepositories->getListMedia();
        $data['prediction_type'] = $predictionTypeRepositories->getPredictionType();
        $data["entrance"] = $entranceRepositories->getListEntrance();
        return view('horserace::backend.mail.mail_bulk', compact("data"));
    }

    public function mailBulkAjax(Request $request,  MailBulkRepositories $mailBulkRepositories)
    {
      $input = $request->all();
      $result = $mailBulkRepositories->getSearchInfoMailBulk($input);
      $data = [
        "draw" => 0,
        "recordsTotal" => $result['total'],
        "recordsFiltered" => $result['total'],

      ];
      $data['data'] = array();

      foreach ($result['result'] as $item) {
        if ($item->status == MAIL_BULK_STATUS_NOT_SEND) {
          $send = '<button type="button" class="btn btn-warning change-status-mail" data-id-mail="' . $item->id . '" data-title="' . $item->mail_title . '" data-toggle="modal" data-target="#changeStatusMail">配信中止</button>';
        } else {
          $send = '';
        }

        if ($item->status == MAIL_BULK_STATUS_SENDING) {
          $item->send_datetime = '送信中';
        }

        $data['data'][] = [
          $item->id,
          $item->reserve_datetime,
          $item->send_datetime,
          $item->mail_title,
          $item->total_user,
          $item->send_success_number,
          $item->read_number,
          $item->daemon . '(' . $item->rate_daemon . '%)',
          [
            'id' => $item->id,
            'condition' => $item->condition
          ],
          // '<button class="btn btn-info review-condition" data-id-mail="'.$item->id.'" data-condition="'.$item->condition.'" data-toggle="modal" data-target="#reviewCondition">  条件 </button>',
          '<button class="btn btn-info review-mail" data-id-mail="' . $item->id . '" data-reserve-datetime="' . date_format(date_create($item->reserve_datetime), "Y-m-d H:i:s") . '" data-mail-from-address="' . $item->mail_from_address . '" data-mail-from-name="' . $item->mail_from_name . '" data-mail-title="' . $item->mail_title . '" data-mail-body="' . strip_tags($item->mail_body) . '" data-toggle="modal" data-target="#reviewContent"> 内容</button>',
          $send
        ];
      }
      return response()->json($data);
    }

    public function applyMailBulk(Request $request, MailBulkRepositories $mailBulkRepositories)
    {        
        $input = $request->all();
        unset($input["_token"]);
        unset($input["files"]); 
        $obj_mail_bulk = new MailBulk();
        $mail_bulk_by_id = $obj_mail_bulk->getMailBulkById($input['id']);
        $mail_bulk_by_id->mail_from_address = $input['mail_from_address']; 
        $mail_bulk_by_id->mail_from_name = $input['mail_from_name'];
        $mail_bulk_by_id->mail_title = $input['mail_title'];
        $mail_bulk_by_id->reserve_datetime = $input['reserve_datetime'];
        $mail_bulk_by_id->mail_body = $input['mail_body'];        
        $input = (array)$mail_bulk_by_id;
        $result = $mailBulkRepositories->applyMailBulk($input['id'],$input);
        return redirect()->route('admin.mail_bulk')->with([
        'flash_level' => $result["status"],
        'flash_message' => $result["message"],
        ]);
    }
    public function applyMailSchedule(Request $request, MailScheduleRepositories $mailScheduleRepositories)
    {        
        $input = $request->all();
        unset($input["_token"]);
        unset($input["files"]); 
        $obj_mail_echedule = new MailSchedule();
        $mail_echedule_by_id = $obj_mail_echedule->getMailScheduleById($input['id']);
        $mail_echedule_by_id->mail_from_address = $input['mail_from_address']; 
        $mail_echedule_by_id->mail_from_name = $input['mail_from_name'];
        $mail_echedule_by_id->mail_title = $input['mail_title'];
        //$mail_echedule_by_id->reserve_datetime = $input['reserve_datetime'];
        $mail_echedule_by_id->mail_body = $input['mail_body'];        
        $input = (array)$mail_echedule_by_id;
        $result = $mailScheduleRepositories->applyMailSchedule($input['id'],$input);
        return redirect()->route('admin.mail_schedule')->with([
        'flash_level' => $result["status"],
        'flash_message' => $result["message"],
        ]);
    }

    public function addMailBulk(Request $request,
        MailTemplateRepositories $mailTemplateRepositories) { 
        $input = $request->all();
        $data["condition"] = isset($input["condition"]) ? $input["condition"] : null;
        $data["mail_template"] = $mailTemplateRepositories->getMailTemplate();       
        return view('horserace::backend.mail.add_mail_bulk', compact("data"));
    }

    public function editMailBulk(Request $request,
        MailTemplateRepositories $mailTemplateRepositories,
        MailBulkRepositories $mailBulkRepositories,
        $id_mail_bulk) {
        $data["mail_template"] = $mailTemplateRepositories->getMailTemplate();
        $data["mail_bulk"] = $mailBulkRepositories->getMailBulkById($id_mail_bulk);
        $data["condition"] = $data["mail_bulk"]->condition;
        return view('horserace::backend.mail.edit_mail_bulk', compact("data"));
    }

    public function storeMailBulk(MailBulkRequest $request,
        MailBulkRepositories $mailBulkRepositories) {
        $input = $request->all();
        $result = $mailBulkRepositories->storeMailBulk($input);
        return redirect()->route("admin.user.search")->with([
            "flash_level" => $result["status"],
            "flash_message" => $result["message"],
        ]);
    }

    public function stopMailBulk(Request $request,
        MailBulkRepositories $mailBulkRepositories) {
        $input = $request->all();
        $result = $mailBulkRepositories->changeStatusMailBulk(trim($input["id_mail"]), MAIL_BULK_STATUS_STOP);
        return redirect()->route("admin.mail_bulk")->with([
            "flash_level" => $result["status"],
            "flash_message" => $result["message"],
        ]);
    }

    public function mailSchedule(Request $request,
        MediaRepositories $mediaRepositories,
        UserStageRepositories $userStageRepositories,
        PredictionTypeRepositories $predictionTypeRepositories,
        MailScheduleRepositories $mailScheduleRepositories,
        EntranceRepositories $entranceRepositories) {
        $data["mail_schedule"] = $mailScheduleRepositories->getMailSchedule();
        $data["user_stage"] = $userStageRepositories->getListUserStage();
        $data["media"] = $mediaRepositories->getListMedia();
        $data['prediction_type'] = $predictionTypeRepositories->getPredictionType();
        $data["entrance"] = $entranceRepositories->getListEntrance();
        return view('horserace::backend.mail.mail_schedule', compact("data"));
    }

    public function addMailSchedule(Request $request,
        MediaRepositories $mediaRepositories,
        EntranceRepositories $entranceRepositories,
        UserStageRepositories $userStageRepositories,
        PredictionTypeRepositories $predictionTypeRepositories,
        MailTemplateRepositories $mailTemplateRepositories) {
        $data["mail_template"] = $mailTemplateRepositories->getMailTemplate();
        $data["user_stage"] = $userStageRepositories->getListUserStage();
        $data["media"] = $mediaRepositories->getListMedia();
        $data["entrance"] = $entranceRepositories->getListEntrance();
        $data['prediction_type'] = $predictionTypeRepositories->getPredictionType();
        return view('horserace::backend.mail.add_mail_schedule', compact("data"));
    }

    public function editMailSchedule(Request $request,
        MediaRepositories $mediaRepositories,
        UserStageRepositories $userStageRepositories,
        EntranceRepositories $entranceRepositories,
        MailTemplateRepositories $mailTemplateRepositories,
        MailScheduleRepositories $mailScheduleRepositories,
        PredictionTypeRepositories $predictionTypeRepositories,
        $id_mail_schedule) {
        $data["mail_template"] = $mailTemplateRepositories->getMailTemplate();
        $data["mail_schedule"] = $mailScheduleRepositories->getMailScheduleById($id_mail_schedule);

        if (!$data["mail_schedule"]) {
            abort(404);
        }

        $data["condition"] = json_decode($data["mail_schedule"]->condition, true);
        $data["user_stage"] = $userStageRepositories->getListUserStage();
        $data["media"] = $mediaRepositories->getListMedia();
        $data["entrance"] = $entranceRepositories->getListEntrance();
        $data['prediction_type'] = $predictionTypeRepositories->getPredictionType();
        return view('horserace::backend.mail.edit_mail_schedule', compact("data"));
    }

    public function storeMailSchedule(MailScheduleRequest $request,
        MailScheduleRepositories $mailScheduleRepositories) {
        $input = $request->all();
        $arr_condition = [
            "gender" => isset($input["gender"]) ? $input["gender"] : null,
            "login_id" => $input["login_id"],
            "point_min" => $input["point_min"],
            "point_max" => $input["point_max"],
            "user_key" => $input["user_key"],
            "deposit_total_amount_min" => $input["deposit_total_amount_min"],
            "deposit_total_amount_max" => $input["deposit_total_amount_max"],
            "nickname" => $input["nickname"],
            "deposit_total_number_min" => $input["deposit_total_number_min"],
            "deposit_total_number_max" => $input["deposit_total_number_max"],
            "member_level" => $input["member_level"] ?? '',
            "login_number_min" => $input["login_number_min"],
            "login_number_max" => $input["login_number_max"],
            "mail_pc" => $input["mail_pc"],
            "last_payment_time_start" => $input["last_payment_time_start"],
            "last_payment_time_end" => $input["last_payment_time_end"],
            "mail_mobile" => $input["mail_mobile"],
            "register_time_start" => $input["register_time_start"],
            "register_time_end" => $input["register_time_end"],
            "age" => $input["age"],
            "last_login_time_start" => $input["last_login_time_start"],
            "last_login_time_end" => $input["last_login_time_end"],
//      "last_access_time_start" => $input["last_access_time_start"],
            //      "last_access_time_end" => $input["last_access_time_end"],
            "first_deposit_time_start" => $input["first_deposit_time_start"],
            "first_deposit_time_end" => $input["first_deposit_time_start"],
            "last_deposit_time_start" => $input["last_deposit_time_start"],
            "last_deposit_time_end" => $input["last_deposit_time_end"],
            "ip" => $input["ip"],
            "first_payment_time_start" => $input["first_payment_time_start"],
            "first_payment_time_end" => $input["first_payment_time_end"],
            "prediction_type" => $input["prediction_type"],
            "media_code" => $input["media_code"],
            "entrance_id" => $input["entrance_id"],
            "user_stage_id" => isset($input["user_stage_id"]) ? $input["user_stage_id"] : null,
            "search_match_type" => $input["search_match_type"],
        ];

        $input["condition"] = json_encode($arr_condition);
        $result = $mailScheduleRepositories->storeMailSchedule($input);
        return redirect()->route("admin.mail_schedule")->with([
            "flash_level" => $result["status"],
            "flash_message" => $result["message"],
        ]);
    }

    public function deleteMailSchedule(Request $request,
        MailScheduleRepositories $mailScheduleRepositories) {
        $input = $request->all();
        $mail_schdeule_id = trim($input["id_delete"]);
        $result = $mailScheduleRepositories->deleteMailSchedule($mail_schdeule_id);
        return redirect()->route("admin.mail_schedule")->with([
            "flash_level" => $result["status"],
            "flash_message" => $result["message"],
        ]);
    }

    public function mailContact(Request $request,
        UserRepositories $userRepositories,
        UserStageRepositories $userStageRepositories,
        MediaRepositories $mediaRepositories,
        MailTemplateRepositories $mailTemplateRepositories,
        MailBulkDetailRepositories $mailBulkDetailRepositories,
        MailContactRepositories $mailContactRepositories,
        MailBanRepositories $mailBanRepositories) {
        // Session Mail unread
        $mail_unread = $mailContactRepositories->numberMailContactUnread();
        $request->session()->put('number_mail_unread', $mail_unread);

        //
        $input = $request->all();
        
        $input["read_unread"] = isset($input["read_unread"]) ? $input["read_unread"] : UNREAD;
        $input["user_stage"] = isset($input["user_stage"]) ? $input["user_stage"] : null;     
        $data["media"] = $mediaRepositories->getListMedia();
        $data["search"] = $input;

        // User stage
        $list_user_stage = $userStageRepositories->getListUserStage();
        $arr_user_stage = array();
        foreach ($list_user_stage as $item) {
            $arr_user_stage[$item->id] = $item;
        }

        $data["user_stage"] = $arr_user_stage;


        $data['mail_contact'] =array();
        $check_isset_login_id = isset($input['login_id']);
        $obj_user = new User();
        $array_obj_user = [];
        $arr_mail_contact=array();
         // Get current page from query string
        $currentPage = isset($_GET['page']) ? (int) $_GET['page'] : 1;

         // Items per page
        $perPage = 15;//  PAGINATE_MAIL_BOX;
        $page_mail_for_user = 0;
        $limit_mail_for_user = 40;
        if(isset($input['user_id']) && isset($input['page']))
        {
          
            if(is_numeric($input['user_id']))   
            {      
                $obj_user_by_id =  $obj_user->getUserById($input['user_id']);
                if($obj_user_by_id!=null)
                    $input['login_id'] =$obj_user_by_id->login_id;
                $arr_mail = $mailContactRepositories->searchMailContact($input, $input['page'],  $limit_mail_for_user);
                if($arr_mail!=null)
                {             
                    foreach($arr_mail as $mail)
                        array_push($data['mail_contact'], $mail);
                }
                $obj_mail_bulk = new MailBulk();
                $arr_mail =  $obj_mail_bulk->searchMailBulkByCondition($input, $page_mail_for_user,  $limit_mail_for_user); //$mailBulkDetailRepositories->searchMailBulkDetailToShowMailContactPage($input, $page_mail_for_user,  $limit_mail_for_user); 
                if($arr_mail!=null)
                {
                    foreach($arr_mail as $mail)
                    {
                        $mail->user_id = $input['user_id'];
                        $mail->status = MAIL_CONTACT_ADMIN_SEND;
                        $obj_user_by_id = $obj_user->getUserById($input['user_id']);
                        if($obj_user_by_id!=null)
                        {
                            $mail->mail_to_address = $obj_user_by_id->mail_pc;
                            $mail->mail_to_name = $obj_user_by_id->nickname;;
                        }
                        $mail->sys_send = true;
                        array_push($data['mail_contact'], $mail);
                    }
                }
                
            }
            else
            {
                $arr_mail_history = $mailContactRepositories->getMailAdminUnreadByMailPc($mail->mail_pc, $page_mail_for_user, $limit_mail_for_user);
            }
            // return (array)$data['mail_contact'];

        }
        if($input["read_unread"] == UNREAD)
        {
            $arr_mail = $mailContactRepositories->searchMailContact($input);
            foreach($arr_mail as $key=>$value)
            {
                $user = $obj_user->getUserById($arr_mail[$key]->user_id);
                if($user!=null)
                {
                    $arr_obj_user[$user->id] = $user;
                   
                }
            }
            $data['mail_contact'] = $arr_mail;            
            $currentPage = isset($_GET['page']) ? (int) $_GET['page'] : 1;

            // Items per page
            $perPage = 10;// PAGINATE_MAIL_BOX;
            // dd($arr_mail); 
        }
        else
        {
            $obj_user = new User();
            $array_obj_user = []; 
            $array_user_id = [];

            if(!isset($input['login_id']))
            {
                $obj_mail_contact_resp = new MailContactRepositories();
                $array_user_id_mail_contact= $obj_mail_contact_resp->searchUserIdSendMailContactByCondition($input);
            
                
                if(!isset($input["order"]))
                {
                    $array_user_id_mail_contact  = array_reverse($array_user_id_mail_contact);
                }
                else if($input['order']!="created_at_asc")
                {
                    $array_user_id_mail_contact  = array_reverse($array_user_id_mail_contact);
                }
            

                $obj_mail_bulk_detail_resp = new MailBulkDetailRepositories();
                $array_user_id_mail_bulk_detail = $obj_user->searchUserIdSendMailByCondition($input); 
                if(!isset($input["order"]))
                {
                    $array_user_id_mail_bulk_detail  = array_reverse($array_user_id_mail_bulk_detail);
                }
                else if($input['order']!="created_at_asc")
                {
                    $array_user_id_mail_bulk_detail = array_reverse($array_user_id_mail_bulk_detail);
                }
           
                
                $lenght_min = min(count($array_user_id_mail_contact), count($array_user_id_mail_bulk_detail));
                $lenght_max = max(count($array_user_id_mail_contact), count($array_user_id_mail_bulk_detail));
                for ($i=0;$i<$lenght_min;$i++)
                {
                    if(isset($array_user_id_mail_contact[$i]) && !in_array($array_user_id_mail_contact[$i],$array_user_id))
                        array_push($array_user_id,  $array_user_id_mail_contact[$i]);
                    if(isset($array_user_id_mail_bulk_detail[$i]) && !in_array($array_user_id_mail_bulk_detail[$i],$array_user_id))
                        array_push($array_user_id,$array_user_id_mail_bulk_detail[$i]);
                    
                }
                if(count($array_user_id_mail_contact) > count($array_user_id_mail_bulk_detail))
                {
                    for ($i=$lenght_min;$i<$lenght_max;$i++)
                        if(isset($array_user_id_mail_contact[$i]) && !in_array($array_user_id_mail_contact[$i],$array_user_id))
                            array_push($array_user_id,  $array_user_id_mail_contact[$i]);
                }
                else
                {
                    for ($i=$lenght_min;$i<$lenght_max;$i++)
                        if(isset($array_user_id_mail_bulk_detail[$i]) && !in_array($array_user_id_mail_bulk_detail[$i],$array_user_id))
                            array_push($array_user_id,$array_user_id_mail_bulk_detail[$i]);
                }
               
            }
            else
            {
                $ob_user_by_login_id = new User();
                $ob_user_by_login_id= $obj_user->getUserByLoginId($input['login_id']);
                if($ob_user_by_login_id!=null)
                    array_push($array_user_id, $ob_user_by_login_id);
            }
           
            foreach($array_user_id as $key=>$value)
            {
                $us_id = $array_user_id[$key]->id;
                if($obj_user->getUserById($us_id)!=null)
                {
                    $array_obj_user[$us_id] = $obj_user->getUserById($us_id);
                }
            }
                       
            
            if(!$check_isset_login_id)
            {
                
                $input['login_id'] = null;
                $mail_guest = $mailContactRepositories->getMailGuest($input);
                $array_obj_user = array_merge($array_obj_user, $mail_guest);
               
                // Get current items calculated with per page and current page
                $currentItems = array_slice($array_obj_user , $perPage * ($currentPage - 1), $perPage);
                $array_obj_user = new LengthAwarePaginator($currentItems, count($array_obj_user), $perPage);
               
                foreach($array_obj_user as $key=>$value)
                {   
                    if(is_numeric($key))   
                    {      
                        $input['login_id'] = $array_obj_user[$key]->login_id;

                        $arr_mail = $mailContactRepositories->searchMailContact($input, $page_mail_for_user,  $limit_mail_for_user);           
                        if($arr_mail!=null)
                        {             
                            foreach($arr_mail as $mail)
                                array_push($data['mail_contact'], $mail);
                        }
                        $obj_mail_bulk = new MailBulk();
                        $input['user_id'] = $array_obj_user[$key]->id;
                        $arr_mail =  $obj_mail_bulk->searchMailBulkByCondition($input, $page_mail_for_user,  $limit_mail_for_user); //$mailBulkDetailRepositories->searchMailBulkDetailToShowMailContactPage($input, $page_mail_for_user,  $limit_mail_for_user); 
                        if($arr_mail!=null)
                        {
                            foreach($arr_mail as $mail)
                            {
                                $mail->user_id = $input['user_id'];
                                $mail->status = MAIL_CONTACT_ADMIN_SEND;
                                $obj_user_by_id = $obj_user->getUserById($input['user_id']);
                                if($obj_user_by_id!=null)
                                {
                                    $mail->mail_to_address = $obj_user_by_id->mail_pc;
                                    $mail->mail_to_name = $obj_user_by_id->nickname;;
                                }
                                $mail->sys_send= true;
                                array_push($data['mail_contact'], $mail);
                            }
                        }
                    }
                }
            }
            else
            {
                $currentItems = array_slice($array_obj_user , $perPage * ($currentPage - 1), $perPage);
                $array_obj_user = new LengthAwarePaginator($currentItems, count($array_obj_user), $perPage);
                $arr_mail = $mailContactRepositories->searchMailContact($input, $page_mail_for_user,  $limit_mail_for_user);       
                    
                if($arr_mail!=null)
                {             
                    foreach($arr_mail as $mail)
                        array_push($data['mail_contact'], $mail);
                }                
                
                $obj_user_login_id = $obj_user->getUserByLoginId($input['login_id']);
                if($obj_user_login_id!=null)
                    $input['user_id'] = $obj_user_login_id->id;
                $obj_mail_bulk = new MailBulk();
                $arr_mail =  $obj_mail_bulk->searchMailBulkByCondition($input, $page_mail_for_user,  $limit_mail_for_user);
                
                if($arr_mail!=null)
                {
                    
                    foreach($arr_mail as $mail)
                    {
                        if(isset($input['user_id']))
                        {
                            $mail->user_id = $input['user_id'];
                            $mail->status = MAIL_CONTACT_ADMIN_SEND;
                            $obj_user_by_id = $obj_user->getUserById($input['user_id']);
                            if($obj_user_by_id!=null)
                            {
                                $mail->mail_to_address = $obj_user_by_id->mail_pc;
                                $mail->mail_to_name = $obj_user_by_id->nickname;;
                            }
                            $mail->sys_send= true;
                            array_push($data['mail_contact'], $mail);
                        }
                    }
                }
            }
        }
        
        if(!isset($input["order"]))
        {
            usort($data['mail_contact'], function($a, $b) {
                return $b->created_at <=> $a->created_at;
            });
        }
        else if($input['order']!="created_at_asc")
        {
            usort($data['mail_contact'], function($a, $b) {
                return $b->created_at <=> $a->created_at;
            });
        }
        else
        {
            usort($data['mail_contact'], function($a, $b) {
                return $a->created_at <=> $b->created_at;
            });
        }
        $data["mail_template"] = $mailTemplateRepositories->getMailTemplate();
        
        
        // Mail Detail
        if (isset($data['mail_contact']))
        {
            $arr_mail_contact = array();
            foreach ($data['mail_contact'] as $item) 
            {
                $arr_mail_contact[$item->user_id][] = $item;
                if (!isset($arr_mail_contact[$item->user_id]['user_info'])) 
                {
                    $arr_mail_contact[$item->user_id]['user_info'] = $obj_user->getUserById($item->user_id);     // $array_obj_user_all[$item->user_id]; //           
                    $arr_mail_contact[$item->user_id]['user_info']->admin_not_read = 0;
                    $arr_mail_contact[$item->user_id]['user_info']->total_mail = 0;
                    $arr_mail_contact[$item->user_id]['user_info']->user_send = 0;
                    $arr_mail_contact[$item->user_id]['user_info']->admin_send = 0;

                    // User stage str
                    $user_stage = explode(",", $arr_mail_contact[$item->user_id]['user_info']->user_stage_id);

                    $user_stage_str = '';
                    foreach ($user_stage as $stage_id)
                    {
                        if (isset($arr_user_stage[$stage_id]))
                        {
                            $user_stage_str .= $arr_user_stage[$stage_id]->name . ', ';
                        }
                    }
                    $arr_mail_contact[$item->user_id]['user_info']->user_stage_str = rtrim($user_stage_str, ", ");
                }
                // Last mail
                $arr_mail_contact[$item->user_id]['user_info']->last_mail = $item->created_at;
                // Mail admin not read
                if (is_null($item->admin_read_at))//isset($item->admin_read_at) && is_null($item->admin_read_at))
                {
                
                    $arr_mail_contact[$item->user_id]['user_info']->admin_not_read += 1;
                }
                // Set who send
                if ($item->status == MAIL_CONTACT_ADMIN_SEND)
                {
                    $arr_mail_contact[$item->user_id]['user_info']->admin_send += 1;
                }
                else
                {
                    $arr_mail_contact[$item->user_id]['user_info']->user_send += 1;
                }
                $arr_mail_contact[$item->user_id]['user_info']->total_mail += 1;
            }
        }
        // Mail guest
        
        if (!$check_isset_login_id && $input['user_stage'] == null)
        {
            $input['login_id'] = null;
            $mail_guest = $mailContactRepositories->getMailGuest($input);
            $arr_mail_contact = array_merge($arr_mail_contact, $mail_guest);
            if($input["read_unread"] == UNREAD)
            {
                $array_obj_user = array_merge($array_obj_user, $mail_guest);
                $currentItems = array_slice($array_obj_user , $perPage * ($currentPage - 1), $perPage);
                $array_obj_user = new LengthAwarePaginator($currentItems, count($array_obj_user), $perPage); 
            }
        }

        // Get mail history
        if ($input["read_unread"] == UNREAD)
        {
            foreach ($arr_mail_contact as $key => $item)
            {
                $user_info = $item["user_info"];
                if ($user_info->id != 0)
                {
                    $obj_mail_bulk = new MailBulk();
                    $input['user_id'] = $user_info->id;
                    $arr_mail_bulk_detail_history =  $obj_mail_bulk->searchMailBulkByCondition($input, $page_mail_for_user,  $limit_mail_for_user);
                    $arr_mail_history = $mailContactRepositories->getMailAdminReadByUserIdByCondition($user_info->id, $input, $page_mail_for_user, $limit_mail_for_user);                  
                    foreach($arr_mail_bulk_detail_history as $mail_bulk_detail_history)
                    {
                        $mail_bulk_detail_history->sys_send=true;
                        $mail_bulk_detail_history->user_id = $input['user_id'];
                        $mail_bulk_detail_history->status = MAIL_CONTACT_ADMIN_SEND;                     
                        array_push($arr_mail_history, $mail_bulk_detail_history);
                    }
                } 
                else
                {
                    $arr_mail_history = $mailContactRepositories->getMailAdminReadByMailPcByCondition($user_info->mail_pc, $input, $page_mail_for_user, $limit_mail_for_user);
                }
               
                $arr_mail_contact[$key] = array_merge($arr_mail_contact[$key], $arr_mail_history);
               
            }
        }
        if($array_obj_user!=null)
        {
            $array_obj_user  = $array_obj_user ->setPath($request->url());
            $array_obj_user ->withPath('mail-contact');
        }

        uasort($arr_mail_contact, function($a, $b) {
            return $b[0]->created_at <=> $a[0]->created_at;
        });

        // if ($input["read_unread"] == UNREAD){
        //     $data_for_page = $arr_mail_contact; 
        // }else{

        //     $data_for_page = array();

        //     foreach ($arr_mail_contact as $k => $value){
        //         foreach ($array_obj_user as $key => $item){
        //             if(is_numeric($key)){
        //                 $mail_user= $item->mail_pc;
        //             }else{
        //                 $mail_user= $key;
        //             }
        //             if($mail_user == $value["user_info"]->mail_pc){
        //                 $data_for_page[$mail_user] = $value;
        //             }
        //         }
        //     }
        // }
        $input['user_id'] =null;
        $search = $input;
        //$arr_mail_contact = $data_for_page;
 
        return view('horserace::backend.mail.mail_contact', compact('data', 'arr_mail_contact', 'array_obj_user', 'search'));
    }

    

    public function moreMailUser(Request $request, 
    MailBulkDetailRepositories $mailBulkDetailRepositories,
    MailContactRepositories $mailContactRepositories)
    {
      
        $input = $request->all();  
        $data = [];
        $limit_mail_for_user = 3;

        if(is_numeric($input['user_id']))
        {
            //$input['login_id'] = $input['login_id_ajax'];
           // $arr_mail = $mailContactRepositories->searchMailContact($input, $input['page'],  $limit_mail_for_user);  
            $arr_mail_bulk_detail_history = $mailBulkDetailRepositories->getMailBulkDetailByUserIdToShowMailContactPage($input['user_id'], $input['page'], $limit_mail_for_user);  
           // $obj_mail_bulk = new MailBulk();
            //$arr_mail_bulk_detail_history =  $obj_mail_bulk->searchMailBulkByCondition($input, $page_mail_for_user,  $limit_mail_for_user);

            $arr_mail_history = $mailContactRepositories->getMailAdminUnreadByUserId($input['user_id'], $input['page'], $limit_mail_for_user);

            foreach($arr_mail_history as $mail)
            {
                array_push($data, $mail);
            }

            foreach($arr_mail_bulk_detail_history as $mail)
            {
                //$mail->user_id = $input['user_id'];
                //$mail->status = MAIL_CONTACT_ADMIN_SEND;
                array_push($data, $mail);
            }
            
        } 
        else
        {
            $arr_mail_history = $mailContactRepositories->getMailAdminUnreadByMailPc($input['user_id'], $input['page'], $limit_mail_for_user);   
            if($arr_mail_history!=null)
            {
                foreach($arr_mail_history as $mail)
                    array_push($data, $mail);
            }           
        }  
        return (array) $data;
    }

    public function sendMailContact(Request $request,
        MailContactRepositories $mailContactRepositories) {
        $input = $request->all();
        $obj_mailable_controller = new MailableController();
        // Read mail
        if (trim($input["user_id"]) == GUEST_0) {
            $mailContactRepositories->adminReadMailGuest(trim($input["mail_to_address"]));            
        } else {
            $mailContactRepositories->adminReadMailByUserId(trim($input["user_id"]));
        }

        $obj_user = new User();

        // Data mail contact
        $data = [
            'user_id' => trim($input['user_id']),
            'mail_from_address' => MAIL_FROM_ADDRESS,
            'mail_from_name' => MAIL_FROM_NAME,
            'mail_to_address' => trim($input['mail_to_address']),
            'mail_to_name' => trim($input['mail_to_name']),
            'mail_title' => trim($input['mail_title']),
            'mail_body' => trim($input['mail_body']),
            'admin_read_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'status' => MAIL_CONTACT_ADMIN_SEND,
        ];
        // Get user
        $user = $obj_user->getDetailUserById(trim($input['user_id']));
        $data_replace = (array) $user;
        $send_status = $obj_mailable_controller->sendMailByMailable($data, $data_replace);

        $data["mail_body"] = $obj_mailable_controller->replaceMail($input["mail_body"], $data_replace);

        $result = $mailContactRepositories->mailContactStore($data);

        return redirect()->route('admin.mail_contact')->with([
            'flash_level' => $result["status"],
            'flash_message' => $result["message"],
        ]);
    }

    public function sendListMailContact(Request $request,
        MailContactRepositories $mailContactRepositories) 
    {
        $input = $request->all();
        $obj_mailable_controller = new MailableController();
        
        // Data mail contact 
        $arr_user_id = explode(",", $input["list_user_id"]);
        $arr_mail_to_name = explode(",",$input["list_mail_to_name"]);
        $arr_mail_to_address = explode(",", $input["list_mail_to_address"]);
        $result=[];
        for($i=0; $i<count($arr_user_id);$i++)
        {
                // Read mail
            $arr_user_id[$i] = trim($arr_user_id[$i]);
            if(!is_numeric($arr_user_id[$i] ))
             $arr_user_id[$i] = GUEST_0;

            if ($arr_user_id[$i] == GUEST_0) 
            {
                $mailContactRepositories->adminReadMailGuest(trim($arr_mail_to_address[$i]));                
            }
            else 
            {
                $mailContactRepositories->adminReadMailByUserId($arr_user_id[$i]);
            }
            
           
                            
            $data = [
                'user_id' => $arr_user_id[$i],
                'mail_from_address' => MAIL_FROM_ADDRESS,
                'mail_from_name' => MAIL_FROM_NAME,
                'mail_to_address' => trim($arr_mail_to_address[$i]),  
                'mail_to_name' => trim($arr_mail_to_name[$i]),
                'mail_title' => trim($input['mail_title']),
                'mail_body' => trim($input['mail_body']),
                'admin_read_at' => \Carbon\Carbon::now()->toDateTimeString(),   
                'status' => MAIL_CONTACT_ADMIN_SEND, 
            ];

            // Get user
            $obj_user = new User();
            $user = $obj_user->getDetailUserById($arr_user_id[$i]);            
            $data_replace = (array) $user;
            

            $send_status = $obj_mailable_controller->sendMailByMailable($data, $data_replace);

            $data["mail_body"] = $obj_mailable_controller->replaceMail($input["mail_body"], $data_replace);
             
            $result = $mailContactRepositories->mailContactStore($data);
            
        }

        return redirect()->route('admin.mail_contact')->with([
            'flash_level' => $result["status"],
            'flash_message' => $result["message"],
        ]);
    }

    public function adminReadMailContact(Request $request,
        MailContactRepositories $mailContactRepositories) {
        $input = $request->all();
        $user_id = trim($input["user_id"]);
        if ($user_id == GUEST_0) {
            $mailContactRepositories->adminReadMailGuest(trim($input["mail_pc"]));
        } else {
            $mailContactRepositories->adminReadMailByUserId($user_id);
        }
        return redirect()->route('admin.mail_contact')->with([
            'flash_level' => "success",
            'flash_message' => __("horserace::be_msg.change_status_read_mail_contact_success"),
        ]);
    }

    public function adminDeletedMailContact(Request $request,
        MailContactRepositories $mailContactRepositories) {
        $input = $request->all();
        $user_id = trim($input["user_id"]);
        if ($user_id == GUEST_0) {
            $result = $mailContactRepositories->adminDeletedMailGuest(trim($input["mail_pc"]));
        } else {
            $result = $mailContactRepositories->adminDeletedMailByUserId($user_id);
        }
        return redirect()->route('admin.mail_contact')->with([
            'flash_level' => $result["status"],
            'flash_message' => $result["message"],
        ]);
    }

    public function adminReadAllMailContact(Request $request,
        MailContactRepositories $mailContactRepositories) {
        $input = $request->all();
        $arr_user_id = explode(",", $input["list_user_id"]);
        $result = $mailContactRepositories->adminReadAllMail($arr_user_id);
        return redirect()->route('admin.mail_contact')->with([
            'flash_level' => $result["status"],
            'flash_message' => $result["message"],
        ]);
    }

    public function adminDeletedAllMailContact(Request $request,
        MailContactRepositories $mailContactRepositories) {
        $input = $request->all();
        $arr_user_id = explode(",", $input["list_user_id"]);
        $result = $mailContactRepositories->adminDeletedAllMail($arr_user_id);
        return redirect()->route('admin.mail_contact')->with([
            'flash_level' => $result["status"],
            'flash_message' => $result["message"],
        ]);
    }

    public function mailContactDelete(Request $request,
        MailContactRepositories $mailContactRepositories) {
        $input = $request->all();
        $result = $mailContactRepositories->mailContactDelete($input);
        return redirect()->route('admin.mail_contact')->with([
            'flash_level' => $result["status"],
            'flash_message' => $result["message"],
        ]);
    }

    public function testMail(Request $request,
        MailContactRepositories $mailContactRepositories) {
//    $path = route("login", 'ref=' . "123");
        //    dd($path);
        //    $mail_to_address = "h.m.34341@i.softbank.jp";
        //    $mail_from_address = "info@1and0nly.jp";
        //    $verifyEmail = new VerifyEmail($mail_to_address, $mail_from_address);
        //    dd($verifyEmail->verify());
        //    $number = $mailContactRepositories->numberMailContactUnread();
        //    dd($number);
    }

  // public function testMailPop()
  // {
  //     $mbox = imap_open("{pop21.gmoserver.jp}", "info@kamikeirin.jp", "NwYW#5hp")
  //     or die("can't connect: " . imap_last_error());

  //     $list = imap_list($mbox, "{pop21.gmoserver.jp}", "*");
  //     if (is_array($list)) {
  //         foreach ($list as $val) {
  //             echo imap_utf7_decode($val) . "<br />\n";
  //         }
  //     } else {
  //         echo "imap_list failed: " . imap_last_error() . "\n";
  //     }

  //     // Check
  //     $check = imap_mailboxmsginfo($mbox);

  //     if ($check) {
  //         echo "Date: " . $check->Date . "<br />\n";
  //         echo "Driver: " . $check->Driver . "<br />\n";
  //         echo "Mailbox: " . $check->Mailbox . "<br />\n";
  //         echo "Messages: " . $check->Nmsgs . "<br />\n";
  //         echo "Recent: " . $check->Recent . "<br />\n";
  //         echo "Unread: " . $check->Unread . "<br />\n";
  //         echo "Deleted: " . $check->Deleted . "<br />\n";
  //         echo "Size: " . $check->Size . "<br />\n";
  //     } else {
  //         echo "imap_mailboxmsginfo() failed: " . imap_last_error() . "<br />\n";
  //     }

  //     $emails = imap_search($mbox, 'ALL');
  //     $arr_mail_reg = array();

  //     echo "<==============  List mail START ===================>" . "<br />\n";

  //     /* if emails are returned, cycle through each... */
  //     if ($emails) {

  //         /* begin output var */
  //         $output = '';

  //         /* put the newest emails on top */
  //         rsort($emails);

  //         /* for every email... */
  //         foreach ($emails as $email_number) {
  //             $output .= "==== MAIL NUMBER " . $email_number . " ====" . "<br />\n";
  //             /* get information specific to this email */
  //             $overview = imap_fetch_overview($mbox, $email_number, 0);

  //             // Set seen, 1 seen, 0 not seen
  //             if ($overview[0]->draft == 1) {
  //                 $temp_from = $overview[0]->from;
  //                 $start = strpos($temp_from, "<");
  //                 $end = strpos($temp_from, ">");
  //                 $mail = substr($temp_from, $start + 1, ($end - $start - 1));

  //                 $arr_mail_reg[] = $mail;
  //             }

  //             $from_address = str_replace("<", "", $overview[0]->from);
  //             $from_address = str_replace(">", "", $from_address);
  //             $output .= htmlentities($overview[0]->subject) . '<br>';
  //             $output .= 'Subject:  ' . $overview[0]->subject . '</br>';
  //             $output .= 'From:  ' . $from_address . '</br>';
  //             $output .= 'Message:  ' . imap_fetchbody($mbox, $email_number, 1, FT_PEEK) . '</br>';
  //         }
  //         echo $output;
  //     }

  //     echo "<==============  List mail END ===================>" . "<br />\n";

  //     imap_close($mbox);
  // }


  public function listMailContact(MailContactRepositories $mailContactRepositories)
  {
    return view('horserace::backend.mail.list_mail_contact');
  }

  public function listMailContactAjax(Request $request, MailContactRepositories $mailContactRepositories)
  {
    $input = $request->all();

    $result = $mailContactRepositories->getListMailContact($input);
    
    $data = [
      "draw" => 0,
      "recordsTotal" => $result['total'],
      "recordsFiltered" => $result['total'],
    ];
    $data['data'] = array();
    foreach ($result['result'] as $item) {
      if ($item->id == null)
        $login_id_column = 'GUEST';
      else
        $login_id_column = '<a href="' . route("admin.user.edit", $item->id) . '">' . $item->login_id . '</a>';
      $data['data'][] = [
        $item->created_at,
        $login_id_column,
        $item->mail_title,
        '<a href="#" data-body="' . strip_tags($item->mail_body) . '" class="body-msg" data-toggle="modal" data-target="#modalBodyMail">' . strip_tags(str_limit($item->mail_body, 150)) . '</a>'
      ];
    }
    return response()->json($data);
  }
}
