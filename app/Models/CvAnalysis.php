<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CvAnalysis extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'cv_filename',
        'cv_file_path',
        'extracted_text',
        'parsed_data',
        'ai_summary',
        'career_recommendations',
        'status',
        'user_notes',
    ];

    protected $casts = [
        'parsed_data' => 'array',
    ];

    /**
     * Get the user who owns this CV analysis
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all job matches for this CV
     */
    public function jobMatches()
    {
        return $this->hasMany(CvJobMatch::class);
    }
}
