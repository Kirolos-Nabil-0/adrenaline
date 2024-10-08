<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstructorReview extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'instructor_reviews';
    protected $guarded = [];
    use HasFactory;
    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function learner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
