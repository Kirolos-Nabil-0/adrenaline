<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Courses;
use App\Models\User;

class Module extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function courses()
    {
        return $this->hasMany(Courses::class)->with('authorized_users');
    }
    public function owner()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function instructors_rel()
    {
        return $this->belongsToMany(User::class, 'courses', 'module_id', 'created_by');
    }

    public function instructors()
    {
        return $this->instructors_rel()->distinct();
    }
    public function authorized_users()
    {
        $course_users = $this->courses()->with('authorized_users')->get()->pluck('authorized_users')->toArray();
        $auth_users = [];
        foreach ($course_users as $course) {
            foreach ($course as $user) {
                $flag = false;
                foreach ($auth_users as $u) {
                    if ($u['id'] == $user['id']) {
                        $flag = true;
                    }
                }
                if (!$flag) {
                    array_push($auth_users, $user);
                }
            }
        }
        $courses = $this->courses()->pluck('courses.id')->toArray();
        $users = [];
        foreach ($auth_users as $user) {
            $flag = true;
            foreach ($courses as $course) {
                $exist = CourseModifier::where('course_id', $course)->where('user_id', $user['id'])->first();
                if (!$exist) {
                    $flag = false;
                    break;
                }
            }
            if ($flag) {
                array_push($users, $user);
            }
        }
        return $users;
    }
    protected function getImageAttribute($value)
    {
        $path = '';
        if ($value) {
            if (str_contains($value, 'http://') || str_contains($value, 'https://')) {
                $path = $value;
            } else {
                $path = 'images/modules/' . $value;
            }
        } else {
            $path = 'images/logo.png';
        }
        return asset($path);
    }
}
