<?php
/**
 * Date 2018-09-10
 */

namespace Modules\Horserace\Repositories;

use DB;
use Modules\Horserace\Entities\MailSchedule;
use Modules\Horserace\Entities\MailRegisterDetail;
use Modules\Horserace\Entities\MailTemplate;
use Modules\Horserace\Entities\User;

class MailScheduleRepositories
{
  public function storeMailSchedule($input)
  {
    $obj_mail_schedule = new MailSchedule();
    // Save data
    $arr_mail_schedule = [
      "mail_from_address" => trim($input["mail_from_address"]),
      "mail_from_name" => trim($input["mail_from_name"]),
      "mail_title" => trim($input["mail_title"]),
      "mail_body" =>isset($input["mail_body"])?$input["mail_body"]:'',
      "reserve_datetime" => isset($input["reserve_datetime"]) ? $input["reserve_datetime"] : null,
      "condition" => $input["condition"],
      "properties" => $input["properties"],
    ];

    if (trim($input["properties"]) == MAIL_SCHEDULE_PROPERTIES_ELAPSED) {
      // Elapsed time
      $day = $input["properties_day"];
      $hour = $input["properties_hour"] < 10 ? (0 . $input["properties_hour"]) : $input["properties_hour"];
      $minute = $input["properties_minute"] < 10 ? (0 . $input["properties_minute"]) : $input["properties_minute"];
      $arr_mail_schedule["elapsed_time"] = $day . ':' . $hour . ':' . $minute . ':00';
      $arr_mail_schedule["target"] = $input["target"];
    }

    if (trim($input["properties"]) == MAIL_SCHEDULE_PROPERTIES_DESIGNATION) {
      // designation
      // Check schedule type
      switch (trim($input["schedule_type"])) {
        case MAIL_SCHEDULE_TYPE_RESERVE:
          // Set day send
          $arr_mail_schedule["schedule_type"] = trim($input["schedule_type"]);
          $arr_mail_schedule["reserve_datetime"] = !is_null($input["reserve_datetime"]) ?
            $input["reserve_datetime"] : \Carbon\Carbon::now()->toDateTimeString();
          break;

        case MAIL_SCHEDULE_TYPE_WEEKLY:
          // Weekly
          $arr_mail_schedule["schedule_type"] = trim($input["schedule_type"]);
          $arr_mail_schedule["day_of_week"] = trim($input["day_of_week"]);
          $hour = $input["hour"] < 10 ? (0 . $input["hour"]) : $input["hour"];
          $minute = $input["minute"] < 10 ? (0 . $input["minute"]) : $input["minute"];
          $arr_mail_schedule["week_time_send"] = $hour . ':' . $minute . ':00';
          break;

        case MAIL_SCHEDULE_TYPE_DAILY:
          // daily
          $arr_mail_schedule["schedule_type"] = trim($input["schedule_type"]);
          $hour = $input["daily_hour"] < 10 ? (0 . $input["daily_hour"]) : $input["daily_hour"];
          $minute = $input["daily_minute"] < 10 ? (0 . $input["daily_minute"]) : $input["daily_minute"];
          $arr_mail_schedule["daily_hour"] = $hour . ':' . $minute . ':00';
          break;

        default :
          break;
      }
    }
    $result = [];

    if ($input["id"] != 0) {
      // Edit
      $obj_mail_schedule->updateMailSchedule(trim($input["id"]), $arr_mail_schedule);
      $result = [
        "status" => "success",
        "message" => __("horserace::be_msg.edit_mail_schedule_success")
      ];
    } else {
      // Create
      $obj_mail_schedule->insertMailSchedule($arr_mail_schedule);
      $result = [
        "status" => "success",
        "message" => __("horserace::be_msg.add_mail_schedule_success")
      ];
    }

    return $result;
  }

  public function getMailScheduleById($id_mail_schedule)
  {
    $obj_mail_schedule = new MailSchedule();
    $mail_bulk = $obj_mail_schedule->getMailScheduleById($id_mail_schedule);
    return $mail_bulk;
  }

  public function getMailSchedule()
  {
    $obj_mail_schedule = new MailSchedule();
    $list_mail_schedule = $obj_mail_schedule->getMailSchedule();
    foreach ($list_mail_schedule as $key => $item) {
      // Type
      $list_mail_schedule[$key]->type = mailScheduleTargetStr($item->target);

      // Time set
      if ($item->properties == MAIL_SCHEDULE_PROPERTIES_ELAPSED) {
        // elapsed time
        $elapsed_time = explode(":", $item->elapsed_time);
        $data_day = $elapsed_time[0];
        $data_hour = $elapsed_time[1];
        $data_minute = $elapsed_time[2];
        $list_mail_schedule[$key]->time_set = $data_day . '日目' .
          $data_hour . "時" . $data_minute . "分後";
        continue;
      }

      if ($item->properties == MAIL_SCHEDULE_PROPERTIES_DESIGNATION) {
        // Type
        $list_mail_schedule[$key]->type = mailScheduleTypeStr($item->schedule_type);

        // time set
        switch ($item->schedule_type) {
          case  MAIL_SCHEDULE_TYPE_RESERVE:
            // Reserve
            $list_mail_schedule[$key]->time_set = $item->reserve_datetime;
            break;

          case MAIL_SCHEDULE_TYPE_WEEKLY:
            // Weekly
            $week_time_send = explode(":", $item->week_time_send);
            $data_hour = $week_time_send[0];
            $data_minute = $week_time_send[1];
            $list_mail_schedule[$key]->time_set = dayToStr($item->day_of_week) .
              $data_hour . "時" . $data_minute . "分";
            break;

          case MAIL_SCHEDULE_TYPE_DAILY:
            // Daily
            $daily_hour = explode(":", $item->daily_hour);
            $data_hour = $daily_hour[0];
            $data_minute = $daily_hour[1];
            $list_mail_schedule[$key]->time_set = $data_hour . "時" . $data_minute . "分";
            break;
        }
      }
    }

    return $list_mail_schedule;
  }

  public function deleteMailSchedule($id_mail_schedule)
  {
    $obj_mail_schedule = new MailSchedule();
    $obj_mail_schedule->deleteMailSchedule($id_mail_schedule);
    $result = [
      "status" => "success",
      "message" => __("horserace::be_msg.deleted_mail_schedule_success"),
    ];

    return $result;
  }
  public function applyMailSchedule($id_mail, $data)
  {
    $obj_mail_schedule = new MailSchedule();
    // Update mail schedule
    $obj_mail_schedule->updateMailSchedule($id_mail, $data);
    $result = [
      "status" => "success",
      "message" => __("horserace::be_msg.edit_mail_schedule_success")
    ];

    return $result;
  }
}