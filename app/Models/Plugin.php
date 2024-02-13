<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plugin extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
    ];

    public function companyPlugins()
    {
        return $this->hasMany(CompanyPlugin::class);
    }

    public function companies()
    {
        return $this->belongsToMany(Company::class);
    }
}
