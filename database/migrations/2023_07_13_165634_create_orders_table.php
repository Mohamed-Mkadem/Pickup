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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->references('id')->on('stores');
            $table->foreignId('client_id')->references('id')->on('clients');
            $table->double('amount');
            $table->integer('no_items');
            $table->enum('status', ['pending', 'accepted', 'rejected', 'cancelled', 'picked', 'ready'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
