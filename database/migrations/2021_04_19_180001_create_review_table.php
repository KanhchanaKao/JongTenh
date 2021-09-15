<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviewTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('review', function (Blueprint $table) {
            
            $table->increments('id');

            $table->integer('product_id')->unsigned()->default(1);
            $table->foreign('product_id')->references('id')->on('product')->onDelete('cascade');

            $table->integer('order_detail_id')->unsigned()->nullable();

            $table->integer('rate_id')->unsigned()->default(1);
            $table->foreign('rate_id')->references('id')->on('rate')->onDelete('cascade');

            $table->integer('customer_id')->unsigned()->default(1);
            $table->foreign('customer_id')->references('id')->on('customer')->onDelete('cascade');

            $table->string('comment', 500)->default('');
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
        Schema::dropIfExists('review');
    }
}
