<?php

use App\Http\Controllers\AcadmicController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\CollegeController;
use App\Http\Controllers\CollegeYearController;
use App\Http\Controllers\CourseCodeController;

use App\Http\Controllers\SettingWebController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CoursesController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CenterController;
use App\Http\Controllers\InsController;
use App\Http\Controllers\ManageCoursesController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\CoursesControllerView;

use App\Http\Controllers\MyCoursesController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\PayPalController;
use App\Http\Controllers\ReviewAppController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SemesterController;
use App\Http\Controllers\UniversityController;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::controller(SettingWebController::class)->group(function () {
    Route::get('/setting_web', 'index')->name('setting_web');
    Route::get('/setting/gift', 'gift')->name('setting.gift');
    Route::get('/colorweb', 'colorweb')->name('colorweb');
    Route::post('/settings/update', 'update')->name('settings.update');
    Route::post('/settings/updateGift', 'updateGift')->name('settings.updateGift');
    Route::post('/settings/store', 'store')->name('settings.store');
    Route::post('updatewebsite', 'updatewebsite')->name('admin.updatewebsite');
    Route::get('/privacy', 'privecy')->name('web.privecy');
    Route::get('/terms', 'terms')->name('web.terms');
    Route::get('/success', 'order_success')->name('web.order_success');
    Route::get('/failed', 'order_failed')->name('web.order_failed');
});

Route::controller(PayPalController::class)->group(function () {
    Route::get('/payments/payWithPaymob',  'payWithPaymob')->name('payment-payWithPaymob');
    Route::get('/payment/verify',  'verifyWithPaymob')->name('verify-payment');
    Route::get('/payments/payWithPaymobWallet',  'payWithPaymobWallet')->name('payment-payWithPaymobWallet');
    Route::get(
        '/payment/verify/wallet',
        'verifyWithPaymobWallet'
    )->name('verify-payment-wallet');
    Route::get('/payment/chexkout',  'checkout')->name('payment.chexkout');
    Route::get('/payment/verify/fawaterak',  'verifyWithFawaterak')->name('verify-payment-fawaterak');
    Route::get('/payment/method',  'method')->name('payment.method');
    // ---------------------------------------------------------------------------------------------
    Route::get('go-payment',  'goPayment')->name('payment.go');

    Route::get('payment',  'payment')->name('payment');
    Route::get('cancel',  'cancel')->name('payment.cancel');
    Route::get('payment/success',  'success')->name('payment.success');
    Route::get(
        '/refund/{token}',
        'initiateRefund'
    );
});

Route::controller(BannerController::class)->group(function () {
    Route::get('/banners', 'index')->name('banners');
    // Route::get('/coupons/create', 'create')->name('coupons.create');
    Route::post('/banners/store', 'store')->name('banners.store');
    Route::put('/banners/update', 'update')->name('banners.update');
    Route::delete('/banners/destroy', 'destroy')->name('banners.destroy');
    Route::post('/banners/update-status', 'updateStatusBanner')->name('banners.update-status');
});

