<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class College extends Model
{
    use HasFactory;
    protected $gurd = [];
    protected $table = 'colleges';

    public function collegeYears()
    {
        return $this->hasMany(CollegeYear::class);
    }
    public function university()
    {
        return $this->belongsTo(University::class);
    }
    protected function getImageAttribute($value)
    {
        $path = '';
        if ($value) {
            if (str_contains($value, 'http://') || str_contains($value, 'https://')) {
                $path = $value;
            } else {
                $path = 'images/courses/' . $value;
            }
        } else {
            $path = 'images/logo.png';
        }
        return asset($path);
    }
}
