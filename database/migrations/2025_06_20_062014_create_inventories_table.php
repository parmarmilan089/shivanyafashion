<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();

            // Basic Details
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('sku')->unique();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->text('tags')->nullable(); // comma separated or JSON

            // Product Descriptions
            $table->text('short_description')->nullable();
            $table->longText('full_description')->nullable();
            $table->text('highlights')->nullable(); // comma separated or JSON

            // Pricing
            $table->decimal('price', 10, 2);
            $table->decimal('sale_price', 10, 2)->nullable();
            $table->decimal('tax_percent', 5, 2)->nullable();
            $table->date('offer_start_date')->nullable();
            $table->date('offer_end_date')->nullable();

            // Inventory
            $table->integer('stock_qty')->default(0);
            $table->enum('stock_status', ['in_stock', 'out_of_stock', 'pre_order'])->default('in_stock');
            $table->integer('low_stock_alert')->nullable();
            $table->string('barcode')->nullable();

            // Variants
            $table->json('color_ids')->nullable(); // store as array of IDs
            $table->json('size_ids')->nullable();
            $table->string('fabric')->nullable();
            $table->string('fit')->nullable();
            $table->string('pattern')->nullable();
            $table->string('neck_style')->nullable();
            $table->string('sleeve_type')->nullable();
            $table->string('top_length')->nullable();

            // Shipping
            $table->decimal('weight', 8, 2)->nullable();
            $table->decimal('length', 8, 2)->nullable();
            $table->decimal('width', 8, 2)->nullable();
            $table->decimal('height', 8, 2)->nullable();
            $table->string('shipping_class')->nullable();
            $table->boolean('returnable')->default(true);
            $table->boolean('cod_available')->default(true);

            // Media
            $table->string('main_image')->nullable();
            $table->json('gallery_images')->nullable();
            $table->string('video_url')->nullable();

            // SEO
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();

            // Misc
            $table->string('country_of_origin')->nullable();
            $table->string('manufacturer')->nullable();
            $table->string('hsn_code')->nullable();
            $table->string('warranty')->nullable();
            $table->text('care_instructions')->nullable();

            // Status
            $table->enum('status', ['active', 'inactive', 'draft'])->default('active');
            $table->enum('visibility', ['public', 'admin', 'hidden'])->default('public');
            $table->boolean('is_featured')->default(false);
            $table->string('platform')->nullable(); // optional if static

            $table->timestamps();

            // Foreign Keys
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventories');
    }
};
