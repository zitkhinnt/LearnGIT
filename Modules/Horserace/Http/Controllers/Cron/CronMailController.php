<?php

namespace Modules\Horserace\Http\Controllers\Cron;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Horserace\Entities\Gift;
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
use Modules\Horserace\Repositories\GiftRepositories;
use Modules\Horserace\Repositories\UserActivityRepositories;
use Exception;

class CronMailController extends Controller
{
    public function cronMailBulk()
    {
        $time = date('Y-m-d H:i:s a');
        $log['time'] = 'Mail bulk: ' . $time;

        $obj_mail_controller = new MailController();
        $obj_mail_bulk = new MailBulk();
        $obj_mail_bulk_done = new MailBulkDone();

        // Get mail bulk
        $list_mail_bulk = $obj_mail_bulk->getMailBulkSendToday();
        $log["list_mail_bulk"] = $list_mail_bulk;
        foreach ($list_mail_bulk as $mail_bulk) {
            // Update mail bulk
            $arr_mail_bulk = [
                "send_datetime" => \Carbon\Carbon::now()->toDateTimeString(),
                "status" => MAIL_BULK_STATUS_SENDING,
            ];
            $obj_mail_bulk->updateMailBulk($mail_bulk->id, $arr_mail_bulk);

            // Check mail bulk done
            $mail_bulk_done = $obj_mail_bulk_done->getMailBulkDoneByMailBulkId($mail_bulk->id);
            if (!is_null($mail_bulk_done)) {
                continue;
            }

            // Send mail bulk
            $total_send_success_number = 0;

            $log["mail_bulk"] = $mail_bulk;

            // Get list user by condition
            $list_user = json_decode($mail_bulk->list_user, true);

            $log["list_user"] = $list_user;

            // Send mail

            
            if (!is_null($list_user))
            {
                
                // $mail_number_send = 0;
                // $time_start = microtime(true);
                foreach ($list_user as $user_id) 
                {
                    $status = $obj_mail_controller->sendMailBulk($user_id, $mail_bulk);
                    if ($status == SEND_MAIL_STATUS_SUCCESS)
                    {
                        $total_send_success_number += 1;
                    }
                    // $mail_number_send++;
                    // if($mail_number_send % 13 ==0)
                    // {
                    //     $time_end = microtime(true);
                    //     if($time_end - $time_start < 1)
                    //         sleep(1 - ($time_end - $time_start) );
                    //     $time_start = microtime(true);
                    // }
                }
            }

            // Add mail bulk done
            $arr_mail_bulk_done = [
                "mail_bulk_id" => $mail_bulk->id,
                "total_user" => count($list_user),
                "send_success_number" => $total_send_success_number,
            ];
            $status_error = count($list_user) - $total_send_success_number;

            if (($status_error / count($list_user)) > 0.1) {
              report(new Exception('Tỷ lệ gửi mail thành công quá thấp !(' . $status_error . '/' . count($list_user) . ')', true));
            }
            $obj_mail_bulk_done->insertMailBulkDone($arr_mail_bulk_done);

            $arr_mail_bulk = [
              "send_datetime" => \Carbon\Carbon::now()->toDateTimeString(),
              "status" => MAIL_BULK_STATUS_DONE,
            ];
            $obj_mail_bulk->updateMailBulk($mail_bulk->id, $arr_mail_bulk);

            // Log
            $log["arr_mail_bulk_done"] = $arr_mail_bulk_done;
            $log["arr_mail_bulk"] = $arr_mail_bulk;
        }

        mail_bulk_log(print_r($log, true));
    }

