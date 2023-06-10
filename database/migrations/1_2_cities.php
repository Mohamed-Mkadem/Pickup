<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('state_id')->constrained('states');
         
        });
        $filePath = base_path('public/data.json');
        $states = json_decode(file_get_contents($filePath), true);
        foreach ($states as $state) {
            $cities = explode(' - ', $state['Délégations']);
    
            $stateId = DB::table('states')->where('name', $state['Gouvernorat'])->value('id');
    
            foreach ($cities as $city) {
                DB::table('cities')->insert([
                    'name' => $city,
                    'state_id' => $stateId,
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cities');
    }
};
