<?php

namespace App\Http\Controllers;

use App\Models\CourseCode;
use App\Models\Courses;
use App\Models\Lesson;
use App\Models\Section;
use App\Models\User;
use App\Models\UserCourse;
use App\Models\SettingWeb;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Console\Input\Input;

class UserController extends Controller
{
    public function index()
    {

        //        re "My public IP address is: " . $ip;
        $title = 'الكورسات المتوفرة';
        if (request('myCourses') !== null) {
            $title = 'الكورسات الخاصة بي';
            $currentUser = Auth::user();
            $data = Courses::leftJoin('user_courses', 'course_id', 'courses.id')->where('is_archived', '0')->where('user_id', $currentUser->id)->withCount('users')->get();
        }
        if (request('search') !== null) {
            $title = "نتائج البحث";
            $data = Courses::where('is_archived', '0')->where('name', 'like', '%' . request('search') . '%')->withCount('users')->get();
            //            echo request('search');
            //            return $data;

        }
        if (request('search') == null && request('myCourses') == null) {
            $data = Courses::withCount('users')->where('is_archived', '0')->get();
        }
        return view('home', compact('data', 'title'));
    }

    public function courseView($course_id)
    {
        //        $data = Courses::all();
        //        return view('course-view', compact('data'));
        $settings = SettingWeb::first();
        $currentUser = Auth::user();
        $course = Courses::where('id', $course_id)->where('is_archived', '0')->with('section')->firstOrFail();
        $enroll = UserCourse::where('course_id', $course_id)->where('user_id', $currentUser->id)->first();
        $sections = Section::where('course_id', $course_id)->with('lesson')->get();

        $access = false;
        if ($enroll) {
            if ($enroll->status == 1) {
                $access = true;
            }
        }

        if ($course) {
            $users_count = count(User::leftJoin('user_courses', 'users.id', '=', 'user_id')->where('course_id', $course_id)->get());
            $lessons_count = 0;
            foreach ($course->section as $section) {
                $lessons_count += count($section->lesson);
            }
            return view('course-view', compact('course', 'users_count', 'access', 'lessons_count', 'sections', 'settings'));
        } else {
            return redirect('/')->with('status', 'The link was broken');
        }
    }

    public function coursePage($id)
    {
        $currentUser = Auth::user();

        UserCourse::where('course_id', $id)->where('user_id', $currentUser->id)->where('status', 1)->firstOrFail();

        $sections = Section::where('course_id', $id)->with('lesson')->get();
        return view('course-page', compact('sections'));
    }


    public function getMyCourse()
    {
        $user = Auth::user();
        $activeSubscriptions = CourseCode::where('user_id', $user->id)
            ->where('expires_at', '>', now())
            ->where('is_used', true)
            ->with('course')
            ->distinct("course_id")
            ->get();
        return response()->json($activeSubscriptions, 200);
    }

    public function checkMyCourse($courseId)
    {
        $user = Auth::user();
        $isSubscribed = CourseCode::where('user_id', $user->id)
            ->where('course_id', $courseId)
            ->where('expires_at', '>', now())
            ->where('is_used', true)
            ->exists();

        return response()->json(['subscribed' => $isSubscribed]);
    }
}
