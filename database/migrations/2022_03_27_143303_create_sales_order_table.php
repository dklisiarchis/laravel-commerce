<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_order', function (Blueprint $table) {
            $table->id();
            $table->string('order_id')->unique();
            $table->string('customer_email');
            $table->foreignId('cart_id')->constrained('checkout_cart');
            $table->foreignId('shipping_address_id')->constrained('user_address');
            $table->foreignId('billing_address_id')->constrained('user_address');
            $table->foreignId('customer_id')->nullable()->constrained('users');
            $table->boolean('customer_notified')->default(false);
            $table->string('discount_code')->nullable();
            $table->float('discount')->nullable();
            $table->float('grand_total');
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
        Schema::dropIfExists('sales_order');
    }
}
