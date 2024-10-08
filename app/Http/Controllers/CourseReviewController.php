<?php

namespace App\Http\Controllers;

use App\Models\CourseReview;
use App\Models\InstructorReview;
use App\Models\ProductReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CourseReviewController extends Controller
{

    public function createReview(Request $request)
    {
        try {
            $validator =  Validator::make($request->all(), [
                'rating' => 'required|integer|min:1|max:5',
                'course_id' => 'required|integer',
                'review' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return response()->json(['message' => __('custom.validation_error'), 'errors' => $validator->errors(), 'status_code' => 400], 400);
            }
            // $user = Auth::guard('sanctum')->user();
            $review = new CourseReview();
            $review->course_id = $request->input('course_id');
            $review->user_id = $request->userId; // Assuming you are using authentication
            $review->rating = $request->input('rating');
            $review->review = $request->input('review');
            $review->save();
            return response()->json(['message' => "sucss", 'status_code' => 200], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => "erorr" . $e, 'status_code' => 500], 500);
        }
    }
    public function instructorReview(Request $request)
    {
        try {
            $validator =  Validator::make($request->all(), [
                'rating' => 'required|integer|min:1|max:5',
                'instructor_id' => 'required|integer',
                'review' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return response()->json(['message' => __('custom.validation_error'), 'errors' => $validator->errors(), 'status_code' => 400], 400);
            }
            // $user = Auth::guard('sanctum')->user();
            $review = new InstructorReview();
            $review->instructor_id = $request->input('instructor_id');
            $review->user_id = $request->userId; // Assuming you are using authentication
            $review->rating = $request->input('rating');
            $review->review = $request->input('review');
            $review->save();
            return response()->json(['message' => "sucss", 'status_code' => 200], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => "erorr" . $e, 'status_code' => 500], 500);
        }
    }
}
