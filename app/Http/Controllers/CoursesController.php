<?php

namespace App\Http\Controllers;

use App\Models\Courses;
use App\Models\Semester;
use App\Models\University;
use App\Models\UserCourse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class CoursesController extends Controller
{
    public function index()
    {
        $universities = University::all();
        return view('dashboard.addcourses', compact('universities'));
    }

    public function store(Request $request)
    {

        $price_free = 'required';
        if ($request->has('free')) {
            $price_free = '';
        }
        $rules = [
            'name' => 'required',
            'description' => 'required',
            'image' => 'required|image',
            'price_ar' => $price_free,
            'price_en' => $price_free,
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInputs($request->all());
        }

        $file_extension = $request->image->getClientOriginalExtension();
        $file_name = time() . '.' . $file_extension;
        $path = 'images/courses';
        $request->image->move($path, $file_name);
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

        return redirect()->back()->with(['success' => 'The Course added successfully']);
    }
}