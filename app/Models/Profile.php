<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'firstName',
        'lastName',
        'profileImg',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function blogs()
    {
        return $this->hasMany(Blog::class);
    }

    protected static function boot()
    {
        static::saving(function ($model) {
            $model->profileImg = $model->profileImg ?? env('DEFAULT_PROFILE_IMG');
        });

        parent::boot();
    }
}
