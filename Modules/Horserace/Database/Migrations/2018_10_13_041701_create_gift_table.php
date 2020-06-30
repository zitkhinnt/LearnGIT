<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGiftTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('gift', function (Blueprint $table) {
      $table->increments('id');
      $table->string('name');
      $table->integer('point')->default(0);
      $table->tinyInteger('type')->default(0);
      $table->timestamp('gift_send_datetime')->nullable();
      $table->longText('content')->default(null);
      $table->timestamp('start_time')->nullable();
      $table->timestamp('end_time')->nullable();
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
    Schema::dropIfExists('gift');
  }
}
