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
        Schema::table('inventories', function (Blueprint $table) {
            // $table->unsignedBigInteger('subcategory_id')->nullable()->after('category_id');
            // $table->unsignedBigInteger('subsubcategory_id')->nullable()->after('subcategory_id');

            // // Add foreign keys
            // $table->foreign('subcategory_id')->references('id')->on('categories')->onDelete('set null');
            // $table->foreign('subsubcategory_id')->references('id')->on('categories')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inventories', function (Blueprint $table) {
            // $table->dropForeign(['subcategory_id']);
            // $table->dropForeign(['subsubcategory_id']);
            // $table->dropColumn(['subcategory_id', 'subsubcategory_id']);
        });
    }
};
