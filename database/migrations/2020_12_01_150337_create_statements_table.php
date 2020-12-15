<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('vendor_id')->nullable();            
            $table->foreign('vendor_id')->references('id')->on('vendors');
            $table->unsignedBigInteger('order_id')->nullable();            
            $table->foreign('order_id')->references('id')->on('orders');
            $table->string('transaction_no');
            $table->enum('status', ['Paid', 'Unpaid'])->default('Unpaid');
            $table->timestamp('order_created');
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
        Schema::dropIfExists('statements');
    }
}
