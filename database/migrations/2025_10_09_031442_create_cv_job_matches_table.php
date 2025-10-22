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
        Schema::create('cv_job_matches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cv_analysis_id')->constrained()->onDelete('cascade');
            $table->foreignId('job_description_id')->constrained()->onDelete('cascade');
            $table->decimal('match_score', 5, 2); // e.g., 85.50
            $table->json('matching_skills')->nullable(); // Skills that matched
            $table->json('missing_skills')->nullable(); // Skills that are missing
            $table->text('match_analysis')->nullable(); // AI analysis of the match
            $table->text('recommendations')->nullable(); // Recommendations for improvement
            $table->timestamps();
            
            // Indexes
            $table->index('cv_analysis_id');
            $table->index('job_description_id');
            $table->index('match_score');
            
            // Unique constraint to prevent duplicate matches
            $table->unique(['cv_analysis_id', 'job_description_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cv_job_matches');
    }
};
