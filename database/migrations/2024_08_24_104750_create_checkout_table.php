<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('checkout', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('pizza_id');
            $table->string('pizza_size');
            $table->float('pizza_price');
            $table->text('body')->nullable(); // Set 'body' column to be nullable
            $table->string('phone');
            $table->float('total');
            $table->string('delivery_choice');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checkout');
    }
};
