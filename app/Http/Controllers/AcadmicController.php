<?php


namespace App\Http\Controllers;

use App\Models\{Banner, University, College, CollegeYear, CourseCode, Courses, Semester, SettingWeb, User};
use App\Notifications\LoginNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AcadmicController extends Controller
{
    public function indexAPi()
    {
        $settings = SettingWeb::first();
        // return 
        $settings['version'] = '1.0.2';
        $settings['api_url']  = 'https://adrenaline-edu.com/arab_api_v1/get_youtube_qualities';
        return response()->json(['message' => 'Success', "data" => $settings, 'version' => '1.0.2', 'status_code' => 200,], 200);
    }
    public function getCoursesbySemester($id)
    {
        $data = Courses::where('is_archived', '0')->where('semester_id', $id)->with('owner')->has('section')->with('owner.instructorReviews')
            ->with('reviews')->withCount(['reviews as rate' => function ($query) {
                $query->select(DB::raw('coalesce(round(avg(rating)),0)'));
            }])->orderBy('updated_at', 'desc')->get();

        $response = $data->toArray();
        // return response($response, 200);
        return response()->json(['message' => 'Success', "data" => $response, 'status_code' => 200,], 200);
    }
    public function getUniversity()
    {
        $university = University::all();
        return response()->json(['message' => 'Success', "data" => $university, 'status_code' => 200,], 200);
    }
    public function getColleges(University $university)
    {
        $colleges = $university->college->where('status', '1');

        return response()->json(['message' => 'Success', "data" => $colleges, 'status_code' => 200,], 200);
    }

    // Fetch years of study for a specific college
    public function getYears(College $college)
    {
        $collegeYears = $college->collegeYears; // Assuming 'years' is the relationship name in College model
        return response()->json(['message' => 'Success', "data" => $collegeYears, 'status_code' => 200], 200);
    }

    // Fetch semesters by year of study
    public function getCoursesbyType(Request $request)
    {
        $data = Courses::where('is_archived', '0')->where('type', $request->type)->with('owner')->has('section')->with('owner.instructorReviews')
            ->with('reviews')->withCount(['reviews as rate' => function ($query) {
                $query->select(DB::raw('coalesce(round(avg(rating)),0)'));
            }])->orderBy('updated_at', 'desc')->get();

        $response = $data->toArray();

        return response()->json(['message' => 'Success', "data" => $response, 'status_code' => 200,], 200);
    }

    public function getSemesters(CollegeYear $year)
    {
        try {

            $semesters = $year->semesters;

            return response()->json(['message' => 'Success', "data" => $semesters, 'status_code' => 200], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'This year it is not available', 'status_code' => 500], 500);
        }
    }

    public function joinCourse(Request $request)
    {
        try {

            $code =   CourseCode::where("code", $request->code)->first();
            if ($code == null) {
                return response()->json(['message' => 'Code Not Found', 'status_code' => 404], 404);
            }
            $user =  Auth::user();
            if ($code->is_used == 1 || $code->is_used == true) {
                return response()->json(['message' => 'Code is not avalibel', 'status_code' => 401], 401);
            }
            $code->user_id = $user->id;
            $code->created_at = now();
            $code->is_used = true;
            $code->save();

            $user->notify(new LoginNotification());
            return response()->json(['message' => 'Success', 'status_code' => 200], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'This year it is not available', 'status_code' => 500], 500);
        }
    }
    public function getCourseJoin(CollegeYear $year)
    {
        try {

            $semesters = $year->semesters;

            return response()->json(['message' => 'Success', "data" => $semesters, 'status_code' => 200], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'This year it is not available', 'status_code' => 500], 500);
        }
    }
    public function bannersApi(Request $request)
    {
        try {
            $banners = Banner::orderBy('arrange')->where("type", $request->type)->where(
                "status",
                1
            )->get();

            return response()->json([
                'status_code' => 200,
                'message' => 'Success',
                'banners' => $banners,

            ], 200);
        } catch (\Throwable $e) {
            return response()->json(['message' => 'failed to retrieve data', 'status_code' => 500], 500);
        }
    }
}