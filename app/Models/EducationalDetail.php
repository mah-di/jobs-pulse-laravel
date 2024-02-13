<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EducationalDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'candidate_profile_id',
        'degreeType',
        'institution',
        'department',
        'cgpa',
        'certificate',
        'passingYear',
    ];

    public function candidate()
    {
        return $this->belongsTo(CandidateProfile::class);
    }
}
