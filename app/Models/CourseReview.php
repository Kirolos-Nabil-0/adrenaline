<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseReview extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'course_reviews';
    protected $guarded = [];
    use HasFactory;
    public function courses()
    {
        return $this->belongsTo(Courses::class, "course_id");
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
