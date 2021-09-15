<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase', function (Blueprint $table) {
            $table->increments('id', 11);

            $table->integer('status_id')->unsigned()->nullable();
            $table->foreign('status_id')->references('id')->on('purchase_status')->onDelete('cascade');

            $table->integer('supplier_id')->unsigned()->nullable();
            $table->foreign('supplier_id')->references('id')->on('supplier')->onDelete('cascade');

            $table->integer('purchase_number')->default(0); 
            $table->decimal('total_price', 10, 2)->nullable();
            $table->dateTime('paid_at')->nullable();
            $table->integer('approved_by')->unsigned()->nullable();
            $table->dateTime('approved_at')->nullable();

            $table->integer('rejected_by')->unsigned()->nullable();
            $table->dateTime('rejected_at')->nullable();
            
            $table->string('attachment', 500)->nullable();
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
        Schema::dropIfExists('purchase');
    }
}
