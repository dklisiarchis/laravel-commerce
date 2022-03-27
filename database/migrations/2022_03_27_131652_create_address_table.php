<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_address', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('country_id');
            $table->string('street');
            $table->string('addition');
            $table->string('postcode');
            $table->string('telephone');
            $table->boolean('default_shipping')->default(false);
            $table->boolean('default_billing')->default(false);

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_address');
    }
}
