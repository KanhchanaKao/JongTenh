<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerProductsRecomendationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_products_recomendation', function (Blueprint $table) {
            $table->increments('id',11);

            $table->integer('customer_id')->unsigned()->default(1);
            $table->foreign('customer_id')->references('id')->on('customer')->onDelete('cascade');

            $table->integer('product_id')->unsigned()->default(1);
            $table->foreign('product_id')->references('id')->on('product')->onDelete('cascade');

            $table->integer('n_of_orders')->default(0)->nullable();
            $table->integer('qty')->default(0)->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_products_recomendation');
    }
}
