<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerProductsFavoriteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_products_favorite', function (Blueprint $table) {
            $table->increments('id',11);

            $table->integer('customer_id')->unsigned()->default(1);
            $table->foreign('customer_id')->references('id')->on('customer')->onDelete('cascade');

            $table->integer('product_id')->unsigned()->default(1);
            $table->foreign('product_id')->references('id')->on('product')->onDelete('cascade');

            $table->integer('category_id')->unsigned()->default(1);
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');

            $table->integer('cus_hits')->default(0)->nullable();

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
        Schema::dropIfExists('customer_products_favorite');
    }
}
