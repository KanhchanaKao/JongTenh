<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerCategoriesFavoriteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_categories_favorite', function (Blueprint $table) {
            $table->increments('id',11);
            $table->integer('customer_id')->unsigned()->default(1);
            $table->foreign('customer_id')->references('id')->on('customer')->onDelete('cascade');

            $table->integer('category_id')->unsigned()->default(1);
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');

            $table->integer('cat_hits')->unsigned()->nullable();

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
        Schema::dropIfExists('customer_categories_favorite');
    }
}
