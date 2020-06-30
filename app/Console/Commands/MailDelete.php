<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Modules\Horserace\Http\Controllers\Cron\CronMailRegisterController;
use Modules\Horserace\Http\Controllers\Cron\CronMailContactController;

class MailDelete extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'mail:delete';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Delete mail on server mail';

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
    $log['time'] = 'Mail delete: ' . $time;

    // $obj_mail_cron_reg = new CronMailRegisterController();
    // $obj_mail_cron_reg->cronDelete();
    // $obj_mail_cron_cont = new CronMailContactController();
    // $obj_mail_cron_cont->cronDelete();

    khanh_log(print_r($log, true));
  }
}
