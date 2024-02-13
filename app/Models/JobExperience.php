<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobExperience extends Model
{
    use HasFactory;

    protected $fillable = [
        'candidate_profile_id',
        'designation',
        'company',
        'jobDetails',
        'isCurrentJob',
        'joiningDate',
        'quittingDate',
    ];

    public function candidate()
    {
        return $this->belongsTo(CandidateProfile::class);
    }
}
