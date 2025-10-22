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
        Schema::table('job_descriptions', function (Blueprint $table) {
            // Add department_id foreign key
            $table->foreignId('department_id')->nullable()->after('job_title')->constrained()->onDelete('set null');
            
            // Change department column to nullable (we'll use department_id now)
            $table->string('department')->nullable()->change();
            
            // Remove skills_required text field (will use many-to-many relationship)
            $table->dropColumn('skills_required');
            
            // Add indexes
            $table->index('department_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_descriptions', function (Blueprint $table) {
            $table->dropForeign(['department_id']);
            $table->dropColumn('department_id');
            $table->text('skills_required')->nullable();
        });
    }
};
