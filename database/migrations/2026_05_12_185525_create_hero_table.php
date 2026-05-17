<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hero', function (Blueprint $table) {
            $table->id();
            $table->string('headline');
            $table->string('subheadline');
            $table->text('bio');
            $table->unsignedInteger('projects_count')->default(0);
            $table->unsignedInteger('years_experience')->default(0);
            $table->unsignedInteger('clients_count')->default(0);
            $table->string('cta_primary_label')->default('View Projects');
            $table->string('cta_secondary_label')->default('Download CV');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hero');
    }
};