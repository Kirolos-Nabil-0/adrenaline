<?php

namespace App\Http\Controllers;

use App\Models\College;
use App\Models\CourseCode;
use App\Models\User;
use App\Models\Module;
use App\Models\Courses;
use App\Models\Section;
use App\Models\University;
use App\Models\UserCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class AdminController extends Controller
{
    public function index(){
        $user = auth()->user();

        // Get all counts only once
        $universitiesCount = University::count();
        $collegesCount = College::count();

        // Initialize common variables
        $coursesCount = 0;
        $lessonsCount = 0;
        $enrollmentCount = 0;
        $sectionsCount = 0;
        $usersCount = 0;
        $instructorsCount = 0;
        $centersCount = 0;
        $codesCount = 0;

        // Logic based on user role
        if ($user->role == 'admin') {
            // Admin can see all courses and instructors
            $courses = Courses::withCount('lessons')->get();
            $coursesCount = $courses->count();
            $lessonsCount = $courses->sum('lessons_count');
            $instructorsCount = User::where('role', 'instructor')->count();
            $enrollmentCount = CourseCode::where('is_used', true)->count();
            $usersCount = User::whereNull('role')->count();
            $sectionsCount = Section::count();
            $centersCount = User::where('role', 'center')->count();
            $codesCount = CourseCode::count();
        } elseif ($user->role == 'instructor') {
            // Instructor can see their own courses
            $courses = Courses::where('created_by', $user->id)->withCount('lessons')->get();
            $coursesCount = $courses->count();
            $lessonsCount = $courses->sum('lessons_count');
            $enrollmentCount = CourseCode::where('is_used', true)->whereIn('course_id', $courses->pluck('id'))->count();
            $sectionsCount = $courses->sum(function ($course) {
                return $course->section()->count();
            });
        } elseif ($user->role == 'center') {
            // Center can see its courses and those of associated instructors
            $instructors = User::where('role', 'instructor')->where('center_id', $user->id)->get();
            $instructorIds = $instructors->pluck('id');

            $courses = Courses::where('created_by', $user->id)
                ->orWhereIn('created_by', $instructorIds)
                ->withCount('lessons')
                ->get();

            $coursesCount = $courses->count();
            $lessonsCount = $courses->sum('lessons_count');
            $sectionsCount = $courses->sum(function ($course) {
                return $course->section()->count();
            });
            $instructorsCount = $instructors->count();
            $enrollmentCount = CourseCode::where('is_used', true)
                ->whereIn('course_id', $courses->pluck('id'))
                ->count();
            $codesCount = CourseCode::whereIn('course_id', $courses->pluck('id'))
                ->count();
        }

        $oneYearAgo = now()->subYear()->startOfDay(); // Adjust for a year
        $statistics = DB::table('payments')
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


        //////////////////////////////////////////////##############INSTRUCTOR#################////////////////////////////////////////////////////////////////////////////////////////////////////////

        // }      
        $statisticsIns = DB::table('payments')->where('user_id', Auth::user()->id)
            ->whereDate('created_at', '>=', $oneYearAgo)
            ->select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'), DB::raw('SUM(amount) as total_sales'))
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        $monthNamesIns = [];
        $totalSalesIns = [];

        foreach ($statisticsIns as $statistic) {
            $monthName = date('M Y', strtotime($statistic->month)); // Format date as 'Month Year', e.g., 'Apr 2023'
            $monthNamesIns[] = $monthName; //$monthPrefix . 
            $totalSalesIns[] = $statistic->total_sales;
        }

        // Ensure all months are represented in the chart
        $allMonthsIns = [];
        for ($i = 0; $i < 12; $i++) {
            $allMonthsIns[] = now()->subMonths($i)->format('M Y');
        }
        $allMonthsIns = array_reverse($allMonthsIns);

        foreach ($allMonthsIns as $month) {
            if (!in_array($month, $monthNamesIns)) {
                $monthNamesIns[] = $month;
                $totalSalesIns[] = 0;
            }
        }

        $colorsIns = []; // Array to hold dynamic colors
        foreach ($monthNamesIns as $index => $monthName) {
            $colorsIns[] = '#' . substr(md5(rand()), 0, 6); // Generate a random color
        }


        return view('dashboard.home-dashboard', compact('coursesCount', 'lessonsCount', 'enrollmentCount', 'usersCount', 'universitiesCount', 'sectionsCount', 'codesCount', 'collegesCount', 'monthNames', 'totalSales', 'colors', 'monthNamesIns', 'totalSalesIns', 'colorsIns', 'instructorsCount', 'centersCount'));
        // return view('dashboard.home-dashboard', compact('courses', 'lessons', 'enroll', 'users', 'num', 'universitys', 'section', 'codes', 'colleges', 'monthNames', 'totalSales', 'colors', 'monthNamesIns', 'totalSalesIns', 'colorsIns', 'instructors'));
    }

    public static function isAdmin()
    {
        $user = Auth::user();
        if (!$user) {
            return false;
        } else {
            if ($user->role == 'admin') {
                return true;
            } else {
                return false;
            }
        }
    }

    public function historyEnroll()
    {
        if (request()->ajax()) {
            $data = UserCourse::leftJoin('users', 'users.id', '=', 'user_id')->leftJoin('courses', 'courses.id', '=', 'course_id')->orderBy('user_courses.id', 'desc')->get(['user_courses.id as cid', 'user_courses.status', 'users.*', 'courses.*']);
            return datatables()->of($data)->addIndexColumn()->make(true);
        }
        return view('dashboard.enrollment-history');
    }

    public function deleteUserCourse($id){
        UserCourse::find($id)->delete();
        return response()->json([
            'success' => true
        ]);
    }

    public function changeStatus($id){
        $c = UserCourse::find($id);
        $c->status = $c->status == 1 ? 0 : 1;
        $c->save();
        return response()->json([
            'success' => true
        ]);
    }

    public function addStudent(){
        $users = User::all()->except(Auth::id(1));
        $courses = Courses::all();
        $modules = Module::leftJoin('courses', 'module_id', '=', 'modules.id')
            ->leftJoin('users', 'users.id', '=', 'courses.created_by')
            ->whereNotNull('courses.module_id')
            ->select('users.id as user_id', DB::raw('concat(users.firstname," ",users.lastname) as user_name'), 'modules.id as module_id', 'modules.name as module_name')
            ->groupBy('user_id', 'user_name', 'modules.id', 'module_name')
            ->get();

        return view('dashboard.add-student', compact('users', 'courses', 'modules'));
    }

    public function enrollmentStudent(Request $request){
        $failed_users = [];
        if ($request->users) {
            if (count($request->users) > 0) {
                foreach ($request->users as $userId) {
                    if (isset($request->enroll_course)) {
                        $is_enrolled = UserCourse::where('user_id', $userId)->where('course_id', $request->course_id)->first();
                        if (!$is_enrolled) {
                            $enroll = new UserCourse();
                            $enroll->course_id = $request->course_id;
                            $enroll->user_id = $userId;
                            $enroll->status = $request->status;
                            $enroll->save();
                        } else {
                            array_push($failed_users, $userId);
                        }
                    }
                    if (isset($request->enroll_module)) {
                        if ($request->module) {
                            $module_id = explode('/', $request->module)[0];
                            $user_id = explode('/', $request->module)[1];
                            $courses = Courses::where('created_by', $user_id)->where('module_id', $module_id)->get();
                            foreach ($courses as $course) {
                                $is_enrolled = UserCourse::where('user_id', $userId)->where('course_id', $course->id)->first();
                                if (!$is_enrolled) {
                                    $enroll = new UserCourse();
                                    $enroll->course_id = $course->id;
                                    $enroll->user_id = $userId;
                                    $enroll->status = $request->status;
                                    $enroll->save();
                                } else {
                                    array_push($failed_users, $userId);
                                }
                            }
                        }
                    }
                }
            }
        }

        if (count($request->users) == count($failed_users)) {
            $message = "";
        } elseif (count($failed_users) == 0) {
            $message = 'Student(s) added successfully';
        } else {
            $message = "Student(s) added successfully and<br>";
        }
        foreach ($failed_users as $userId) {
            $user = User::find($userId);
            $message .= $user->firstname . ' ' . $user->lastname . " is already linked to this course <br>";
        }
        return redirect()->back()->with(['success' => $message]);
    }

    public function settings()
    {
        $user = Auth::user();
        return view('setting', compact('user'));
    }

    public function updateUser(Request $request)
    {
        $currentUser = Auth::user();
        $rules = [
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email|unique:users,email,' . $currentUser->id,
            'password' => 'confirmed'
        ];
        $messages = [
            'firstname.required' => 'الأسم الأول مطلوب',
            'lastname.required' => 'الأسم الأخير مطلوب',
            'email.required' => 'الايميل الأول مطلوب',
            'email.unique' => 'الايميل موجود مسبقا',
            'password.confirmed' => 'كلمة المرور غير مطابقة'
        ];
        $validator = Validator::make(
            $request->all(),
            $rules,
            $messages
        );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInputs($request->all());
        }

        $data = $request->all();
        if (request('profile_photo_path')) {
            $file_extension = request('profile_photo_path')->getClientOriginalExtension();
            $file_name = "profiles-" . time() . '.' . $file_extension;
            $path = 'uploaded/';
            $request->profile_photo_path->move($path, $file_name);
            $data['profile_photo_path'] =  $path . $file_name;
            $replaced_url = route('home');
            $img_file = str_replace($replaced_url . "/", "", $currentUser->profile_photo_path);
            if ($currentUser->profile_photo_path != null && !str_contains($currentUser->profile_photo_path, 'logo.png') && file_exists($img_file)) {
                unlink($img_file);
            }
        }
        if ($request->password) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }
        $currentUser->update($data);
        return redirect()->back()->with(['success' => 'Changes has been changed successfully']);
    }
    public function removeImage(Request $request)
    {
        $user = Auth::user();
        $replaced_url = route('home');
        $img_file = str_replace($replaced_url . "/", "", $user->profile_photo_path);
        if ($user->profile_photo_path != null && !str_contains($user->profile_photo_path, 'logo.png') && file_exists($img_file)) {
            unlink($img_file);
            $user->profile_photo_path = null;
        }
        $user->save();
        return redirect()->back();
    }
}