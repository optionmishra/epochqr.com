<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;
    protected $fillable = [
        'name'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subprojects()
    {
        return $this->hasMany(Subproject::class);
    }

    public function campaigns()
    {
        return $this->hasMany(Campaign::class);
    }
}
