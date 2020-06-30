<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePredictionTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('prediction', function (Blueprint $table) {
      $table->increments('id');
      $table->string('name');
      $table->integer('display_order')->default(0);
      $table->integer('member_level')->default(0);
      $table->tinyInteger('prediction_type')->default(0);
      $table->integer('default_point')->default(0);
      $table->tinyInteger('status')->default(0);
      $table->longText('content')->nullable();
      $table->longText('after_buy')->nullable();
      $table->longText('result')->nullable();
      $table->integer('number_access');
      $table->integer('number_buyer');
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
    Schema::dropIfExists('prediction');
  }
}
