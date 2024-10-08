<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $guarded=[];
    protected $hidden = ['created_at', 'updated_at'];

    public function course()
    {
        return $this->belongsTo('App\Models\Courses', 'course_id', 'id');
    }

    public function lesson()
    {
        return $this->hasMany('App\Models\Lesson', 'section_id', 'id');
    }
}
