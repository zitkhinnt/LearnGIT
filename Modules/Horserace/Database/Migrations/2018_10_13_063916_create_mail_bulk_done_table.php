<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMailBulkDoneTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('mail_bulk_done', function (Blueprint $table) {
      $table->increments('id');
      $table->integer('mail_bulk_id');
      $table->integer('total_user');
      $table->integer('send_number');
      $table->integer('read_number');
      $table->tinyInteger('status')->default(0);
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
    Schema::dropIfExists('mail_bulk_done');
  }
}
