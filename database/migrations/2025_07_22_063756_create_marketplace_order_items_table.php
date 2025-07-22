<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marketplace_order_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('marketplace_order_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('variant_id')->nullable();
            $table->string('product_name');
            // $table->string('sku');
            $table->decimal('price', 10, 2);
            $table->integer('qty');
            $table->decimal('subtotal', 10, 2);
            $table->timestamps();

            $table->foreign('marketplace_order_id')->references('id')->on('marketplace_orders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('marketplace_order_items');
    }
};
