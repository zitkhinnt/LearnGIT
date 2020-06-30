<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePredictionResultTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('prediction_result', function (Blueprint $table) {
      $table->increments('id');
      $table->integer('prediction_id');
      $table->integer('venue_id');
      $table->string('race_name');
      $table->integer('race_no');
      $table->string('type')->nullable();
      $table->double('hit_race')->default(0);
      $table->integer('amount')->default(0);
      $table->integer('point')->default(0);
      $table->timestamp('race_date')->nullable();
      $table->longText('content')->nullable();
      $table->timestamp('reserve_datetime')->nullable();
      $table->tinyInteger('send_mail')->default(0);
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
    Schema::dropIfExists('prediction_result');
  }
}
