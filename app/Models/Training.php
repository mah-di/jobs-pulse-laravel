<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    use HasFactory;

    protected $fillable = [
        'candidate_profile_id',
        'title',
        'institution',
        'certificate',
        'completionYear',
    ];

    public function candidate()
    {
        return $this->belongsTo(CandidateProfile::class);
    }
}
