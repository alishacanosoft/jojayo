<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSensitiveDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sensitive_data', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('web_title');
            $table->string('keywords');
            $table->string('meta_description');
            $table->string('company')->nullable();
            $table->string('registration')->nullable();
            $table->string('vat')->nullable();
            $table->string('pobox')->nullable();
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('instagram')->nullable();
            $table->string('youtube')->nullable();
            $table->string('landline')->nullable();
            $table->string('landline1')->nullable();
            $table->string('landline2')->nullable();
            $table->string('mobile')->nullable();
            $table->string('mobile1')->nullable();
            $table->string('email')->nullable();
            $table->string('email1')->nullable();
            $table->string('location')->nullable();
            $table->string('g_analytics')->nullable();
            $table->string('map')->nullable();
            $table->string('logo')->nullable();
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
        Schema::dropIfExists('sensitive_data');
    }
}
