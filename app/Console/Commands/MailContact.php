<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Modules\Horserace\Http\Controllers\Cron\CronMailContactController;

class MailContact extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'mail:contact';

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
    nghia_log('mail:contact11111');

    $time = date('Y-m-d H:i:s a');
    $log['time'] = 'Mail Contact: ' . $time;

    $obj_mail_cron_reg = new CronMailContactController();
    $obj_mail_cron_reg->cron();

    echo 'run mail contact';

    khanh_log(print_r($log, true));
  }
}
