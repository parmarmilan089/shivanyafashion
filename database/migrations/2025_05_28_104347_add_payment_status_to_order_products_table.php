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
        Schema::table('order_products', function (Blueprint $table) {
            $table->decimal('expected_amount', 10, 2)->nullable();
            $table->decimal('received_amount', 10, 2)->nullable();
            $table->string('payment_status')->default('pending'); // 'pending', 'partial', 'paid', 'overpaid'
            $table->text('payment_note')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_products', function (Blueprint $table) {
            $table->dropColumn(['expected_amount','received_amount','payment_status','payment_note']);
            //
        });
    }
};
