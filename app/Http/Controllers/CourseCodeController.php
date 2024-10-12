<?php

namespace App\Http\Controllers;

use App\Models\College;
use App\Models\CourseCode;
use App\Models\Courses;
use App\Models\University;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CourseCodeController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role == 'admin') {
            // Admin can see all courses and course codes
            $course = Courses::all();
            $courseCodes = CourseCode::all();
        } elseif ($user->role == 'center') {
            // Center can see its own courses and those created by associated instructors
            $course = Courses::where('created_by', $user->id)
                ->orWhereIn('created_by', function($query) use ($user) {
                    $query->select('id')
                        ->from('users')
                        ->where('role', 'instructor')
                        ->where('center_id', $user->id);
                })
                ->get();
        
            $courseCodes = CourseCode::whereIn('course_id', $course->pluck('id'))->get();
        }
        
        // Return view with courses and course codes
        return view('dashboard.coursecode.index', compact('course', 'courseCodes'));
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'code' => 'nullable|unique:course_codes|max:255',
            'get_code' => 'nullable',
            'course_id' => 'required|exists:courses,id',
            'expires_at' => 'required|date|after_or_equal:today',
            'quantity' => 'required|numeric|min:1',
        ], [
            'code.required' => 'يرجى إدخال الرمز',
            'code.unique' => 'الرمز موجود مسبقًا',
            'course_id.required' => 'يرجى تحديد الكورس',
            'course_id.exists' => 'الكورس المحدد غير موجود',
            'expires_at.required' => 'يرجى تحديد تاريخ انتهاء الصلاحية',
            'expires_at.date' => 'يرجى إدخال تاريخ صحيح',
            'expires_at.after_or_equal' => 'يجب أن يكون تاريخ انتهاء الصلاحية في المستقبل',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        if ($request->get_code == "on") {
            # code...

            for ($i = 0; $i < $request->input('quantity'); $i++) {
                $code = new CourseCode;
                $code->code = $request->get_code == "on" ? $this->generateUniqueCode() : $request->input('code', $this->generateUniqueCode());
                $code->created_at = now();
                $code->expires_at = $request->input('expires_at');
                $code->course_id = $request->input('course_id');
                $code->save();
            }
        } else {
            $code = new CourseCode;
            $code->code = $request->get_code == "on" ? $this->generateUniqueCode() : $request->input('code', $this->generateUniqueCode());
            $code->created_at = now();
            $code->expires_at = $request->input('expires_at');
            $code->course_id = $request->input('course_id');
            $code->save();
        }
        session()->flash('success', 'تم إضافة الرمز بنجاح');
        return redirect()->back();
    }
    protected function generateUniqueCode()
    {
        $length = 8; // Set the desired code length
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }

        // Check if the generated code already exists in the database
        while (CourseCode::where('code', $randomString)->exists()) {
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[random_int(0, $charactersLength - 1)];
            }
        }

        return $randomString;
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|max:255|unique:course_codes,code,' . $id,
            'expires_at' => 'required|date|after_or_equal:today',
        ], [
            'code.required' => 'يرجى إدخال الرمز',
            'code.unique' => 'الرمز موجود مسبقًا',
            'expires_at.required' => 'يرجى تحديد تاريخ انتهاء الصلاحية',
            'expires_at.date' => 'يرجى إدخال تاريخ صحيح',
            'expires_at.after_or_equal' => 'يجب أن يكون تاريخ انتهاء الصلاحية في المستقبل',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $code = CourseCode::findOrFail($id);
        $code->code = $request->input('code');
        $code->expires_at = $request->input('expires_at');
        $code->save();

        session()->flash('success', 'تم تحديث الرمز بنجاح');
        return redirect()->back();
    }


    public function destroy(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:course_codes,id',
        ]);
        
        $courseCode = CourseCode::find($request->id);
    
        if (!$courseCode) {
            return response()->json([
                'success' => false,
                'message' => 'Course code not found',
            ], 404);
        }
    
        $courseCode->delete();
    
        return response()->json([
            'success' => true,
            'message' => 'Course code removed successfully',
        ]);
    }    

    public function destroyGroup(Request $request)
    {        
        $ids = $request->id;
        $deletedCount = 0;
    
        foreach ($ids as $id) {
            $courseCode = CourseCode::find($id);
            if ($courseCode) {
                $courseCode->delete();
                $deletedCount++;
            }
        }
    
        return response()->json([
            'success' => true,
            'message' => "$deletedCount course code(s) removed successfully",
        ]);
    }      
}