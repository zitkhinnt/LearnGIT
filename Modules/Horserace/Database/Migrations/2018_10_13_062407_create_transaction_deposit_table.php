<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionDepositTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('transaction_deposit', function (Blueprint $table) {
      $table->increments('id');
      $table->integer('user_id');
      $table->string('login_id');
      $table->tinyInteger('method')->default(0);
      $table->integer('point')->default(0);
      $table->integer('amount')->default(0);
      $table->tinyInteger('status')->default(0);
      $table->text('note')->default(null);
      $table->text('result')->default(null);
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
    Schema::dropIfExists('transaction_deposit');
  }
}
