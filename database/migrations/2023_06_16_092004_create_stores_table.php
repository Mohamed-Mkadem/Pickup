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
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_id')->references('id')->on('sellers');
            $table->foreignId('sector_id')->references('id')->on('sectors');
            $table->float('balance')->default(0);
            $table->date('expiry_date')->nullable();
            $table->integer('followers')->default(0);
            $table->float('rate')->default(0);
            $table->string('address');
            $table->foreignId('state_id')->references('id')->on('states');
            $table->foreignId('city_id')->references('id')->on('cities');
            $table->enum('status', ['published', 'unpublished', 'maintenance', 'banned'])->default('unpublished');
            $table->string('name');
            $table->string('username')->unique();
            $table->string('phone')->unique();
            $table->text('bio');
            $table->string('photo');
            $table->string('cover_photo')->default('stores/covers/default_cover.jpg');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stores');
    }
};
