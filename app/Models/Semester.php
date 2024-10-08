<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    use HasFactory;
    protected $fillable = ['year_id', 'semester_name'];
    protected $gurd = [];
    public function courses()
    {
        return $this->hasMany(Courses::class, 'created_by');
    }
    public function year()
    {
        return $this->belongsTo(CollegeYear::class);
    }
}