    public function cronMailSchedule()
    {
        $obj_user = new User();
        $obj_mail_controller = new MailController();
        $obj_mail_schedule = new MailSchedule();
        $obj_mail_schedule_done = new MailScheduleDone();

        // Get mail bulk
        $list_mail_schedule = $obj_mail_schedule->getMailScheduleSendDesignation();

        foreach ($list_mail_schedule as $mail_schedule) {
            // Get list user by condition
            $condition = json_decode($mail_schedule->condition, true);
            $list_user = $obj_user->searchUserByCondition($condition);
            foreach($list_user as $key=>$value)
            if($list_user[$key]->stop_mail == STOP_MAIL_ENABLE || strlen(trim($list_user[$key]->mail_pc))==0)
                unset($list_user[$key]);

            switch ($mail_schedule->schedule_type) {
                case MAIL_SCHEDULE_TYPE_RESERVE:
                    // 1. Send mail type set reserve
                    if ($mail_schedule->status == MAIL_SCHEDULE_STATUS_NOT_SEND) {
                        // Compare time
                        $now = \Carbon\Carbon::now()->timestamp;
                        if ($now >= strtotime($mail_schedule->reserve_datetime)) {
                            $total_send_success_number = 0;

                            // Update mail schedule
                            $arr_mail_schedule = [
                                "send_datetime" => \Carbon\Carbon::now()->toDateTimeString(),
                                "status" => MAIL_SCHEDULE_STATUS_SEND,
                            ];
                            $obj_mail_schedule->updateMailSchedule($mail_schedule->id, $arr_mail_schedule);

                            // Send mail
                            foreach ($list_user as $user) {
                                $status = $obj_mail_controller->sendMailSchedule($user->user_id, $mail_schedule);
                                if ($status == SEND_MAIL_STATUS_SUCCESS) {
                                    $total_send_success_number += 1;
                                }
                            }

                            // Add mail schedule done
                            $arr_mail_schedule_done = [
                                "mail_schedule_id" => $mail_schedule->id,
                                "total_user" => count($list_user),
                                "send_success_number" => $total_send_success_number,
                            ];
                            $obj_mail_schedule_done->insertMailScheduleDone($arr_mail_schedule_done);

                            // Update mail schedule
                            /*$arr_mail_schedule = [
                                "send_datetime" => \Carbon\Carbon::now()->toDateTimeString(),
                                "status" => MAIL_SCHEDULE_STATUS_SEND,
                            ];
                            $obj_mail_schedule->updateMailSchedule($mail_schedule->id, $arr_mail_schedule);*/
                        }
                    } else {
                        continue;
                    }
                    break;

                case MAIL_SCHEDULE_TYPE_WEEKLY:
                    // 2. Send mail weekly
                    // Check day
                    $dayOfTheWeek = \Carbon\Carbon::now()->dayOfWeek;

                    if ($dayOfTheWeek == $mail_schedule->day_of_week) {
                        // Check have send
                        if ($mail_schedule->status == MAIL_SCHEDULE_STATUS_SEND) {
                            continue;
                        }

                        $now = \Carbon\Carbon::now()->toDateTimeString();
                        $time_now = date_format(date_create($now), 'H:i:s');

                        // Check time
                        if (strtotime($time_now) >= strtotime($mail_schedule->week_time_send)) {
                            $total_send_success_number = 0;

                            // Update mail schedule
                            $arr_mail_schedule = [
                                "send_datetime" => \Carbon\Carbon::now()->toDateTimeString(),
                                "status" => MAIL_SCHEDULE_STATUS_SEND,
                            ];
                            $obj_mail_schedule->updateMailSchedule($mail_schedule->id, $arr_mail_schedule);

                            // Send mail
                            foreach ($list_user as $user) {
                                $status = $obj_mail_controller->sendMailSchedule($user->user_id, $mail_schedule);
                                if ($status == SEND_MAIL_STATUS_SUCCESS) {
                                    $total_send_success_number += 1;
                                }
                            }

                            // Add mail schedule done
                            $arr_mail_schedule_done = [
                                "mail_schedule_id" => $mail_schedule->id,
                                "total_user" => count($list_user),
                                "send_success_number" => $total_send_success_number,
                            ];
                            $obj_mail_schedule_done->insertMailScheduleDone($arr_mail_schedule_done);

                            // Update mail schedule
                            /*$arr_mail_schedule = [
                                "send_datetime" => \Carbon\Carbon::now()->toDateTimeString(),
                                "status" => MAIL_SCHEDULE_STATUS_SEND,
                            ];
                            $obj_mail_schedule->updateMailSchedule($mail_schedule->id, $arr_mail_schedule);*/

                        } else {
                            continue;
                        }

                    } else {
                        // Update status
                        if ($mail_schedule->status == MAIL_SCHEDULE_STATUS_SEND) {
                            // Update mail bulk
                            $arr_mail_schedule = [
                                "status" => MAIL_SCHEDULE_STATUS_NOT_SEND,
                            ];
                            $obj_mail_schedule->updateMailSchedule($mail_schedule->id, $arr_mail_schedule);
                        }
                        continue;
                    }

                    break;

                case MAIL_SCHEDULE_TYPE_DAILY:
                    // 3. Send mail daily
                    $now = \Carbon\Carbon::now()->toDateTimeString();

                    // Check have send
                    if ($mail_schedule->status == MAIL_SCHEDULE_STATUS_SEND) {
                        // Update status new day
                        $next_send = date('Y-m-d 00:00:00', strtotime($mail_schedule->updated_at . ' +1 day'));
                        // Check new day
                        if (strtotime($now) >= strtotime($next_send)) {
                            // Update mail bulk
                            $arr_mail_schedule = [
                                "status" => MAIL_SCHEDULE_STATUS_NOT_SEND,
                            ];
                            $obj_mail_schedule->updateMailSchedule($mail_schedule->id, $arr_mail_schedule);
                        }
                        continue;
                    }

                    $time_now = date_format(date_create($now), 'H:i:s');

                    // Check time
                    if (strtotime($time_now) >= strtotime($mail_schedule->daily_hour)) {
                        $total_send_success_number = 0;
                        
                        // Update mail schedule
                        $arr_mail_schedule = [
                            "send_datetime" => \Carbon\Carbon::now()->toDateTimeString(),
                            "status" => MAIL_SCHEDULE_STATUS_SEND,
                        ];
                        $obj_mail_schedule->updateMailSchedule($mail_schedule->id, $arr_mail_schedule);

                        // Send mail
                        foreach ($list_user as $user) {
                            $status = $obj_mail_controller->sendMailSchedule($user->user_id, $mail_schedule);
                            if ($status == SEND_MAIL_STATUS_SUCCESS) {
                                $total_send_success_number += 1;
                            }
                        }

                        // Add mail schedule done
                        $arr_mail_schedule_done = [
                            "mail_schedule_id" => $mail_schedule->id,
                            "total_user" => count($list_user),
                            "send_success_number" => $total_send_success_number,
                        ];
                        $obj_mail_schedule_done->insertMailScheduleDone($arr_mail_schedule_done);

                        // Update mail schedule
                        /*$arr_mail_schedule = [
                            "send_datetime" => \Carbon\Carbon::now()->toDateTimeString(),
                            "status" => MAIL_SCHEDULE_STATUS_SEND,
                        ];
                        $obj_mail_schedule->updateMailSchedule($mail_schedule->id, $arr_mail_schedule);*/

                    } else {
                        continue;
                    }

                    break;

                case MAIL_SCHEDULE_TYPE_MONTHLY:
                    // 4. Send mail monthly

                    break;

                default:
                    continue;
                    break;
            }
        }
    }

