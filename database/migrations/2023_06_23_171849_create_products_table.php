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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('store_id')->references('id')->on('stores');
            $table->foreignId('category_id')->references('id')->on('categories');
            $table->foreignId('brand_id')->references('id')->on('brands');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->enum('unit', ['weight', 'piece', 'liquid']);
            $table->unsignedSmallInteger('stock_alert');
            $table->float('cost_price');
            $table->float('price');
            $table->unsignedInteger('quantity');
            $table->text('description');
            $table->text('info')->nullable();
            $table->text('ingredients')->nullable();
            $table->string('image')->default('products/default.jpg');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
