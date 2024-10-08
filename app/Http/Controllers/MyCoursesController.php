<?php

namespace App\Http\Controllers;
use App\Models\Courses;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class MyCoursesController extends Controller
{

    public function courses()
    {
        $currentUser = Auth::user();
        $data = Courses::leftJoin('user_courses', 'course_id', 'courses.id')->where('is_archived','0')->where('user_id', $currentUser->id)->withCount('users')->get();

        return view('own-courses', compact('data'));


    }
}
