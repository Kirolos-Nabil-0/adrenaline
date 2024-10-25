<?php

namespace App\Http\Controllers;

use App\Helpers\PackageHelper;
use App\Models\Package;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class InsController extends Controller
{
    public function index(Request $request){
        $user = User::find(Auth::id());
        $instructors = null;
        if($user->role == 'admin'){
            $instructors = User::withCount(['owned_courses'])->where('role', 'instructor')->get();
        }else if($user->role == 'center'){
            $instructors = User::withCount(['owned_courses'])->where('role', 'instructor')->where('center_id', $user->id)->get();
        }
        return view('dashboard.instructors.index', compact('instructors'));
    }

    public static function isInstructor(){
        $user = Auth::user();
        if (!$user) {
            return false;
        } else {
            if ($user->role == 'instructor') {
                return true;

            } else {
                return false;
            }
        }
    }

    public function update_user_role(Request $request){
        $id=$request->id;
        $user=User::find($id);
        $user->role=$request->role;
        $user->save();
        return response()->json([
            'success'=>true
        ]);
    }

    public function remove_user(Request $request){
        $request->validate([
            'id' => 'required|integer|exists:users,id',
        ]);
    
        $user = User::find($request->id);
    
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found',
            ], 404);
        }
    
        $user->delete();
    
        return response()->json([
            'success' => true,
            'message' => 'User removed successfully',
        ]);
    }    

    public function create(){
        $packages = Package::select(['id', 'name', 'price'])->get();
        return view("dashboard.instructors.create", compact('packages'));
    }

    public function store(Request $request){
        $center = User::where('id', Auth::id())->where('role', 'center')->first();
        
        $request->validate([
            'firstname' => ['required', 'max:255'],
            'lastname' => ['required', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'min:8'],
            'profile_photo_path' => ['nullable', 'image'],
            'package_id' => 'nullable|exists:packages,id'
        ], [
            'firstname.required' => 'الاسم الاول مطلوب',
            'lastname.required' => 'الاسم الثاني مطلوب',
            'email.required' => 'البريد الالكتروني مطلوب',
            'email.unique' => 'البريد الالكتروني موجود من قبل',
            'password.required' => 'كلمة المرور مطلوبه',
            'password.min' => 'كلمة المرور يجب ألا تقل عن 8 حروف',
            'profile_photo_path.image' => 'لابد أن يكون الملف من نوع صورة'
        ]);

        $data = [
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'country' => 'Egypt',
            'password' => Hash::make($request->password),
            'device_token' => null,
            'role' => 'instructor',
            "email_verified_at" => now(),
        ];

        if($center){
            $data['center_id'] = $center->id;
        }
        
        if($request->hasFile('profile_photo_path')){
            $file_extension = $request->file("profile_photo_path")->getClientOriginalExtension();
            $file_name = time() . '.' . $file_extension;
            $path = 'images/users/instructors';
            $request->file("profile_photo_path")->move($path, $file_name);
            $data['profile_photo_path'] = $path . '/' . $file_name;
        }

        $instructor = User::create($data);
        
        if($center){
            $package = $center->currentPackage();
            if($package){
                $instructor->packages()->attach($package->id, [
                    'start_date' => $package->pivot->start_date,
                    'end_date' => $package->pivot->end_date,
                ]);
            }
        }else if($request->has("package_id") && $request->package_id != ''){
            PackageHelper::attachUserToPackage($instructor->id, $request->package_id);
        }

        return back()->with('success', 'تم انشاء حساب المحاضر بنجاح');
    }

    public function show(User $instructor){
        return view("dashboard.instructors.show", compact('instructor'));
    }

    public function edit(User $instructor){
        $packages = Package::select(['id', 'name', 'price'])->get();
        return view("dashboard.instructors.edit", compact('packages', 'instructor'));
    }

    public function update(Request $request, User $instructor){
        $request->validate([
            'package_id' => 'nullable|exists:packages,id',
            'status' => 'nullable|in:true,false'
        ]);

        if($request->has("package_id") && $request->package_id != ''){
            PackageHelper::updateAndAttachPackage($instructor, $request->package_id);
        }

        if($request->has("status") && $request->status == 'false' && $instructor->currentPackage()){
            $package = $instructor->currentPackage();
            $package->pivot->status = false;
            $package->pivot->save();
        }
        
        return back()->with('success', 'تم تعديل المحاضر بنجاح');
    }

    public function activatePackage(User $instructor){
        $currentDeactivePackage = $instructor->currentDeactivePackage();
        if($currentDeactivePackage){
            $currentDeactivePackage->pivot->status = true;
            $currentDeactivePackage->pivot->save();
        }
        
        return back()->with('success', 'تم تفعيل الخطة بنجاح');
    }

    public function deactivatePackage(User $instructor){
        $currentPackage = $instructor->currentPackage();
        if($currentPackage){
            $currentPackage->pivot->status = false;
            $currentPackage->pivot->save();
        }
        
        return back()->with('success', 'تم الغاء تفعيل الخطة بنجاح');
    }
}