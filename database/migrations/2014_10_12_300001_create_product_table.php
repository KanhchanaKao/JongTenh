<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            
            $table->increments('id', 11);
            $table->string('name', 150)->default('');
            $table->string('image', 500)->nullable();

            $table->integer('category_id')->unsigned()->default(1);
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');

            $table->integer('supplier_id')->unsigned()->default(1);
            $table->foreign('supplier_id')->references('id')->on('supplier')->onDelete('cascade');

            $table->integer('review_rate_id')->unsigned()->nullable();
            $table->decimal('rate_score', 10, 2)->unsigned()->default(0);

            $table->decimal('unit_price', 10, 2)->default(5000);
            $table->integer('qty')->default(0);
            $table->decimal('discount', 10, 2)->default(0);
           
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
        Schema::dropIfExists('product');
    }
}
