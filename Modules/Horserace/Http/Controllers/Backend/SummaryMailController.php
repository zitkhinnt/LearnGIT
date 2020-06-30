<?php

namespace Modules\Horserace\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Horserace\Repositories\MailBulkDoneRepositories;
use Modules\Horserace\Repositories\MailScheduleDoneRepositories;
use Modules\Horserace\Repositories\EntranceRepositories;
use Modules\Horserace\Repositories\MediaRepositories;
use Modules\Horserace\Repositories\PredictionTypeRepositories;
use Modules\Horserace\Repositories\UserStageRepositories;

class SummaryMailController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth:admin');
    $this->middleware('admin');
  }

  public function summaryMailBulk(Request $request,
                                  MailBulkDoneRepositories $mailBulkDoneRepositories)
  {
    return view('horserace::backend.summary_mail.summary_mail_bulk');
  }

  public function ajaxSummaryMailBulk(Request $request,
                                      MailBulkDoneRepositories $mailBulkDoneRepositories)
  {
    $data = $request->all();
    $timestamp = strtotime($data['start_month']);

    $month = date('m', $timestamp);
    $year = date('Y', $timestamp);
    $day = date('d', $timestamp);

    // Daily in month
    $day_in_month = listDayInMonth($year, $month);
    $data['datetime'] = $mailBulkDoneRepositories->summaryMailBulkDaily($year, $month);

    $datetime = array();
    foreach ($data["datetime"] as $item) {
      $datetime[$item->date] = (array)$item;
    }

    // Set data
    foreach ($day_in_month as $item) {
      if (!isset($datetime[$item])) {
        $datetime[$item] = [
          "date" => $item,
          "total_user" => '0',
          "send_success_number" => '0',
          "read_number" => '0',
          "rate_read_number" => number_format(0, 2, '.', ''),
          "daemon" => '0',
          "rate_daemon" => number_format(0, 2, '.', ''),
        ];
      } else {
        $datetime[$item]["daemon"] = $datetime[$item]["total_user"] - $datetime[$item]["send_success_number"];
        $datetime[$item]["rate_read_number"] = $datetime[$item]["total_user"] == 0 ?
          number_format(0, 2, '.', '') :
          number_format(($datetime[$item]["read_number"] / $datetime[$item]["total_user"]) * 100, 2, '.', '');
        $datetime[$item]["rate_daemon"] = $datetime[$item]["total_user"] == 0 ?
          number_format(0, 2, '.', '') :
          number_format(($datetime[$item]["daemon"] / $datetime[$item]["total_user"]) * 100, 2, '.', '');
      }
    }
    asort($datetime);

    // Weekly
    $week_in_month = weeksInMonth($year, $month);
    $data['weekly'] = $mailBulkDoneRepositories->summaryMailBulkWeekly($week_in_month['start_week'], $week_in_month['end_week']);
    $weekly = array();
    $weekly["summary"] = [
      "total_user" => 0,
      "send_success_number" => 0,
      "read_number" => 0,
      "daemon" => 0,
    ];

    foreach ($data["weekly"] as $item) {
      $weekly[$item->week_of_year] = (array)$item;
    }
    // Set data weekly
    foreach ($week_in_month["list_week"] as $key => $item) {
      if (isset($weekly[$key])) {
        $weekly[$key]["from"] = $item["from"];
        $weekly[$key]["to"] = $item["to"];
        $weekly[$key]["rate_read_number"] = number_format(($weekly[$key]["read_number"] / $weekly[$key]["total_user"]) * 100, 2, '.', '');
        $weekly[$key]["daemon"] = $weekly[$key]["total_user"] - $weekly[$key]["send_success_number"];
        $weekly[$key]["rate_daemon"] = number_format(($weekly[$key]["daemon"] / $weekly[$key]["total_user"]) * 100, 2, '.', '');
      } else {
        $weekly[$key]["total_user"] = 0;
        $weekly[$key]["send_success_number"] = 0;
        $weekly[$key]["read_number"] = 0;
        $weekly[$key]["rate_read_number"] = number_format(0, 2, '.', '');
        $weekly[$key]["daemon"] = 0;
        $weekly[$key]["rate_daemon"] = number_format(0, 2, '.', '');
        $weekly[$key]["from"] = $item["from"];
        $weekly[$key]["to"] = $item["to"];
      }
      // Summary
      $weekly["summary"]["total_user"] += $weekly[$key]["total_user"];
      $weekly["summary"]["send_success_number"] += $weekly[$key]["send_success_number"];
      $weekly["summary"]["read_number"] += $weekly[$key]["read_number"];
      $weekly["summary"]["rate_read_number"] = ($weekly[$key]["total_user"] == 0) ?
        number_format(0, 2, '.', ''):
        number_format(($weekly["summary"]["read_number"] / $weekly["summary"]["total_user"]) * 100, 2, '.', '');
      $weekly["summary"]["daemon"] += $weekly[$key]["daemon"];
      $weekly["summary"]["rate_daemon"] = ($weekly[$key]["total_user"] == 0) ?
        number_format(0, 2, '.', '') :
        number_format(($weekly["summary"]["daemon"] / $weekly["summary"]["total_user"]) * 100, 2, '.', '');
    }

    asort($weekly);

    // Set result
    $result['date'] = $day_in_month;
    $result['datetime'] = $datetime;
    $result['weekly'] = $weekly;
    $result['month'] = $month;
    $result['year'] = $year;
    $result['day'] = $day;

    return json_encode($result);
  }

  public function summaryMailSchedule(
    Request $request,
    MailScheduleDoneRepositories $mailScheduleDoneRepositories,
    MediaRepositories $mediaRepositories,
    UserStageRepositories $userStageRepositories,
    PredictionTypeRepositories $predictionTypeRepositories,
    EntranceRepositories $entranceRepositories
  ) {
    $data['mail_schedule_done'] = $mailScheduleDoneRepositories->getMailScheduleDone();
    $data["user_stage"] = $userStageRepositories->getListUserStage();
    $data["media"] = $mediaRepositories->getListMedia();
    $data['prediction_type'] = $predictionTypeRepositories->getPredictionType();
    $data["entrance"] = $entranceRepositories->getListEntrance();
    foreach ($data['mail_schedule_done'] as $k => $v) {
      $data['mail_schedule_done'][$k]['daemon_number'] = (int) $data['mail_schedule_done'][$k]['total_user'] - (int) $data['mail_schedule_done'][$k]['send_success_number'];
      if ($data['mail_schedule_done'][$k]['total_user'] != 0) {
        $data['mail_schedule_done'][$k]['daemon_rate'] = number_format(((float) ($data['mail_schedule_done'][$k]['daemon_number'] / $data['mail_schedule_done'][$k]['total_user']) * 100), 2, '.', '');
      } else $data['mail_schedule_done'][$k]['daemon_rate'] = 0;
    }
    return view('horserace::backend.summary_mail.summary_mail_schedule', compact('data'));
  }
}
