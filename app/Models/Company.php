<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'logo',
        'description',
        'address',
        'contact',
        'email',
        'website',
        'establishDate',
        'status',
        'jobsPosted',
        'restrictionFeedback',
    ];

    protected $attributes = [
        'status' => 'PENDING',
        'restrictionFeedback' => null,
    ];

    public function employees()
    {
        return $this->hasMany(User::class)->whereNotIn('role', ['Super Admin', 'Admin']);
    }

    public function jobs()
    {
        return $this->hasMany(Job::class);
    }

    public function companyPlugins()
    {
        return $this->hasMany(CompanyPlugin::class);
    }

    public function plugins()
    {
        return $this->belongsToMany(Plugin::class);
    }

    public function blogCategories()
    {
        return $this->hasMany(BlogCategory::class);
    }

    public function blogs()
    {
        return $this->hasMany(Blog::class);
    }
}
