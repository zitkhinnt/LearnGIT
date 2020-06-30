<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMailBulkTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('mail_bulk', function (Blueprint $table) {
      $table->increments('id');
      $table->timestamp('reserve_datetime')->nullable();
      $table->string('mail_from_address');
      $table->string('mail_from_name');
      $table->string('mail_title');
      $table->longText('mail_body');
      $table->text('memo')->nullable();
      $table->longText('condition')->nullable();
      $table->tinyInteger('status')->default(0);
      $table->integer('bulk_number')->nullable();
      $table->integer('bulk_send_number')->nullable();
      $table->timestamp('send_datetime')->nullable();
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
    Schema::dropIfExists('mail_bulk');
  }
}
