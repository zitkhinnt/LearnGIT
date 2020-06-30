<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('user', function (Blueprint $table) {
      $table->increments('id');
      $table->string('login_id', 16)->unique();
      $table->string('user_key', 16)->unique();
      $table->string('password');
      $table->string('nickname', 24);
      $table->string('password_text');
      $table->tinyInteger('gender')->default(0);
      $table->integer('age')->default(null);
      $table->tinyInteger('member_level')->default(0);
      $table->string('mail_pc')->default(null);
      $table->string('mail_mobile')->default(null);
      $table->text('memo')->default(null);
      $table->timestamp('register_time')->nullable();
      $table->timestamp('interim_register_time')->nullable();
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
    Schema::dropIfExists('user');
  }
}
