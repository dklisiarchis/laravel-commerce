<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCheckoutCartItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checkout_cart_item', function (Blueprint $table) {
            $table->id();

            $table->foreignId('cart_id')
                ->constrained('checkout_cart')
                ->onDelete('cascade');

            $table->foreignId('product_id')
                ->constrained('catalog_product_entity')
                ->onDelete('cascade');

            $table->float('qty')->default(1);
            $table->float('row_total');
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
        Schema::dropIfExists('checkout_cart_item');
    }
}
