<?php

namespace App\Http\Controllers;

use App\Mail\TestEmail;
use App\Models\User;
use App\Models\Module;
use App\Models\Courses;
use App\Models\UserCourse;
use App\Notifications\EmailverfyNotification;
use App\Notifications\EmailverfyNotUserNotification;
use Ichtrojan\Otp\Otp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Notification;

class ApiAuthController extends Controller
{
    public $otp;

    public function __construct()
    {
        $this->otp = new Otp;
    }


    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response([
                'message' => 'البريد الالكتروني غير مسجل',
            ], 404);
        }
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response([
                'message' => 'كلمة المرور غير مطابقة',
            ], 404);
        }
        if ($user->role == null) {
            if ($user->email != 'demo@demo.com') {
                if ($user->device_token != $request->device_token) {
                    return response([
                        'message' => 'الجهاز غير مسجل',
                    ], 404);
                }
            }
        }
        $token = $user->createToken('my-app-token')->plainTextToken;
        $response = [
            'user' => $user,
            'token' => $token,
        ];
        return response($response, 201);
        // return response()->json(['message' => 'Success', "data" => $response, 'status_code' => 200,], 200);
    }


    public function register(Request $request)
    {
        $request->validate([
            'firstname' => ['required', 'max:255'],
            'lastname' => ['required', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', 'min:8'],
            'country' => ['required', 'string'],
            'device_token' => ['required'],
            'otp' => 'required|string|max:6',
        ], [
            'firstname.required' => 'الاسم الاول مطلوب',
            'lastname.required' => 'الاسم الثاني مطلوب',
            'email.required' => 'البريد الالكتروني مطلوب',
            'email.unique' => 'البريد الالكتروني موجود من قبل',
            'password.required' => 'كلمة المرور مطلوبه',
            'password.confirmed' => 'كلمة المرور غير مطابقة',
            'password.min' => 'كلمة المرور يجب ألا تقل عن 8 حروف'
        ]);
        $otp2 = $this->otp->validate($request->email, $request->otp);
        if (!$otp2->status) {
            return response()->json(['message' => 'invalid otp', 'status_code' => 404], 404);
        }
        $user = User::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'country' => $request->country,
            'password' => Hash::make($request->password),
            'device_token' => $request->device_token,
            "email_verified_at" => now(),
        ]);
        $token = $user->createToken('my-app-token')->plainTextToken;
        $response = [
            'message' => 'saved',
            'user' => $user,
            'token' => $token,
        ];
        $user->save();
        return response($response, 201);
    }
    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);
        Log::info($request);

        $inpout = $request->input('email');
        $user = User::where('email', $inpout)->first();
        if ($user) {
            $user->notify(new EmailverfyNotification());
            $user->tokens()->delete();
        } else {
            $message = "Please use the following OTP to verify your email address";
            $fromEmail = "mail@adrenaline-edu.com";
            $subject = "Verification needed";
            Mail::to($inpout)->send(new TestEmail($message, $fromEmail, $subject, $inpout));
        }
        return response(['massage' => 'success'], 200);
    }
    public function resetPassword(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'new_password' => [
                    'required',
                    'string',
                    'min:8',
                ],
                'new_password_confirmation' => 'required|string|same:new_password',
                'otp' => 'required|string|max:6',
                'email' => 'required|string',
            ]);
            if ($validator->fails()) {
                return response()->json(['message' => $validator->errors()->first(), 'errors' => $validator->errors(), 'status_code' => 400], 400);
            }
            $user = User::where('email', $request->email)->first();
            if (!$user) {
                return response()->json(['message' => 'user not found', 'status_code' => 404], 404);
            }
            $otp2 = $this->otp->validate($request->email, $request->otp);
            if (!$otp2->status) {
                return response()->json(['message' => 'invalid otp', 'status_code' => 404], 404);
            }

            $user->password = bcrypt($request->new_password);
            $user->save();
            $user->tokens()->delete();

            return response(['massage' => 'success'], 200);
        } catch (\Exception $e) {
            return response(['massage' => 'error'], 500);
        }
    }
    public function get_active_user()
    {
        $user = Auth::user();
        $response = [
            "user" => $user
        ];
        return response($response, 201);
        // return response()->json(['message' => 'Success', "data" => $response, 'status_code' => 200,], 200);
    }

    public function update(Request $request)
    {
        $old_password_required = '';
        if ($request->password) {
            $old_password_required = 'required|';
        }
        $request->validate([
            'firstname' => 'required|max:255',
            'lastname' => 'required|max:255',
            'old_password' => $old_password_required . 'min:8',
            'password' => 'confirmed|min:8',
            'profile_photo_path' => 'image'
        ], [
            'firstname.required' => 'الاسم الاول مطلوب',
            'lastname.required' => 'الاسم الثاني مطلوب',
            'old_password.required' => 'كلمة المرور القديمة مطلوبه',
            'password.required' => 'كلمة المرور الجديدة مطلوبه',
            'password.confirmed' => 'كلمة المرور غير مطابقة',
            'password.min' => 'كلمة المرور يجب ألا تقل عن 8 حروف',
            'profile_photo_path.image' => 'برجاء اختيار امتداد صورة صحيح'
        ]);

        $user = auth()->user();

        if ($user->email != 'demo@demo.com') {
            $user->firstname = $request->firstname;
            $user->lastname = $request->lastname;

            if ($request->password) {
                if (!Hash::check($request->old_password, $user->password)) {
                    return response(['message' => 'كلمة المرور القديمة غير مطابقة'], 401);
                }
                $user->password = Hash::make($request->password);
            }

            if ($request->profile_photo_path) {
                $file_extension = $request->profile_photo_path->getClientOriginalExtension();
                $file_name = "profiles-" . time() . '.' . $file_extension;
                $path = 'uploaded/';
                $request->profile_photo_path->move($path, $file_name);
                $replaced_url = route('home');
                $img_file = str_replace($replaced_url . "/", "", $user->profile_photo_path);
                if ($user->profile_photo_path != null && !str_contains($user->profile_photo_path, 'logo.png') && file_exists($img_file)) {
                    unlink($img_file);
                }
                $user->profile_photo_path =  $path . $file_name;
            }

            $user->save();
            $response = [
                'message' => 'تم تعديل بيانات المستخدم',
                'user' => $user
            ];
        } else {
            $response = [
                'message' => 'لا يمكن تعديل بيانات هذا المستخدم',
                'user' => $user
            ];
        }
        return response($response, 201);
        // return response()->json(['message' => 'Success', "data" => $response, 'status_code' => 200,], 200);
    }

    public function delete_account()
    {
        $user = auth()->user();
        Courses::where('created_by', $user->id)->delete();
        Module::where('created_by', $user->id)->delete();
        UserCourse::where('user_id', $user->id)->delete();

        $user->delete();

        $response = [
            'message' => 'تم حذف المستخدم',
        ];
        return response($response, 201);
        // return response()->json(['message' => 'Success', "data" => $response, 'status_code' => 200,], 200);
    }
}