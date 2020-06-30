<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Modules\Horserace\Http\Controllers\Cron\CronMailController;

class MailCommand extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'mail:all';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Command description';

  /**
   * Create a new command instance.
   *
   * @return void
   */
  public function __construct()
  {
    parent::__construct();
  }

  /**
   * Execute the console command.
   *
   * @return mixed
   */
  public function handle()
  {
    $time = date('Y-m-d H:i:s a');
    $log['time'] = 'time test v2: ' . $time;

    $obj_mail_cron_controller = new CronMailController();
    $obj_mail_cron_controller->cronMail();

    khanh_log(print_r($log, true));
  }
}
