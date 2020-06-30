<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediaAccessTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('media_access', function (Blueprint $table) {
      $table->increments('id');
      $table->integer('media_id');
      $table->string('media_code');
      $table->integer('number_access')->default(0);
//      $table->text('user_agent')->default(null);
//      $table->string('ip', 64)->default(null);
      $table->timestamp('access_date')->nullable();
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
    Schema::dropIfExists('media_access');
  }
}
