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
        Schema::create('saved_calculations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('actual_calculation');
            $table->json('inputs');
            
            //Metadata fields
            $table->string('category')->nullable(); // A simple category or tag for the calculation
            $table->text('description')->nullable(); // Additional notes or description about the calculation

            $table->timestamps();
        });    
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saved_calculations');
    }
};
