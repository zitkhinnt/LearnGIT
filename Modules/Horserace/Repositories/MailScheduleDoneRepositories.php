<?php
/**
 * Date 2018-09-10
 */

namespace Modules\Horserace\Repositories;

use DB;
use Modules\Horserace\Entities\MailSchedule;
use Modules\Horserace\Entities\MailScheduleDone;

class MailScheduleDoneRepositories
{


  public function getMailScheduleDone()
  {
    $obj_mail_schedule_done = new MailScheduleDone();
    $obj_mail_schedule = new MailSchedule();

    // Mail schedule
    $mail_schedule = $obj_mail_schedule->getMailSchedule();
    $arr_mail_schedule = array();
    foreach ($mail_schedule as $item) {
      $arr_mail_schedule[$item->id] = (array)$item;
    }

    // Mail schedule done
    $data = array();
    $mail_schedule_done = $obj_mail_schedule_done->getMailScheduleDone();
    foreach ($mail_schedule_done as $item) {
      $data[$item->id] = (array)$item;

      // Send time
      if (isset($arr_mail_schedule[$item->mail_schedule_id])) {
        $data[$item->id]["info"] = $arr_mail_schedule[$item->mail_schedule_id];

        switch ($arr_mail_schedule[$item->mail_schedule_id]["schedule_type"]) {
          case MAIL_SCHEDULE_TYPE_WEEKLY:
            // Weekly
            $week_time_send = explode(":", $arr_mail_schedule[$item->mail_schedule_id]["week_time_send"]);
            $data_hour = $week_time_send[0];
            $data_minute = $week_time_send[1];
            $data[$item->id]["time_set"] = dayToStr($arr_mail_schedule[$item->mail_schedule_id]["day_of_week"]) .
              $data_hour . "時" . $data_minute . "分";
            break;

          case MAIL_SCHEDULE_TYPE_DAILY:
            // Daily
            $daily_hour = explode(":", $arr_mail_schedule[$item->mail_schedule_id]["daily_hour"]);
            $data_hour = $daily_hour[0];
            $data_minute = $daily_hour[1];
            $data[$item->id]["time_set"] = $data_hour . "時" . $data_minute . "分";
            break;

          case  MAIL_SCHEDULE_TYPE_RESERVE:
            // Reserve
            $data[$item->id]["time_set"] = $arr_mail_schedule[$item->mail_schedule_id]["reserve_datetime"];
            break;
        }
      } else {
        unset($data[$item->id]);
//        $data[$item->id]["info"] = null;
//        $data[$item->id]["time_set"] = null;
      }
    }
    return $data;
  }

}