<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorCommissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_commissions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('commission_id')->nullable();            
            $table->foreign('commission_id')->references('id')->on('commissions');
            $table->unsignedBigInteger('vendor_id')->nullable();            
            $table->foreign('vendor_id')->references('id')->on('vendors');
            $table->decimal('percent', 8, 2);
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
        Schema::dropIfExists('vendor_commissions');
    }
}
