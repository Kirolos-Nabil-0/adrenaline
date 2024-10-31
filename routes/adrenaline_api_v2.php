<?php

use App\Http\Controllers\AcadmicController;
use App\Http\Controllers\ApiAuthController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\CourseReviewController;
use App\Http\Controllers\StatsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\YoutubeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('reset-password', [ApiAuthController::class, 'resetPassword']);

Route::post('forgot-password', [ApiAuthController::class, 'forgotPassword']);
Route::controller(AcadmicController::class)->group(function () {
    Route::get('/getUniversity', 'getUniversity');
    Route::get('/info/app', 'indexAPi');
    Route::get('/university/{university}/college', 'getColleges');
    Route::get('/colleges/{college}/years', 'getYears');
    Route::get('/years/{year}/semesters', 'getSemesters');
    Route::get('/banners/data', 'bannersApi');
    Route::get('/semesters/{id}/courses', 'getCoursesbySemester');
    Route::get('/courses/getCoursesbyType', 'getCoursesbyType');
    Route::get('/getCoursesOffer', [ApiController::class, 'getCoursesOffer']);
    Route::get('/getCourses', [ApiController::class, 'getCourses']);
    Route::get('/getCourse/{id}', [ApiController::class, 'getCourse']);
    Route::post('/courses/joinCourse', 'joinCourse')->middleware("auth:sanctum");
    Route::get('/semesters/getCourseJoin', 'getCourseJoin');
    Route::get('/search', [ApiController::class, 'search']);
    Route::get('/stats', [StatsController::class, 'index']);
});
Route::post('/login', [ApiAuthController::class, 'login']);
Route::post('/register', [ApiAuthController::class, 'register']);
Route::post('get_youtube_qualities', [YoutubeController::class, 'get_youtube_qualities']);
Route::get('/getInstructor/{id}', [ApiController::class, 'getInstructor']);
Route::get('/getInstructors', [ApiController::class, 'getInstructors']);
Route::get('/getCenter/{id}', [ApiController::class, 'getCenter']);
Route::get('/getCenters', [ApiController::class, 'getCenters']);
Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('getMyCourse', [UserController::class, 'getMyCourse'])->name('getMyCourse');
    Route::get('checkMyCourse/{id}', [UserController::class, 'checkMyCourse'])->name('checkMyCourse');
    Route::post('create-review', [CourseReviewController::class, 'createReview'])->name('create.review');
    Route::post('create-instructorReview', [CourseReviewController::class, 'instructorReview'])->name('create.instructorReview');
    Route::post('/get_active_user', [ApiAuthController::class, 'get_active_user']);
    Route::post('/update', [ApiAuthController::class, 'update']);
    Route::post('/deleteAccount', [ApiAuthController::class, 'delete_account']);
    Route::get('/getInstructorsData', [ApiController::class, 'getInstructorsData']);
    Route::get('/getModulesData/{ins_id}', [ApiController::class, 'getModulesData']);
    Route::get('/getCoursesByInstructorModule/insId/{ins_id}/moduleId/{module_id}', [ApiController::class, 'getCoursesByInstructorModule']);
    Route::get('/getCoursesByInstructor/insId/{ins_id}', [ApiController::class, 'getCoursesByInstructor']);
    Route::get('/getCoursesByCenter/centerId/{center_id}', [ApiController::class, 'getCoursesByCenter']);
    Route::get('/getCoursesByModule/moduleId/{module_id}', [ApiController::class, 'getCoursesByModule']);
    Route::get('/getModules', [ApiController::class, 'getModules']);

    Route::get('/getEnrolledCourses', [ApiController::class, 'getEnrolledCourses']);
});