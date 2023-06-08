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
        Schema::create('sellers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->references('id')->on('users');
            $table->string('bank');
            $table->string('account_name');
            $table->string('rib');
            $table->float('balance')->default(0);
            $table->float('suspended_balance')->default(0);
            $table->string('phone');
            $table->string('nid');
            $table->enum('verification',['Verified', 'Unverified'])->default('Unverified');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sellers');
    }
};
