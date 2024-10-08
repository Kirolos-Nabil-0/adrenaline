<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CollegeYear extends Model
{
    use HasFactory;
    protected $gurd = [];

    public function college()
    {
        return $this->belongsTo(College::class);
    }

    public function semesters()
    {
        return $this->hasMany(Semester::class);
    }
}
