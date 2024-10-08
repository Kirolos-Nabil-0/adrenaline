<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $guarded = [];
    use HasFactory;
    protected function getImageAttribute($value)
    {
        $path = '';
        if ($value) {
            if (str_contains($value, 'http://') || str_contains($value, 'https://')) {
                $path = $value;
            } else {
                $path = 'images/courses/' . $value;
            }
            return asset($path);
        }
        return null;
    }
}