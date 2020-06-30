<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMailTemplateTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('mail_template', function (Blueprint $table) {
      $table->increments('id');
      $table->string('name');
      $table->tinyInteger('type')->default(0);
      $table->string('mail_from_address');
      $table->string('mail_from_name');
      $table->string('mail_title');
      $table->longText('mail_body');
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
    Schema::dropIfExists('mail_template');
  }
}
