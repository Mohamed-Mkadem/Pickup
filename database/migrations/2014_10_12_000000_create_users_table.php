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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->enum('type',['Admin', 'Seller', 'Client']);
            $table->string('address');
            $table->date('d_o_b');
            $table->enum('status',['Active','Banned'])->default('Active');
            $table->enum('gender',['Male','Female']);
            $table->string('phone');
            $table->string('photo')->default('dist/Assets/profiles_photos/default.jpeg');           
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
