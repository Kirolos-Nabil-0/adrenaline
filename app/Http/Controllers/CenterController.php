<?php

namespace App\Http\Controllers;

use App\Helpers\PackageHelper;
use App\Http\Resources\CenterResource;
use App\Models\Package;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class CenterController extends Controller
{
    public function index(Request $request){
        $centers = User::withCount(['instructors', 'courses'])->where('role', '=','center')->get();
        return view('dashboard.centers.index', compact('centers'));
    }

    public function create(){
        $packages = Package::select(['id', 'name', 'price'])->get();
        return view("dashboard.centers.create", compact('packages'));
    }
    
    public function store(Request $request){

        $request->validate([
            'name' => ['required', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'min:8'],
            'profile_photo_path' => ['nullable', 'image'],
            'package_id' => 'nullable|exists:packages,id'
        ], [
            'name.required' => 'الاسم مطلوب',
            'email.required' => 'البريد الالكتروني مطلوب',
            'email.unique' => 'البريد الالكتروني موجود من قبل',
            'password.required' => 'كلمة المرور مطلوبه',
            'password.min' => 'كلمة المرور يجب ألا تقل عن 8 حروف',
            'profile_photo_path.image' => 'لابد أن يكون الملف من نوع صورة'
        ]);

        $data = [
            'firstname' => $request->name,
            'lastname' => '',
            'email' => $request->email,
            'country' => 'Egypt',
            'password' => Hash::make($request->password),
            'device_token' => null,
            'role' => 'center',
            "email_verified_at" => now(),
        ];
        
        if($request->hasFile('profile_photo_path')){
            $file_extension = $request->file("profile_photo_path")->getClientOriginalExtension();
            $file_name = time() . '.' . $file_extension;
            $path = 'images/users/centers';
            $request->file("profile_photo_path")->move($path, $file_name);
            $data['profile_photo_path'] = $path . '/' . $file_name;
        }

        $user = User::create($data);

        if($request->has("package_id") && $request->package_id != ''){
            PackageHelper::attachUserToPackage($user->id, $request->package_id);
        }
        
        return back()->with('success', 'تم اضافة السنتر بنجاح');
    }
    
    public function show(User $center){
        return view("dashboard.centers.show", compact('center'));
    }
    
    
    public function edit(User $center){
        $packages = Package::select(['id', 'name', 'price'])->get();
        return view("dashboard.centers.edit", compact('packages', 'center'));
    }
    
    public function update(Request $request, User $center){
        $request->validate([
            'package_id' => 'nullable|exists:packages,id',
            'status' => 'nullable|in:true,false'
        ]);

        if($request->has("package_id") && $request->package_id != ''){
            PackageHelper::updateAndAttachPackage($center, $request->package_id);
        }
        
        return back()->with('success', 'تم تعديل السنتر بنجاح');
    }

    public function activatePackage(User $center){
        PackageHelper::activatePackage($center);
        return back()->with('success', 'تم تفعيل خطة السنتر بنجاح');
    }

    public function deactivatePackage(User $center){
        PackageHelper::deactivatePackage($center);
        return back()->with('success', 'تم الغاء تفعيل خطة السنتر بنجاح');
    }

    public function destroy(User $center){
        if($center->getCenterCourses() || $center->instructors){
            return back()->with('danger', 'لا يمكن حذف هذا السنتر لانه مرتبط بمعلمين وكورسات');
        }
        
        $center->delete();
        return redirect()->route('centers')->with('success', 'تم حذف السنتر بنجاح');
    }
}