<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CvJobMatch extends Model
{
    use HasFactory;

    protected $fillable = [
        'cv_analysis_id',
        'job_description_id',
        'match_score',
        'matching_skills',
        'missing_skills',
        'match_analysis',
        'recommendations',
    ];

    protected $casts = [
        'matching_skills' => 'array',
        'missing_skills' => 'array',
        'match_score' => 'decimal:2',
    ];

    /**
     * Get the CV analysis
     */
    public function cvAnalysis()
    {
        return $this->belongsTo(CvAnalysis::class);
    }

    /**
     * Get the job description
     */
    public function jobDescription()
    {
        return $this->belongsTo(JobDescription::class);
    }
}
