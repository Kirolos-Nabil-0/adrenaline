<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PackageController extends Controller{
    public function index(){
        $packages = Package::withCount('consumers')->get();

        return view('dashboard.package.index', compact('packages'));
    }

    public function create(){
        return view("dashboard.package.create");
    }

    public function store(Request $request){
        // return $request;

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:packages,name',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|numeric|min:0',
            'duration_type' => 'required|in:year,month,week,day',
            'video_support' => 'nullable|in:on,off',
            'video_maximum' => 'nullable|required_with:video_support,on|numeric|min:5|max:1024',
            'courses_limit' => 'nullable|numeric|min:1',
            'lessons_per_course_limit' => 'nullable|numeric|min:1',
        ],[
            'name.required' => 'يرجى إدخال اسم الباكدج',
            'name.unique' => 'اسم الباكدج موجود مسبقًا',
            'name.max' => 'اسم الباكدج لا يجب أن يتجاوز 255 حرفًا',
            
            'price.required' => 'يرجى إدخال سعر الباكدج',
            'price.numeric' => 'يجب أن يكون سعر الباكدج رقمًا',
            'price.min' => 'سعر الباكدج لا بد أن يكون أكثر من 0',
            
            'duration.required' => 'يرجى إدخال مدة الباكدج',
            'duration.numeric' => 'يجب أن تكون مدة الباكدج رقمًا',
            'duration.min' => 'مدة الباكدج لا بد أن تكون أكثر من 0',
            
            'duration_type.required' => 'يرجى إدخال نوع مدة الباكدج',
            'duration_type.in' => 'نوع المدة غير صالح',
            
            'video_support.in' => 'قيمة دعم الفيديو غير صالحة',
            
            'video_maximum.required_with' => 'يرجى إدخال الحد الأقصى للفيديو عند تفعيل دعم الفيديو',
            'video_maximum.numeric' => 'يجب أن يكون الحد الأقصى للفيديو رقمًا',
            'video_maximum.min' => 'الحد الأدني للفيديو يجب أن يكون 5 ميجابايت على الأقل',
            'video_maximum.max' => 'الحد الأقصى للفيديو يجب ألا يتجاوز 1 جيجابايت',
            
            'courses_limit.numeric' => 'يجب أن يكون الحد الأقصى للدورات رقمًا',
            'courses_limit.min' => 'يجب أن يكون الحد الأقصى للدورات 1 على الأقل',
            
            'lessons_per_course_limit.numeric' => 'يجب أن يكون الحد الأقصى للدروس لكل دورة رقمًا',
            'lessons_per_course_limit.min' => 'يجب أن يكون الحد الأقصى للدروس لكل دورة 1 على الأقل',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $video_maximum = 0;
        if($request->input('video_support') === 'on'){
            $video_maximum = $request->input('video_maximum') ?? 10000;
        }
        
        Package::create([
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'duration' => $request->input('duration'),
            'description' => $request->input('description'),
            'duration_type' => $request->input('duration_type'),
            'video_support' => $request->input('video_support') === 'on',
            'video_maximum' => $video_maximum,
            'courses_limit' => $request->input('courses_limit') ?? 10000, 
            'lessons_per_course_limit' => $request->input('lessons_per_course_limit') ?? 10000,
        ]);
        
        session()->flash('Add', 'تم اضافة الباكدج بنجاح ');
        return redirect()->back();
    }

    public function edit(Package $package){
        return view('dashboard.package.edit', compact('package'));
    }

    public function update(Package $package, Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:packages,name,'.$package->id,
            'price' => 'required|numeric|min:0',
            'duration' => 'required|numeric|min:0',
            'duration_type' => 'required|in:year,month,week,day',
            'video_support' => 'nullable|in:on,off',
            'video_maximum' => 'nullable|required_with:video_support,on|numeric|min:5|max:1024',
            'courses_limit' => 'nullable|numeric|min:1',
            'lessons_per_course_limit' => 'nullable|numeric|min:1',
        ],[
            'name.required' => 'يرجى إدخال اسم الباكدج',
            'name.unique' => 'اسم الباكدج موجود مسبقًا',
            'name.max' => 'اسم الباكدج لا يجب أن يتجاوز 255 حرفًا',
            
            'price.required' => 'يرجى إدخال سعر الباكدج',
            'price.numeric' => 'يجب أن يكون سعر الباكدج رقمًا',
            'price.min' => 'سعر الباكدج لا بد أن يكون أكثر من 0',
            
            'duration.required' => 'يرجى إدخال مدة الباكدج',
            'duration.numeric' => 'يجب أن تكون مدة الباكدج رقمًا',
            'duration.min' => 'مدة الباكدج لا بد أن تكون أكثر من 0',
            
            'duration_type.required' => 'يرجى إدخال نوع مدة الباكدج',
            'duration_type.in' => 'نوع المدة غير صالح',
            
            'video_support.in' => 'قيمة دعم الفيديو غير صالحة',
            
            'video_maximum.required_with' => 'يرجى إدخال الحد الأقصى للفيديو عند تفعيل دعم الفيديو',
            'video_maximum.numeric' => 'يجب أن يكون الحد الأقصى للفيديو رقمًا',
            'video_maximum.min' => 'الحد الأدني للفيديو يجب أن يكون 5 ميجابايت على الأقل',
            'video_maximum.max' => 'الحد الأقصى للفيديو يجب ألا يتجاوز 1 جيجابايت',
            
            'courses_limit.numeric' => 'يجب أن يكون الحد الأقصى للدورات رقمًا',
            'courses_limit.min' => 'يجب أن يكون الحد الأقصى للدورات 1 على الأقل',
            
            'lessons_per_course_limit.numeric' => 'يجب أن يكون الحد الأقصى للدروس لكل دورة رقمًا',
            'lessons_per_course_limit.min' => 'يجب أن يكون الحد الأقصى للدروس لكل دورة 1 على الأقل',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $video_maximum = 0;
        if($request->input('video_support') === 'on'){
            $video_maximum = $request->input('video_maximum') ?? 10000;
        }
        
        $package->update([
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'duration' => $request->input('duration'),
            'description' => $request->input('description'),
            'duration_type' => $request->input('duration_type'),
            'video_support' => $request->input('video_support') === 'on',
            'video_maximum' => $video_maximum,
            'courses_limit' => $request->input('courses_limit') ?? 10000, 
            'lessons_per_course_limit' => $request->input('lessons_per_course_limit') ?? 10000,
        ]);
        
        session()->flash('Add', 'تم تعديل الباكدج بنجاح ');
        return redirect()->back();
    }

    public function destroy(Package $package){
        if($package->consumers->count() > 0){
            session()->flash('delete', 'لا يمكن حذ هذة الباكدج لإرتباطها بمستهلكين! ');
            return redirect()->back();
        }

        $package->delete();
        session()->flash('Add', 'تم حذف الباكدج بنجاح ');
        return redirect()->back();
    }

    public function my_plan(){
        $user = User::find(Auth::id());
        if(!$user || !in_array($user->role, ['instructor', 'center']) || !$user->currentPackage()){
            return redirect()->route("admin.dashboard");
        }

        $package = $user->currentPackage();
        
        return view("dashboard.package.my_plan", compact("package"));
    }
}