    public function cronMailGiftEvent()
    {
        $obj_user = new User();
        $obj_gift_repositories = new GiftRepositories();

        // Get list user
        $list_user = $obj_user->getUser();

        foreach ($list_user as $user) {
            $obj_gift_repositories->giftAddPointByType($user->user_id, GIFT_TYPE_EVENT);
        }
    }

    public function cronMailGiftBonus()
    {
        $obj_mail_controller = new MailController();
        $obj_trans_gift = new TransactionGift();

        // Get list gift event
        $list_trans_bonus = $obj_trans_gift->getTransBonusSend();

        foreach ($list_trans_bonus as $gift_bonus) {

            // Mail gift
            $mail_gift_bonus = [
                'mail_title' => $gift_bonus->gift_name,
                'mail_body' => $gift_bonus->note,
                'point' => $gift_bonus->point,
            ];
            $obj_mail_gift_bonus = (object) $mail_gift_bonus;

            // Send mail
            $obj_mail_controller->sendMailGiftBonus($gift_bonus->user_id, $obj_mail_gift_bonus);

            // Update trans gift bonus
            $arr_trans_gift = [
                'send_mail' => SEND_MAIL_YET,
            ];
            $obj_trans_gift->updateTransactionGift($gift_bonus->id, $arr_trans_gift);
        }
    }

    public function cronMailDeposit()
    {
        $obj_mail_controller = new MailController();
        $obj_trans_deposit = new TransactionDeposit();
        $obj_mail_schedule = new MailSchedule();

        $number_mail_deposit = $obj_mail_schedule->countMailScheduleTarget(MAIL_SCHEDULE_TARGET_DEPOSIT);

        // List trans not send
        $list_trans_deposit = $obj_trans_deposit->getSendMailDeposit($number_mail_deposit);

        foreach ($list_trans_deposit as $trans_deposit) {
            // Send mail
            $obj_mail_controller->sendMailDeposit($trans_deposit);
        }
    }

