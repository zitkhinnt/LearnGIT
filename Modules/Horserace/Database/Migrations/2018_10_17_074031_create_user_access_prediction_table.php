<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserAccessPredictionTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('user_access_prediction', function (Blueprint $table) {
      $table->increments('id');
      $table->integer('user_id');
      $table->integer('prediction_id');
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
    Schema::dropIfExists('user_access_prediction');
  }
}
