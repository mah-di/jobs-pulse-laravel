<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'candidate_profile_id',
        'job_id',
        'status',
    ];

    protected $attributes = [
        'status' => 'PENDING',
    ];

    public function candidate()
    {
        return $this->belongsTo(CandidateProfile::class, 'candidate_profile_id');
    }

    public function job()
    {
        return $this->belongsTo(Job::class);
    }
}
