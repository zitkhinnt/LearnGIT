<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('admin', function (Blueprint $table) {
      $table->increments('id');
      $table->string('name');
      $table->string('email')->default(null);
      $table->string('login_id')->unique();
      $table->string('password');
      $table->string('password_text');
      $table->string('role_code')->default(null);
      $table->string('remember_token')->default(null);
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
    Schema::dropIfExists('admin');
  }
}
