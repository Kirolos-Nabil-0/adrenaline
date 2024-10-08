<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseCode extends Model
{
    public $timestamps = false;
    public function course()
    {
        return $this->belongsTo(Courses::class);
    }
    public function student()
    {
        return $this->belongsTo(User::class);
    }
}
