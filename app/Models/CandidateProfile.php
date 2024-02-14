<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidateProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'profileImg',
        'firstName',
        'lastName',
        'fatherName',
        'motherName',
        'dob',
        'address',
        'contact',
        'emergencyContact',
        'personalWebsite',
        'whatsapp',
        'linkedin',
        'github',
        'behance',
        'dribble',
        'twitter',
        'slack',
        'nid',
        'passport',
        'bloodGroup',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function educationalDetails()
    {
        return $this->hasMany(EducationalDetail::class);
    }

    public function trainings()
    {
        return $this->hasMany(Training::class);
    }

    public function jobExperiences()
    {
        return $this->hasMany(JobExperience::class);
    }

    public function jobApplications()
    {
        return $this->hasMany(JobApplication::class);
    }

    protected static function boot()
    {
        static::saving(function ($model) {
            $model->profileImg = $model->profileImg ?? env('DEFAULT_PROFILE_IMG');
        });

        parent::boot();
    }
}
