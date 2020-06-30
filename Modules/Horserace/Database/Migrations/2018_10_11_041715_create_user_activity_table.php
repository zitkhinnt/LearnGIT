<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserActivityTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('user_activity', function (Blueprint $table) {
      $table->increments('id');
      $table->integer('user_id');
      $table->integer('point')->default(0);
      $table->integer('payment_total_amount')->default(0);
      $table->integer('payment_total_number')->default(0);
      $table->integer('login_number')->default(0);
      $table->text('user_agent')->default(null);
      $table->string('ip', 64)->default(null);
      $table->timestamp('last_login_time')->nullable();
      $table->timestamp('last_access_time')->nullable();
      $table->timestamp('first_payment_time')->nullable();
      $table->timestamp('last_payment_time')->nullable();
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
    Schema::dropIfExists('user_activity');
  }
}
