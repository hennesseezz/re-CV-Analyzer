<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public $withinTransaction = false; // ← ADD THIS LINE
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('job_description_skills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_description_id')->constrained()->onDelete('cascade');
            $table->foreignId('skill_id')->constrained()->onDelete('cascade');
            $table->enum('proficiency_level', ['beginner', 'intermediate', 'advanced', 'expert'])->default('intermediate');
            $table->boolean('is_required')->default(true); // Required or optional skill
            $table->timestamps();
            
            // Unique constraint
            $table->unique(['job_description_id', 'skill_id']);
            
            // Indexes
            $table->index('job_description_id');
            $table->index('skill_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_description_skills');
    }
};
