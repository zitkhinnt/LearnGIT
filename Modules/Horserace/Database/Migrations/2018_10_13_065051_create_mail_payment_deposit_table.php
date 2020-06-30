<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMailPaymentDepositTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('mail_payment_deposit', function (Blueprint $table) {
      $table->increments('id');
      $table->integer('user_id');
      $table->integer('transaction_deposit_id');
      $table->string('mail_from_address');
      $table->string('mail_from_name');
      $table->string('mail_to_address');
      $table->string('mail_to_name');
      $table->string('mail_title');
      $table->longText('mail_body');
      $table->tinyInteger('status')->default(0);
      $table->timestamp('read_at')->nullable();
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
    Schema::dropIfExists('mail_payment_deposit');
  }
}
