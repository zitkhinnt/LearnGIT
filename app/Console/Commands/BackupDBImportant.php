<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class BackupDBImportant extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'db:important';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Command description';

  protected $process;

  /**
   * Create a new command instance.
   *
   * @return void
   */
  public function __construct()
  {
    parent::__construct();

    $file_name = 'db_important_' . date('Y-m-d_H:i:s') . 'sql';

    $this->process = new Process(sprintf(
      'mysqldump -u %s -p\'%s\' %s users transaction_payment prediction > %s',
      env('DB_USERNAME'),
      env('DB_PASSWORD'),
      env('DB_DATABASE'),
      storage_path('backups/' . $file_name)
    ));

    // Remove file
    $this->process2 = new Process(sprintf(
      'find %s -mtime +3 -type f -delete',
      storage_path('backups')
    ));
  }

  /**
   * Execute the console command.
   *
   * @return mixed
   */
  public function handle()
  {
    $time = date('Y-m-d H:i:s a');
    $log['time'] = 'time backup table important : ' . $time;

    // Backup database
    try {
      $this->process->mustRun();

      $this->info('The backup table important has been proceed successfully.');

      // Log success
      $log['msg'] = 'The backup table important has been proceed successfully.';
      khanh_log(print_r($log, true));

    } catch (ProcessFailedException $exception) {
      $this->error('The backup table important process has been failed.');

      // Log error
      $log['msg'] = 'The backup table important process has been failed.';
      khanh_log(print_r($log, true));
    }

    // Delete file backup
    try {
      $this->process2->mustRun();

      $this->info('Delete file success');

      // Log success
      $log['msg'] = 'Delete file success';
      khanh_log(print_r($log, true));

    } catch (ProcessFailedException $exception) {
      $this->error('Delete file success has been failed.');

      // Log error
      $log['msg'] = 'TDelete file success has been failed.';
      khanh_log(print_r($log, true));
    }
  }
}
