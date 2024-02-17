<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyPlugin extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'plugin_id',
        'status',
        'rejectionFeedback',
    ];

    protected $attributes = [
        'status' => 'PENDING',
        'rejectionFeedback' => null,
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function plugin()
    {
        return $this->belongsTo(Plugin::class);
    }
}
