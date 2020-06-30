<?php
/**
 * Date 2018-09-10
 */

namespace Modules\Horserace\Repositories;

use DB;
use Modules\Horserace\Entities\MailBulkDone;
use Modules\Horserace\Entities\MailScheduleDone;

class MailBulkDoneRepositories
{
  public function summaryMailBulkDaily($year, $month)
  {
    $obj_user_mail_bulk = new MailBulkDone();
    $data = $obj_user_mail_bulk->getSummaryMailBulkDaily($year, $month);
    return $data;
  }

  public function summaryMailBulkWeekly($start_week, $end_week)
  {
    $obj_user_mail_bulk = new MailBulkDone();
    $data = $obj_user_mail_bulk->getSummaryMailBulkWeekly($start_week, $end_week);
    return $data;
  }

}