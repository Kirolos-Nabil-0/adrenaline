<?php

namespace App\Http\Controllers;

use App\Models\Courses;
use App\Models\Semester;
use App\Models\University;
use App\Models\User;
use App\Models\UserCourse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CoursesController extends Controller
{
    public function index(){
        $user = User::find(Auth::id());

        $courses_count = 0;
        if($user->role == 'instructor'){
            $courses_count = $user->owned_courses->count();
        }else if($user->role == 'center'){
            $courses_count = $user->getCenterCourses()->count();
        }
        $current_package = $user->currentPackage();
        
        $universities = University::all();
        return view('dashboard.addcourses', compact('universities', 'courses_count', 'current_package'));
    }

    public function store(Request $request){
        $user = User::find(Auth::id());

        $courses_count = 0;
        if($user->role == 'instructor'){
            $courses_count = $user->owned_courses->count();
        }else if($user->role == 'center'){
            $courses_count = $user->getCenterCourses()->count();
        }
        $current_package = $user->currentPackage();

        if($user->role == 'admin' || ($current_package && $current_package->courses_limit > $courses_count)){
            $price_free = 'required';
            if ($request->has('free')) {
                $price_free = '';
            }
            $rules = [
                'name' => 'required',
                'description' => 'nullable',
                'image' => 'required|image',
                'price_ar' => $price_free,
                'price_en' => $price_free,
            ];
            $request->validate($rules);
            
            $file_name = '';
            if($request->hasFile('image')){
                $file_extension = $request->file('image')->getClientOriginalExtension();
                $file_name = time() . '.' . $file_extension;
                $path = 'images/courses';
                $request->file('image')->move($path, $file_name);
            }
            $semester = new Semester();
            if ($request->type == "universities") {
                if ($request->semester == "1") {
                    $semester = Semester::where("college_year_id", $request->college_year)->first();
                } else {
                    $semester = Semester::where("college_year_id", $request->college_year)->latest()->first();
                }
            }
    
            Courses::create([
                'name' => $request->name,
                'description' => $request->description,
                'image' => $file_name, // Store the path to the file
                'price_ar' => $request->price_ar,
                'price_en' => $request->price_en,
                'discount_en' => $request->discount_en ?? 0,
                'discount_ar' => $request->discount_ar ?? 0,
                'type' => $request->type,
                'semester_id' => $request->type == "universities" ? $semester->id : null,
                'created_by' => auth()->user()->id,
                'free' => $request->free == "on" ? 1 : 0
            ]);
    
            return redirect()->route('courses-page')->with(['success' => 'The Course added successfully']);
        }else{
            return redirect()->back()->with(['warning' => 'You have reached the limit of courses for your plan which is '.$current_package->courses_limi. ' course.']);
        }

    }
}