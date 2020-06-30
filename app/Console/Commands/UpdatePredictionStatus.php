<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Modules\Horserace\Entities\Prediction;

class UpdatePredictionStatus extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'prediction:update';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Prediction status update when finish recruit time ';

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
    echo "Update Prediction";

    $time = date('Y-m-d H:i:s a');
    $log['time'] = 'time test v2: ' . $time;

    $obj_prediction = new Prediction();
    $result = $obj_prediction->updatePredictionStatus();

    echo "\nUpdate Done, Result::::" . $result;

    khanh_log(print_r($log, true));
  }
}
