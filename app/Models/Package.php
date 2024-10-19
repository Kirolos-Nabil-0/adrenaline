<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'price', 
        'description', 
        'duration_type', 
        'duration', 
        'video_support',
        'video_maximum',
        'courses_limit',
        'lessons_per_course_limit'
    ];

    public function consumers(){
        return $this->belongsToMany(User::class)
            ->withPivot('start_date', 'end_date')
            ->withTimestamps();
    }
}