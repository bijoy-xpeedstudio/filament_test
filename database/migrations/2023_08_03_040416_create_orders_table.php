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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->string('order_number')->unique();
            $table->decimal('total_amount', 10, 2);
            $table->dateTime('order_date');
            $table->string('status')->default('pending');
            $table->string('payment_status')->default('pending');
            $table->string('payment_method')->nullable();
            $table->text('shipping_address')->nullable();
            $table->string('shipping_method')->nullable();
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->decimal('tax_amount', 10, 2)->default(0);
            // Add more fields as needed for your specific use case

            $table->timestamps();

            // Add foreign key constraint to link orders to customers
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
