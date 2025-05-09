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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');                      // Product name
            $table->decimal('price', 10, 2);             // Base price or MRP
            $table->string('seller_name');               // Seller name
            $table->text('image')->nullable();            // Seller name
            $table->string('platform_sku')->nullable();  // Optional Amazon/Meesho SKU
            $table->enum('selling_platform', ['Amazon', 'Meesho'])->default('Meesho');
            $table->enum('status', ['Active', 'Deactive'])->default('Active');
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
        Schema::dropIfExists('products');
    }
};
