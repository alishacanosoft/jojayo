<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfficevoucherTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offficevoucher', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('voucherid');
            $table->unsignedBigInteger('category_id');
            $table->string('price');
            $table->longText('description');
            $table->longText('narrative');
            $table->foreign('category_id')->references('id')->on('officemgmcategory')->onDelete("CASCADE")->onUpdate('CASCADE');
            $table->date('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offficevoucher');
    }
}