Route::group(['middleware' => ['auth', 'checkIp']], function () {
    Route::get('/', [UserController::class, 'index'])->name('home');

    Route::get('/courses', [CoursesControllerView::class, 'courses'])->name('courses');
    Route::get('/myCourses', [MyCoursesController::class, 'courses'])->name('own-courses');
    Route::get('/search', [SearchController::class, 'search'])->name('search');

    Route::get('course-view/{course_id}', [UserController::class, 'courseView']);

    Route::controller(UniversityController::class)->group(function () {
        Route::get('/university', 'index')->name('university');
        Route::get('/university/create', 'create')->name('university.create');
        Route::post('/university/store', 'store')->name('university.store');
        Route::post('/university/update', 'update')->name('university.update');
        Route::post('/university/destroy', 'destroy')->name('university.destroy');
    });

    Route::controller(CollegeController::class)->group(function () {
        Route::get('/college', 'index')->name('college');
        Route::get('/college/create', 'create')->name('college.create');
        Route::post('/college/store', 'store')->name('college.store');
        Route::post('/college/update', 'update')->name('college.update');
        Route::post('/college/destroy', 'destroy')->name('college.destroy');
        Route::post('/college/update-status', 'updateStatusBanner')->name('college.update-status');
    });

    Route::controller(PackageController::class)->group(function () {
        Route::get('/packages', 'index')->name('packages.index');
        Route::get('/packages/create', 'create')->name('packages.create');
        Route::post('/packages/store', 'store')->name('packages.store');
        Route::get('/packages/{package}', 'show')->name('packages.show');
        Route::get('/packages/{package}/edit', 'edit')->name('packages.edit');
        Route::patch('/packages/{package}', 'update')->name('packages.update');
        Route::delete('/packages/{package}', 'destroy')->name('packages.destroy');
        Route::post('/packages/update-status', 'updateStatusBanner')->name('packages.update-status');
    });

    Route::controller(CourseCodeController::class)->group(function () {
        Route::get('/course_codes', 'index')->name('course_codes');
        Route::get('/course_codes/create', 'create')->name('course_codes.create');
        Route::post('/course_codes/store', 'store')->name('course_codes.store');
        Route::post('/course_codes/update', 'update')->name('course_codes.update');
        Route::post('/course_codes/destroy', 'destroy')->name('course_codes.destroy');
        Route::post('/course_codes/destroyGroup', 'destroyGroup')->name('course_codes.destroyGroup');
    });

    Route::controller(ReviewAppController::class)->group(function () {
        Route::get('/reviewCoureses', 'index')->name('reviewCoureses');
        Route::get('/reviewCoureses/create', 'create')->name('reviewCoureses.create');
        Route::post('/reviewCoureses/store', 'store')->name('reviewCoureses.store');
        Route::post('/reviewCoureses/update', 'update')->name('reviewCoureses.update');
        Route::post('/reviewCoureses/destroy', 'destroy')->name('reviewCoureses.destroy');
    });

    Route::controller(CollegeYearController::class)->group(function () {
        Route::get('/collegeyear', 'index')->name('collegeyear');
        Route::get('/collegeyear/byid', 'collegeById')->name('collegeyear.byid');
        Route::get('/collegeyear/collegeyearbyid', 'collegeYearById')->name('collegeyear.collegeyearbyid');
        Route::get('/collegeyear/create', 'create')->name('collegeyear.create');
        Route::post('/collegeyear/store', 'store')->name('collegeyear.store');
        Route::post('/collegeyear/update', 'update')->name('collegeyear.update');
        Route::post('/collegeyear/destroy', 'destroy')->name('collegeyear.destroy');
    });

    Route::controller(SemesterController::class)->group(function () {
        Route::get('/semester', 'index')->name('semester');
        Route::get('/semester/create', 'create')->name('semester.create');
        Route::post('/semester/store', 'store')->name('semester.store');
        Route::post('/semester/update', 'update')->name('semester.update');
        Route::post('/semester/destroy', 'destroy')->name('semester.destroy');
    });

    Route::get('course-page/{id}', [UserController::class, 'coursePage'])->name('course-page');
    Route::get('settings', [AdminController::class, 'settings'])->name('settings');
    Route::post('update-info', [AdminController::class, 'updateUser'])->name('update-info');
    Route::post('remove-image', [AdminController::class, 'removeImage'])->name('remove-image');

    Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'dashboard']], function () {
        Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::get('add-courses', [CoursesController::class, 'index'])->name('add-course');
        Route::post('create-course', [CoursesController::class, 'store'])->name('create-course');
        Route::get('courses-page', [ManageCoursesController::class, 'index'])->name('courses-page');
        Route::get('edit-course/{course_id}', [ManageCoursesController::class, 'editCourse']);
        Route::post('course-update/{course_id}', [ManageCoursesController::class, 'update'])->name('course-update');
        Route::post('create-section}', [ManageCoursesController::class, 'createSections'])->name('create-section');
        Route::post('create-lesson}', [ManageCoursesController::class, 'createLessons'])->name('create-lesson');
        Route::post('/upload-video', [ManageCoursesController::class, 'uploadLessonVideo'])->name('upload-lesson-video');
        Route::post('delete-section/{id}', [ManageCoursesController::class, 'deleteSection'])->name('delete-section');
        Route::post('delete-lesson/{id}', [ManageCoursesController::class, 'deleteLesson'])->name('delete-lesson');
        Route::post('update-section/{id}', [ManageCoursesController::class, 'updateSection'])->name('update-section');
        Route::get('edit-lesson/{id}', [ManageCoursesController::class, 'editLesson'])->name('edit-lesson');
        Route::post('update-lesson/{id}', [ManageCoursesController::class, 'updateLesson'])->name('update-lesson');
        Route::post('archiveCourse', [ManageCoursesController::class, 'archiveCourse'])->name('archiveCourse');
        Route::post('changeModulePrice', [ModuleController::class, 'changeModulePrice'])->name('changeModulePrice');
        Route::get('/manage-modules', [ModuleController::class, 'manage_modules'])->name('instructorModules');
        Route::get('/rateCourse/{course_id}/{rate}', [ManageCoursesController::class, 'rateCourse'])->name('rateCourse');
        Route::post('add_auth_user', [ModuleController::class, 'add_auth_user'])->name('add_auth_user');
        Route::post('delete_auth_user', [ModuleController::class, 'delete_auth_user'])->name('delete_auth_user');
        
    Route::group(['middleware' => ['auth', 'adminorcenter']], function () {
        // routes for admin or center
        Route::get('instructors', [InsController::class, 'index'])->name('instructors');
        Route::get('instructors/create', [InsController::class, 'create'])->name('instructors.create');
        Route::post('instructors', [InsController::class, 'store'])->name('instructors.store');
        Route::post('remove_user', [InsController::class, 'remove_user'])->name('remove_user');

        Route::controller(CourseCodeController::class)->group(function () {
            Route::get('/course_codes', 'index')->name('course_codes');
            Route::get('/course_codes/create', 'create')->name('course_codes.create');
            Route::post('/course_codes/store', 'store')->name('course_codes.store');
            Route::post('/course_codes/update', 'update')->name('course_codes.update');
            Route::post('/course_codes/destroy', 'destroy')->name('course_codes.destroy');
            Route::post('/course_codes/destroyGroup', 'destroyGroup')->name('course_codes.destroyGroup');
        });
    });
        
    Route::group(['middleware' => ['auth', 'admin']], function () {
        // routes for admin only
        Route::resource('module', ModuleController::class);
        Route::get('enrollment-history', [AdminController::class, 'historyEnroll'])->name('enrollment-history');
        Route::get('add-student', [AdminController::class, 'addStudent'])->name('add-student');
        Route::post('enrollment', [AdminController::class, 'enrollmentStudent'])->name('enrollment');
        Route::get('delete-user/{id}', [AdminController::class, 'deleteUserCourse'])->name('delete-user');
        Route::get('edit-status/{id}', [AdminController::class, 'changeStatus'])->name('edit-status');
        Route::get('centers', [CenterController::class, 'index'])->name('centers');
        Route::get('centers/create', [CenterController::class, 'create'])->name('centers.create');
        Route::post('centers', [CenterController::class, 'store'])->name('centers.store');
        Route::post('update_user_role', [InsController::class, 'update_user_role'])->name('update_user_role');
        Route::post('linkCourseModule', [ManageCoursesController::class, 'linkCourseModule'])->name('linkCourseModule');
        Route::get('deleteCourse/{id}', [ManageCoursesController::class, 'deleteCourse'])->name('deleteCourse');
        Route::get('deleteModule/{id}', [ModuleController::class, 'deleteModule'])->name('deleteModule');
        Route::post('archiveModule', [ModuleController::class, 'archiveModule'])->name('archiveModule');
        Route::get('orderLesons', [ManageCoursesController::class, 'orderLesons']);
    });

    });

    Route::group(['middleware' => ['auth', 'admin']], function () {
        // routes for admin & center
    });


    Route::group(['middleware' => ['auth', 'instructor']], function () {
        // routes for instructor only
    });
    Route::group(['middleware' => ['auth', 'center']], function () {
        Route::get('test-center', function(){
            return "this is the center auth";
        });
    });
    Route::get('logout' , [AuthenticatedSessionController::class , 'destroy'])->name('global_logout');
});