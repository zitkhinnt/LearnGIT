<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMailScheduleTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('mail_schedule', function (Blueprint $table) {
      $table->increments('id');
      $table->tinyInteger('schedule_type')->default(0);
      $table->timestamp('send_datetime')->nullable();
      $table->tinyInteger('day_of_week')->default(0);
      $table->string('week_time_send')->default(null);
      $table->string('mail_from_address');
      $table->string('mail_from_name');
      $table->string('mail_title');
      $table->longText('mail_body');
      $table->text('memo')->nullable();
      $table->longText('condition')->nullable();
      $table->tinyInteger('status')->default(0);
      $table->tinyInteger('deleted_flg')->default(0);
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('mail_schedule');
  }
}
