<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_details', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('stock_id')->unsigned()->nullable();
            $table->foreign('stock_id')->references('id')->on('stock')->onDelete('cascade');

            $table->integer('product_id')->unsigned()->nullable();
            $table->foreign('product_id')->references('id')->on('product')->onDelete('cascade');

            $table->decimal('unit_price', 10, 2)->nullable();
            $table->integer('qty')->default(0);
            
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
        Schema::dropIfExists('stock_details');
    }
}
