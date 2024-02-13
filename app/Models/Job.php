<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_category_id',
        'company_id',
        'title',
        'description',
        'skills',
        'salary',
        'status',
        'type',
        'deadline',
        'restrictionFeedback',
    ];

    public function jobCategory()
    {
        return $this->belongsTo(JobCategory::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function jobApplications()
    {
        return $this->hasMany(JobApplication::class);
    }

    public function savedJobs()
    {
        return $this->hasMany(SavedJob::class);
    }
}
