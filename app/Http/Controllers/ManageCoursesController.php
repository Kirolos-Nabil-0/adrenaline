<?php

namespace App\Http\Controllers;

use App\Models\CourseCode;
use App\Models\CourseModifier;
use App\Models\User;
use App\Models\Lesson;
use App\Models\Module;
use App\Models\Courses;
use App\Models\Section;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ManageCoursesController extends Controller
{
    //
    public function index()
    {

        $showing_archived = 'all';
        if (request('is_archived') || request('is_archived') == 0) {
            $showing_archived = request('is_archived');
        }

        $user = auth()->user();
        if (request()->ajax()) {

            if ($user->role == "instructor") {
                if ($showing_archived == 'all') {
                    $data = Courses::where('created_by', $user->id)
                        ->orWhereHas('authorized_users', function ($q) use ($user) {
                            $q->where('user_id', $user->id);
                        })
                        ->with('module')
                        ->get();
                } else {
                    $data = Courses::where('is_archived', $showing_archived)
                        ->where('created_by', $user->id)
                        ->orWhereHas('authorized_users', function ($q) use ($user) {
                            $q->where('user_id', $user->id);
                        })
                        ->with('module')
                        ->get();
                }
            } 
            // Logic for center
            elseif ($user->role == "center") {
                if ($showing_archived == 'all') {
                    $data = Courses::where('created_by', $user->id)
                        ->orWhereIn('created_by', function($query) use ($user) {
                            $query->select('id')
                                ->from('users')
                                ->where('role', 'instructor')
                                ->where('center_id', $user->id);
                        })
                        ->with('module')
                        ->get();
                } else {
                    $data = Courses::where('is_archived', $showing_archived)
                        ->where(function ($query) use ($user) {
                            $query->where('created_by', $user->id)
                                ->orWhereIn('created_by', function($subQuery) use ($user) {
                                    $subQuery->select('id')
                                        ->from('users')
                                        ->where('role', 'instructor')
                                        ->where('center_id', $user->id);
                                });
                        })
                        ->with('module')
                        ->get();
                }
            } 
            // Logic for admin
            else {
                if ($showing_archived == 'all') {
                    $data = Courses::with(['owner', 'module'])->get();
                } else {
                    $data = Courses::where('is_archived', $showing_archived)
                        ->with(['owner', 'module'])
                        ->get();
                }
            }
        
            return datatables()->of($data)->addIndexColumn()->make(true);
        }
        $modules = Module::where('is_archived', '0')->get();
        return view('dashboard.courses-page', ['modules' => $modules]);
    }

    public function archiveCourse(Request $request)
    {
        $id = $request->id;
        $course = Courses::find($id);
        if ($course->is_archived == 0) {
            $course->is_archived = 1;
        } else {
            $course->is_archived = 0;
        }
        $course->save();

        return response()->json([
            'success' => true
        ]);
    }

    public function linkCourseModule(Request $request)
    {
        $course_id = $request->course_id;
        $module_id = $request->module_id;
        $module = Module::find($module_id);
        $module->updated_at = now();
        $module->save();

        Courses::find($course_id)->update([
            'module_id' => $module_id
        ]);

        return redirect()->back();
    }
    public function editCourse($course_id)
    {
        $numberStudent = CourseCode::where('course_id', $course_id)->where('is_used', true)->count();
        $sections = Section::where('course_id', $course_id)->count();
        $lessonsNumber = 0;
        foreach (Section::where('course_id', $course_id)->get() as $section) {
            $lessonsNumber += Lesson::where('section_id', $section->id)->count();
        }

        $user = auth()->user();
        $courseId = Courses::findOrFail($course_id);
        $users = User::where('role', 'instructor')->where('id', '<>', $user->id)->where('id', '<>', $courseId->created_by)->get();
        $selectedUsers = $courseId->authorized_users()->pluck('user_id')->toArray();
        $can_add_authorize = false;
        $oneYearAgo = now()->subYear()->startOfDay(); // Adjust for a year

        $statistics = DB::table('payments')->where('course_id', $course_id)
            ->whereDate('created_at', '>=', $oneYearAgo)
            ->select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'), DB::raw('SUM(amount) as total_sales'))
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        $monthNames = [];
        $totalSales = [];

        foreach ($statistics as $statistic) {
            $monthName = date('M Y', strtotime($statistic->month)); // Format date as 'Month Year', e.g., 'Apr 2023'
            $monthNames[] = $monthName; //$monthPrefix . 
            $totalSales[] = $statistic->total_sales;
        }

        // Ensure all months are represented in the chart
        $allMonths = [];
        for ($i = 0; $i < 12; $i++) {
            $allMonths[] = now()->subMonths($i)->format('M Y');
        }
        $allMonths = array_reverse($allMonths);

        foreach ($allMonths as $month) {
            if (!in_array($month, $monthNames)) {
                $monthNames[] = $month;
                $totalSales[] = 0;
            }
        }

        $colors = []; // Array to hold dynamic colors
        foreach ($monthNames as $index => $monthName) {
            $colors[] = '#' . substr(md5(rand()), 0, 6); // Generate a random color
        }




        if (($user->role == "instructor" && $user->id == $courseId->created_by) || ($user->role == "center" && $user->id == $courseId->created_by) || $user->role == "admin") {
            $can_add_authorize = true;
        }
        if ($user->role == "instructor" || $user->role == "admin" || $user->role == "center") {
            $authorized = CourseModifier::where('user_id', $user->id)->first();
            if ($user->id == $courseId->created_by || $authorized || $user->role == "admin") {

                return  view(
                    'dashboard.manage-courses',
                    compact('courseId', 'users', 'selectedUsers', 'can_add_authorize', 'numberStudent', 'lessonsNumber', 'sections', 'monthNames', 'totalSales', 'colors')
                );
            }
        } else {
            return redirect()->route('admin.dashboard');
        }
    }
    public function deleteCourse($id)
    {
        $user = auth()->user();
        $success = false;
        if ($user->role == 'admin') {
            Courses::find($id)->delete();
            $success = true;
        }
        return response()->json([
            'success' => $success
        ]);
    }
    public function update(Request $request, $course_id)
    {
        // return "---";
        $price_free = 'required';
        if ($request->has('free')) {
            $price_free = '';
        }
        if (isset($request->imageExist)) {
            $image_require = '';
        } else {
            $image_require = 'required|';
        }
        $rules = [
            'name' => 'required',
            'description' => 'required',
            'image' => $image_require . 'image',
            'price_ar' => $price_free,
            'price_en' => $price_free,

        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInputs($request->all());
        }


        $courseId = Courses::findOrFail($course_id);

        if ($request->image) {
            $file_extension = $request->image->getClientOriginalExtension();
            $file_name = time() . '.' . $file_extension;
            $path = 'images/courses';
            $request->image->move($path, $file_name);
            $courseId->image = $file_name;
        }

        $price = null;
        if (!$request->has('free')) {
            $price_ar = $request->price_ar;
            $price_en = $request->price_en;
            $discount_ar = $request->discount_ar;
            $discount_en = $request->discount_en;
        }

        $courseId->name = $request->name;
        $courseId->description = $request->description;
        $courseId->price_ar = $price_ar ?? 0;
        $courseId->price_en = $price_en ?? 0;
        $courseId->discount_ar = $discount_ar ?? 0;
        $courseId->discount_en = $discount_en ?? 0;
        $courseId->free = $request->free == "on" ? 1 : 0;
        $courseId->save();

        CourseModifier::where('course_id', $courseId->id)->delete();
        if ($request->users) {
            $request->collect('users')->each(function ($userId) use ($courseId) {
                CourseModifier::create([
                    'course_id' => $courseId->id,
                    'user_id' => $userId
                ]);
            });
        }
        return redirect()->back()->with(['success' => 'The Course updated successfully']);
    }


    public function createSections(Request $request)
    {
        $rules = [
            'section_name' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInputs($request->all());
        }
        //        ======================== Create Section=====================
        $data = $request->all();
        Section::create($data);
        return redirect()->back();
        //        ======================== End Create Section=====================
    }

    public function createLessons(Request $request)
    {
        // Validation rules
        $rules = [
            'lesson_name' => 'required',
            'is_lecture_free' => 'nullable|in:off,on',  // Add validation for the checkbox
            'video_type' => 'required|in:video_url,video_upload',
            'url' => 'required_if:video_type,video_url|nullable|url',
            'uploaded_video_path' => 'required_if:video_type,video_upload|nullable|string'
        ];
    
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInputs($request->all());
        }
    
        // Get all request data
        // dd($request);
        $data = [
            'lesson_name' => $request->input('lesson_name'),
            'section_id' => $request->input('section_id'),
            'video_type' => $request->input('video_type'),
            'url' => $request->input('url') ?? null,
            'duration' => $request->input('duration'),
            'mcq_url' => $request->input('mcq_url'),
            'is_lecture_free' => $request->input('is_lecture_free') == 'on' ? true : false,
            'video' => $request->input('uploaded_video_path'),
        ];

    
        // Handle file upload if present
        if ($request->hasFile('pdf_attach')) {
            $file_extension = $request->file('pdf_attach')->getClientOriginalExtension();
            $file_name = time() . '.' . $file_extension;
            $path = 'uploaded/attachments';
            $request->file('pdf_attach')->move($path, $file_name);
            $data['pdf_attach'] = $file_name;
        }
    
        // Ensure the 'is_lecture_free' field is set to false if not checked
        $data['is_lecture_free'] = $request->has('is_lecture_free') ? 1 : 0;
    
        // Create a new lesson with the provided data
        Lesson::create($data);
    
        return redirect()->back();
    }

    //    Start delete and update section

    public function deleteSection($id)
    {
        //        Lesson::where('course_id', $id)->delete();
        Section::find($id)->delete();
        return redirect()->back();
    }

    public function updateSection(Request $request, $id)
    {
        $section_id = Section::find($id);
        $section_id->update([
            'section_name' => $request->section_name,

        ]);
        return redirect()->back();
    }

    public function deleteLesson($id){

        $lesson = Lesson::find($id);
        if(!$lesson){
            throw new Exception("Lesson Not Found",404);
            
        }
        
        // Check if the file exists
        if($lesson->video){
            $existingVideoPath = $lesson->video;
            $localPath = public_path('uploaded/videos/' . basename($existingVideoPath));

            if (File::exists($localPath)) {
                File::delete($localPath);
            }
        }

        // Check if the file exists
        if($lesson->pdf_attach){
            $existingpdfPath = $lesson->pdf_attach;
            $localPath = public_path('uploaded/attachments/' . basename($existingpdfPath));

            if (File::exists($localPath)) {
                File::delete($localPath);
            }
        }

        $lesson->delete();
        return redirect()->back();
    }

    public function editLesson($id){
        $les = Lesson::find($id);
        if($les){
            $course = $les->section->course;
            $sections = $course->section;
            return view(
                'dashboard.edit-lesson',
                compact('les', 'course', 'sections')
            );
        }else{
            throw new Exception("Lesson Not found", 404);
        }
    }

    public function updateLesson(Request $request, $id){
        $lesson = Lesson::find($id);
        if(!$lesson){
            throw new Exception("Lesson not found", 404);
        }
        // Validation rules
        $rules = [
            'lesson_name' => 'required',
            'is_lecture_free' => 'boolean',  // Add validation for the checkbox
            'video_type' => 'required|in:video_url,video_upload',
            'url' => 'required_if:video_type,video_url|nullable|url',
            'uploaded_video_path' => 'nullable|string'
        ];
    
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }
    
        // Get all request data
        $data = [
            'lesson_name' => $request->input('lesson_name'),
            'section_id' => $request->input('section_id'),
            'url' => $request->input('url') ?? null,
            'duration' => $request->input('duration'),
            'mcq_url' => $request->input('mcq_url'),
            'is_lecture_free' => $request->input('is_lecture_free'),
        ];
        if(!($request->input('video_type') == 'video_upload' && $request->input('uploaded_video_path') == null)){
            $data['video_type'] = $request->input('video_type');
        }

        if(($request->input("video_type") == 'video_upload' && $request->input("uploaded_video_path")) || ($request->input("video_type") == 'video_url' && $lesson->video != null)){
            $data['video'] = $request->input('uploaded_video_path');

            // Check if the file exists
            if($lesson->video){
                $existingVideoPath = $lesson->video;
                $localPath = public_path('uploaded/videos/' . basename($existingVideoPath));

                if (File::exists($localPath)) {
                    File::delete($localPath);
                }
            }
        }
    
        // Handle file upload if present
        if ($request->hasFile('pdf_attach')) {
            $file_extension = $request->pdf_attach->getClientOriginalExtension();
            $file_name = time() . '.' . $file_extension;
            $path = 'uploaded/attachments';
            $request->pdf_attach->move($path, $file_name);
            $data['pdf_attach'] = $file_name;

            // Check if the file exists
            if($lesson->pdf_attach){
                $existingpdfPath = $lesson->pdf_attach;
                $localPath = public_path('uploaded/attachments/' . basename($existingpdfPath));

                if (File::exists($localPath)) {
                    File::delete($localPath);
                }
            }
        }
    
        // Ensure the 'is_lecture_free' field is set to false if not checked
        $data['is_lecture_free'] = $request->has('is_lecture_free') ? true : false;
    
        // Update the lesson with the new data
        $lesson->update($data);
    
        return redirect()->back();
    }
    public function rateCourse($course_id, $rate){
        Courses::find($course_id)->update(['rate' => $rate]);
        return response()->json([
            'success' => true
        ]);
    }


    public function orderLesons(Request $request){
        foreach ($request['lessons'] as $key => $value) {
            $lesson = Lesson::find($value);
            if ($lesson) {
                $lesson->update([
                    'order' => $key,
                ]);
            }
        }
        return response()->json([
            'success' => true
        ]);
    }

    // In your Controller
    public function uploadLessonVideo(Request $request){
        $request->validate([
            'video' => 'required|file|mimes:mp4,mov,avi,wmv|max:512000', // Limit to 500 MB
        ]);

        $videoFile = $request->file('video');
        $videoName = Str::random(10) . '.' . $videoFile->getClientOriginalExtension();
        $path = public_path('uploaded/videos');
            
        $videoFile->move($path, $videoName);

        return response()->json(['video_path' => $videoName]);
    }

}