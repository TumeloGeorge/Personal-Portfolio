<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('skills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('skill_category_id')
                  ->constrained('skill_categories')
                  ->onDelete('cascade');
            $table->string('name');
            $table->string('level')->default('primary'); // Changed from enum to string
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
        
        // Add a check constraint if you want to enforce specific values
        DB::statement("ALTER TABLE skills ADD CONSTRAINT check_valid_level 
                      CHECK (level IN ('primary', 'secondary'))");
    }

    public function down(): void
    {
        Schema::dropIfExists('skills');
    }
};