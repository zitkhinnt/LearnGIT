<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserDailyLoginHistoryTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('user_daily_login_history', function (Blueprint $table) {
      $table->increments('id');
      $table->integer('login_id');
      $table->text('user_agent')->default(null);
      $table->string('ip', 64)->default(null);
      $table->timestamp('login_date')->nullable();
      $table->integer('login_number')->default(0);
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
    Schema::dropIfExists('user_daily_login_history');
  }
}
