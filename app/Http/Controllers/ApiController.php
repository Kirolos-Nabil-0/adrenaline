<?php

namespace App\Http\Controllers;

use App\Models\College;
use App\Models\CourseCode;
use App\Models\Courses;
use App\Models\Module;
use App\Models\PriceModule;
use App\Models\University;
use App\Models\User;
use App\Models\UserCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class ApiController extends Controller
{
    public function getInstructorsData()
    {
        $data = User::where('role', 'instructor')->has('owned_active_courses')->get();
        // foreach($data as $user){
        //     if(!$user->profile_photo_path){
        //         $user->profile_photo_path="images/logo.png";
        //     }
        // }
        $response = $data->toArray();
        return response($response, 200);
        // return response()->json(['message' => 'Success', "data" => $response, 'status_code' => 200,], 200);
    }
    public function getCentersData()
    {
        $data = User::where('role', 'center')->has('getCenterActiveCourses')->get();
        $response = $data->toArray();
        return response($response, 200);
    }
    public function getModulesData($ins_id)
    {
        $data = Module::leftJoin('courses', 'courses.module_id', '=', 'modules.id')
            ->where('courses.created_by', $ins_id)
            ->where('courses.is_archived', '0')
            ->where('modules.is_archived', '0')
            ->select('courses.created_by as instructorId', 'modules.id', 'modules.name', 'modules.image as image')
            ->groupBy('id', 'name', 'image', 'instructorId')
            ->get();

        $response = $data->toArray();
        return response($response, 200);
        // return response()->json(['message' => 'Success', "data" => $response, 'status_code' => 200,], 200);
    }

    public function getCoursesByInstructor($ins_id){
        $data = Courses::where('is_archived', '0')->where('created_by', $ins_id)->has('section')->with('owner.instructorReviews')
            ->with('reviews')->withCount(['reviews as rate' => function ($query) {
                $query->select(DB::raw('coalesce(round(avg(rating)),0)'));
            }])->get();

        $response = $data->toArray();
        return response($response, 200);
        // return response()->json(['message' => 'Success', "data" => $response, 'status_code' => 200,], 200);
    }

    public function getCoursesByCenter(string $center_id){
        
        $instructorIds = User::where('role', 'instructor')->where('center_id', $center_id)->pluck('id');
        $data = Courses::where('is_archived', '0')
            ->where('created_by', $center_id)
            ->orWhereIn('created_by', $instructorIds)
            ->has('section')->with('owner.instructorReviews')
            ->with('reviews')->withCount(['reviews as rate' => function ($query) {
                $query->select(DB::raw('coalesce(round(avg(rating)),0)'));
            }])->get();

        $response = $data->toArray();
        return response($response, 200);
        // return response()->json(['message' => 'Success', "data" => $response, 'status_code' => 200,], 200);
    }

    public function getCoursesByModule($module_id){
        $data = Courses::where('is_archived', '0')->where('module_id', $module_id)->has('section')->with('owner.instructorReviews')
            ->with('reviews')->withCount(['reviews as rate' => function ($query) {
                $query->select(DB::raw('coalesce(round(avg(rating)),0)'));
            }])->get();

        $response = $data->toArray();
        return response($response, 200);
        // return response()->json(['message' => 'Success', "data" => $response, 'status_code' => 200,], 200);
    }

    public function getCoursesByInstructorModule($ins_id, $module_id){
        $data = Courses::where('is_archived', '0')->where('created_by', $ins_id)->where('module_id', $module_id)->has('section')->with('owner.instructorReviews')
            ->with('reviews')->withCount(['reviews as rate' => function ($query) {
                $query->select(DB::raw('coalesce(round(avg(rating)),0)'));
            }])->get();

        $response = $data->toArray();
        return response($response, 200);
        // return response()->json(['message' => 'Success', "data" => $response, 'status_code' => 200,], 200);
    }

    public function getModules(){
        $user = auth()->user();
        $data = Module::where('is_archived', '0')->with('instructors')->has('instructors')->orderBy('updated_at', 'desc')->get();
        foreach ($data as $item) {
            if ($user->country === 'Egypt') {
                $item->price = $item->price_ar; // Price in Egyptian pounds
                $item->currency = "EGP";
            } else {
                $item->price = $item->price_en; // Price in dollars
                $item->currency = "USD";
            }
            foreach ($item->instructors as $i) {
                $pricemodule = PriceModule::where('module_id', $item->id)->where('user_id', $i->id)->first();
                if ($pricemodule) {
                    $i->module_price = $pricemodule->price;
                } else {
                    $i->module_price = null;
                }
            }
        }



        $response = $data->toArray();
        return response($response, 200);
        // return response()->json(['message' => 'Success', "data" => $response, 'status_code' => 200,], 200);
    }

    public function getCourses()
    {
        $data = Courses::where('is_archived', '0')->with('owner')->has('section')->orderBy('updated_at', 'desc')->with('owner.instructorReviews')
            ->with('reviews')->withCount(['reviews as rate' => function ($query) {
                $query->select(DB::raw('coalesce(round(avg(rating)),0)'));
            }])->get();

        $response = $data->toArray();
        return response($response, 200);
        // return response()->json(['message' => 'Success', "data" => $response, 'status_code' => 200,], 200);
    }

    public function getCoursesOffer()
    {
        $data = Courses::where('is_archived', '0')->where('discount_en', '>', 0)
            ->orWhere('discount_ar', '>', 0)->with('owner')->has('section')->orderBy('updated_at', 'desc')->with('owner.instructorReviews')
            ->with('reviews')->withCount(['reviews as rate' => function ($query) {
                $query->select(DB::raw('coalesce(round(avg(rating)),0)'));
            }])->get();

        $response = $data->toArray();
        return response()->json(['message' => 'Success', "data" => $response, 'status_code' => 200,], 200);
    }
    public function getCourse($id)
    {
        // Get the authenticated user
        $user = Auth::guard('sanctum')->user();


        $data = Courses::where('id', $id)
            ->where('is_archived', '0')
            ->with(['owner.instructorReviews', 'reviews', 'section'])
            ->has('section')
            ->withCount(['reviews as rate' => function ($query) {
                $query->select(DB::raw('coalesce(round(avg(rating)),0)'));
            }])
            ->get();

        return response()->json($data, 200);
    }

    public function getInstructor($id)
    {
        $data = User::where('id', $id)
            ->with([
                'instructorReviews',
                'owned_courses' => function ($query) {
                    $query->where('is_archived', '0')
                        ->with(['owner.instructorReviews', 'reviews', 'section'])
                        ->has('section')
                        ->withCount(['reviews as rate' => function ($query) {
                            $query->select(DB::raw('coalesce(round(avg(rating)),0)'));
                        }])->orderBy('updated_at', 'desc');
                }
            ])
            ->first();
        $response = $data->toArray();
        return response($response, 200);
        // return response()->json(['message' => 'Success', "data" => $data, 'status_code' => 200,], 200);
    }
    public function getInstructors()
    {
        $data = User::where('role', "instructor")
            ->with(
                [
                    'instructorReviews',
                    'owned_courses' => function ($query) {
                        $query->where('is_archived', '0')->has('section')->orderBy('updated_at', 'desc');
                    }
                ]
            )
            ->get();
        $response = $data->toArray();
        // return response($response, 200);
        return response()->json(['message' => 'Success', "data" => $data, 'status_code' => 200,], 200);
    }
    public function getCenter($id)
    {
        $center = User::where('id', $id)->where('role', 'center')->first();
        if($center){
            $reviews = $center->instructorReviews();
            $courses = $center->getCenterCourses();
            $instructors = $center->instructors;
            return response()->json([
                'message' => 'Success',
                'data' => array_merge($center->toArray(), [
                    'courses' => $courses,
                    'reviews' => $reviews,
                    'instructors' => $instructors,
                ]),
                'status_code' => 200
            ], 200);
        }else{
            return response()->json(['message' => 'Not Found', "data" => [], 'status_code' => 404,], 404);
        }
    }
    public function getCenters()
    {
        $data = User::where('role', "center")->get();
        return response()->json(['message' => 'Success', "data" => $data, 'status_code' => 200,], 200);
    }
    public function getEnrolledCourses()
    {
        $user = auth()->user();
        $data = User::where('id', $user->id)->with('enrolled_courses')->first();
        $response = $data->enrolled_courses->toArray();

        foreach ($response as &$course) {
            $course['price'] = strval($course['price']);
        }
        // $data = Courses::where('is_archived', '0')->has('section')->orderBy('updated_at', 'desc')->get();
        // foreach($data as $item){
        //     unset($item->created_by);
        // }
        // $response = $data->toArray();


        return response()->json(['message' => 'Success', "data" => $response, 'status_code' => 200,], 200);
    }

    public function search(Request $request)
    {
        $word = $request->word;
        $field = $request->field;
        $data = [];
        switch ($field) {
            case 'instructors':
                $data = User::whereNotNull('role')->has('owned_active_courses')->where(DB::raw('concat(firstname," ",lastname)'), 'like', '%' . $word . '%')->get();
                break;
            case 'modules':
                $data = Module::where('is_archived', '0')->where('modules.name', 'like', '%' . $word . '%')->with('instructors')->has('instructors')->orderBy('updated_at', 'desc')->get();
                foreach ($data as $item) {
                    foreach ($item->instructors as $i) {
                        $pricemodule = PriceModule::where('module_id', $item->id)->where('user_id', $i->id)->first();
                        if ($pricemodule) {
                            $i->module_price = $pricemodule->price;
                        } else {
                            $i->module_price = null;
                        }
                    }
                }
                break;
            case 'courses':
                $data = Courses::where('is_archived', '0')->where('courses.name', 'like', '%' . $word . '%')->with('owner')->has('section')->with('owner.instructorReviews')
                    ->with('reviews')->withCount(['reviews as rate' => function ($query) {
                        $query->select(DB::raw('coalesce(round(avg(rating)),0)'));
                    }])->orderBy('updated_at', 'desc')->get();
                break;
            case 'universities':
                $data = University::where('name', 'like', '%' . $word . '%')->get();
                break;
            case 'colleges':
                $data = College::where('name', 'like', '%' . $word . '%')->get();
                break;
            default:
                $data = 'Field error';
        }
        $response = $data;
        return response()->json(['message' => 'Success', "data" => $response, 'status_code' => 200,], 200);
    }
}