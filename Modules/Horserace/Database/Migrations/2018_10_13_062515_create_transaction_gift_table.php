<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionGiftTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('transaction_gift', function (Blueprint $table) {
      $table->increments('id');
      $table->integer('user_id');
      $table->string('login_id');
      $table->tinyInteger('type')->default(0);
      $table->integer('gift_id')->default(0);
      $table->integer('point')->default(0);
      $table->tinyInteger('status')->default(0);
      $table->text('note')->default(null);
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
    Schema::dropIfExists('transaction_gift');
  }
}
