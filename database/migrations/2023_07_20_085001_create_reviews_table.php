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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->references('id')->on('orders');
            $table->foreignId('store_id')->references('id')->on('stores');
            $table->foreignId('client_id')->references('id')->on('clients');
            $table->unsignedTinyInteger('hospitality');
            $table->unsignedTinyInteger('commitment');
            $table->unsignedTinyInteger('honesty');
            $table->unsignedFloat('total');
            $table->text('feedback')->nullable();
            $table->boolean('anonymous')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
