<?php

namespace App\Http\Controllers;
use App\Models\Courses;

use Illuminate\Http\Request;

class CoursesControllerView extends Controller
{
    public function courses()
    {
        if (request('search') == null && request('myCourses') == null) {
            $data = Courses::withCount('users')->where('is_archived','0')->get();
        }
        return view('courses', compact('data'));

    }
}