<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'title',
        'description',
        'coverImg',
    ];

    protected $casts = [
        'description' => 'array'
    ];
}