    public function cronMailPayment()
    {
        $obj_mail_controller = new MailController();
        $obj_trans_payment = new TransactionPayment();
        $obj_mail_schedule = new MailSchedule();

        $number_mail_payment = $obj_mail_schedule->countMailScheduleTarget(MAIL_SCHEDULE_TARGET_PAYMENT);

        // List trans not send
        $list_trans_payment = $obj_trans_payment->getSendMailPayment($number_mail_payment);

        foreach ($list_trans_payment as $trans_payment) {
            // Send mail
            $obj_mail_controller->sendMailPayment($trans_payment);
        }
    }

    public function cronMailSendPredictionResult()
    {
        $obj_mail_controller = new MailController();
        $obj_trans_payment = new TransactionPayment();
        $obj_pre = new Prediction();

        // List prediction result
        $list_pre_result = $obj_pre->getPredictionResultSendMail();

        foreach ($list_pre_result as $pre_result) {
            $pre_result->mail_title = $pre_result->name;
            $pre_result->mail_body = $pre_result->result;

            // List trans not send
            $list_trans_payment = $obj_trans_payment->getSendMailPredictionResult($pre_result->id);

            foreach ($list_trans_payment as $trans_payment) {
                // Send mail
                $obj_mail_controller->sendMailPredictionResult($trans_payment->user_id, $pre_result, $trans_payment->id);

                // Update transaction payment
                $arr_trans_payment = [
                    "send_mail_prediction_result" => SEND_MAIL_YET,
                ];
                $obj_trans_payment->updateTransactionPayment($trans_payment->id, $arr_trans_payment);
                unset($arr_trans_payment);
            }

            // Update prediction result
            $arr_pre = [
                "send_mail_done" => SEND_MAIL_YET,
            ];
            $obj_pre->updatePrediction($pre_result->id, $arr_pre);
            unset($arr_pre);
        }
    }

    public function cronMailSendPredictionOpen()
    {
        $obj_mail_controller = new MailController();
        $obj_pre = new Prediction();
        $obj_user = new User();

        // List prediction result
        $list_pre_open = $obj_pre->getPredictionOpenSendMail();

        foreach ($list_pre_open as $pre_open) {
            $pre_open->mail_title = $pre_open->name;
            $pre_open->mail_body = $pre_open->content;

            // List trans not send
            $list_user = $obj_user->getSendMailPredictionOpen($pre_open->member_level);

            foreach ($list_user as $user) {
                // Send mail
                $obj_mail_controller->sendMailPredictionOpen($user->id, $pre_open);
            }

            // Update prediction result
            $arr_pre = [
                "send_mail_open" => SEND_MAIL_YET,
            ];
            $obj_pre->updatePrediction($pre_open->id, $arr_pre);
            unset($arr_pre);
        }
    }

    public function cronMailUserRegister()
    {
        $obj_user = new User();
        $obj_mail_controller = new MailController();
        $obj_mail_schedule = new MailSchedule();

        $number_mail_register = $obj_mail_schedule->countMailScheduleTarget(MAIL_SCHEDULE_TARGET_REGISTER);

        // Get list user
        $list_user = $obj_user->getUserNotSendMail($number_mail_register);

        foreach ($list_user as $user) {
            // Send mail register
            $obj_mail_controller->sendMailRegister($user->user_id);
        }
    }

    public function cronMailUserInterim()
    {
        $obj_user = new User();
        $obj_mail_controller = new MailController();
        $obj_mail_schedule = new MailSchedule();

        $number_mail_interim = $obj_mail_schedule->countMailScheduleTarget(MAIL_SCHEDULE_TARGET_USER_INTERIM);

        // Get list user
        $list_user = $obj_user->getUserInterimSendMail($number_mail_interim);

        foreach ($list_user as $user) {
            // Send mail register
            $obj_mail_controller->sendMailUserInterim($user->user_id);
        }
    }

    public function cronMail()
    {
        $this->cronMailBulk();
        $this->cronMailSchedule();
        $this->cronMailUserRegister();
        $this->cronMailDeposit();
        $this->cronMailPayment();
        $this->cronMailUserInterim();
    }

    public function testCron()
    {
//    $this->cronMailBulk();
        //    $this->cronMailSchedule();
        //    $this->cronMailUserRegister();
        //    $this->cronMailDeposit();
        //    $this->cronMailPayment();
        //    $this->cronMailSendPredictionOpen();
        //    $this->cronMailSendPredictionResult();
        //    $this->cronMailGiftBonus();
        //    $this->cronMailGiftEvent();
        $this->cronMailUserInterim();
//    $now = \Carbon\Carbon::now()->toDateTimeString();
    }
}
