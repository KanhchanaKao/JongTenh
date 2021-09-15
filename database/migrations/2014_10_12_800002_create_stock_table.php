<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('admin_id')->unsigned()->index()->nullable();
            $table->foreign('admin_id')->references('id')->on('admin');

            $table->integer('status_id')->unsigned()->index()->nullable();
            $table->foreign('status_id')->references('id')->on('status')->onDelete('cascade');

            $table->string('code', 50)->nullable();

            $table->integer('type_id')->unsigned()->nullable();
            $table->integer('stocker_id')->unsigned()->index()->nullable(); //Relate to table Admin

            $table->integer('supplier_id')->unsigned()->nullable();
            $table->foreign('supplier_id')->references('id')->on('supplier')->onDelete('cascade');

            $table->dateTime('requested_at')->nullable();
            $table->dateTime('stocked_at')->nullable();

            $table->decimal('total_price', 10, 2)->default(0); 
            $table->decimal('sale_price', 10, 2)->default(0); 
            $table->decimal('stock_price', 10, 2)->default(0); 
            $table->mediumText('note')->nullable();
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
        Schema::dropIfExists('stock');
    }
}
