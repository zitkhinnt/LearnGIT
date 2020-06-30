<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserDailyAccessHistoryTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('user_daily_access_history', function (Blueprint $table) {
      $table->increments('id');
      $table->integer('login_id');
      $table->text('user_agent')->default(null);
      $table->string('ip', 64)->default(null);
      $table->integer('number_access')->default(0);
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
    Schema::dropIfExists('user_daily_access_history');
  }
}
