<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class University extends Model
{
    use HasFactory;
    protected $gurd = [];
    public function college()
    {
        return $this->hasMany(College::class, 'university_id');
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
