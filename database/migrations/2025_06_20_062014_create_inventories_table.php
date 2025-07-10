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
            $table->text('tags')->nullable();  // comma separated or JSON

            // Product Descriptions
            $table->text('short_description')->nullable();
            $table->longText('full_description')->nullable();
            $table->text('highlights')->nullable();  // comma separated or JSON

            $table->string('fabric')->nullable();
            $table->string('fit')->nullable();
            $table->string('pattern')->nullable();
            $table->string('neck_style')->nullable();
            $table->string('sleeve_type')->nullable();
            $table->string('top_length')->nullable();
            $table->string('shipping_class')->nullable();
            $table->boolean('returnable')->default(true);
            $table->boolean('cod_available')->default(true);

            // Media
            $table->string('main_image')->nullable();
            $table->json('gallery_images')->nullable();
            $table->string('video_url')->nullable();

            // SEO
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
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

            $table->timestamps();

            // Foreign Keys
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
            $table->foreign('subcategory_id')->references('id')->on('categories')->onDelete('set null');
            $table->foreign('subsubcategory_id')->references('id')->on('categories')->onDelete('set null');
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
