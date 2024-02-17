<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'profile_id',
        'blog_category_id',
        'title',
        'body',
        'coverImg',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    public function category()
    {
        return $this->belongsTo(BlogCategory::class);
    }
}
