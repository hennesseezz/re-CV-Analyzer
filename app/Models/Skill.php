<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Skill extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get all job descriptions that require this skill
     */
    public function jobDescriptions()
    {
        return $this->belongsToMany(JobDescription::class, 'job_description_skills')
            ->withPivot('proficiency_level', 'is_required')
            ->withTimestamps();
    }
}
