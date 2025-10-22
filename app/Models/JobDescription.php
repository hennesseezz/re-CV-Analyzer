<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JobDescription extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_title',
        'department_id',
        'department',
        'description',
        'requirements',
        'responsibilities',
        'experience_level',
        'education_level',
        'status',
        'created_by',
    ];

    /**
     * Get the user who created this job description
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the department for this job
     */
    public function departmentRelation()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    /**
     * Get all skills required for this job
     */
    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'job_description_skills')
            ->withPivot('proficiency_level', 'is_required')
            ->withTimestamps();
    }

    /**
     * Get all CV matches for this job
     */
    public function cvMatches()
    {
        return $this->hasMany(CvJobMatch::class);
    }
}
