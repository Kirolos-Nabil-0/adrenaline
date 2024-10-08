<?php

namespace App\Http\Controllers;

use App\Models\CourseModifier;
use App\Models\User;
use App\Models\Module;
use App\Models\Courses;
use App\Models\PriceModule;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $showing_archived = 'all';
        if (request('is_archived') || request('is_archived') == 0) {
            $showing_archived = request('is_archived');
        }
        $user=auth()->user();
        $users = User::where('role', 'instructor')->where('id', '<>', $user->id)->get();

        if (request()->ajax()) {
            $modules = [];
            if ($showing_archived == 'all') {
                $modules = Module::get();
            } else {
                $modules = Module::where('is_archived', $showing_archived)->get();
            }
            foreach($modules as $module){
                $module->auth_users = $module->authorized_users();
            }
            return datatables()->of($modules)->addIndexColumn()->make(true);
        }
        return view('dashboard.modules',compact('users'));
    }
    public function manage_modules()
    {
        $user = auth()->user();
        if (request()->ajax()) {
            if($user->role=='admin'){
                $modules = Module::get();
            }else{
                $modules = $user->modules;
            }
            foreach ($modules as $module) {
                $pricemodule = PriceModule::where('module_id', $module->id)->where('user_id', $user->id)->first();
                if (!$pricemodule) {
                    $pricemodule = new PriceModule();
                    $pricemodule->module_id = $module->id;
                    $pricemodule->user_id = $user->id;
                    $pricemodule->save();
                }
                $module->price = $pricemodule->price;
            }

            return datatables()->of($modules)->addIndexColumn()->make(true);
        }
        return view('dashboard.instructor_modules');
    }
    public function add_auth_user(Request $request)
    {
        $courses = Courses::where('module_id', $request->module_id)->get();
        foreach ($courses as $course) {
            $exist = CourseModifier::where('user_id', $request->user_id)->where('course_id', $course->id)->first();
            if (!$exist) {
                CourseModifier::create([
                    'course_id' => $course->id,
                    'user_id' => $request->user_id,
                    'action'=>'module'
                ]);
            }
        }
        return response()->json([
            'success'=>true,
            'user'=>User::find($request->user_id)
        ]);
    }
    public function delete_auth_user(Request $request)
    {
        $courses = Courses::where('module_id', $request->module_id)->get();
        foreach ($courses as $course) {
             CourseModifier::where('user_id', $request->user_id)->where('action','module')->where('course_id', $course->id)->delete();
        }
        return response()->json([
            'success'=>true,
            'user'=>User::find($request->user_id)
        ]);
    }
    public function changeModulePrice(Request $request)
    {
        $module_id = $request->module_id;
        $user = auth()->user();
        PriceModule::where('module_id', $module_id)->where('user_id', $user->id)->delete();
        PriceModule::create([
            'module_id' => $module_id,
            'user_id' => $user->id,
            'price' => $request->module_price
        ]);
        return response()->json([
            'success' => true
        ]);
    }
    public function archiveModule(Request $request)
    {
        $id = $request->id;
        $module = Module::find($id);
        if ($module->is_archived == 0) {
            $module->is_archived = 1;
        } else {
            $module->is_archived = 0;
        }
        $module->save();

        return response()->json([
            'success' => true
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $action = 'add';
        $courses = Courses::whereNull('module_id')->where('is_archived', '0')->orderBy('created_by', 'desc')->get();
        return view('dashboard.addmodule', compact('action', 'courses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'required|image',
        ]);

        $file_extension = $request->image->getClientOriginalExtension();
        $file_name = time() . '.' . $file_extension;
        $path = 'images/modules';
        $request->image->move($path, $file_name);

        $module = Module::create([
            'name' => $request->name,
            'image' => $file_name,
            'created_by' => auth()->user()->id
        ]);

        $request->collect('courses')->each(function ($cid) use ($module) {
            $course = Courses::find($cid);
            $course->module_id = $module->id;
            $course->save();
        });

        return redirect()->back()->with('success', 'Module is addedd successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $action = 'edit';
        $module = Module::findOrFail($id);
        $courses = Courses::whereNull('module_id')->orWhere('module_id', $id)->orderBy('created_by', 'desc')->get();
        $selectedCourses = Courses::where('module_id', $id)->pluck('id')->toArray();
        return view('dashboard.addmodule', compact('action', 'module', 'courses', 'selectedCourses'));
    }
    public function deleteModule($id)
    {
        $user = auth()->user();
        $success = false;
        if ($user->role == 'admin') {
            Courses::where('module_id', $id)->delete();
            Module::find($id)->delete();
            $success = true;
        }
        return response()->json([
            'success' => $success
        ]);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (isset($request->imageExist)) {
            $image_require = '';
        } else {
            $image_require = 'required|';
        }
        $request->validate([
            'name' => 'required',
            'image' => $image_require . 'image',
        ]);
        $module = Module::find($id);
        $module->name = $request->name;
        if ($request->image) {
            unlink('images/modules/' . $module->image);
            $file_extension = $request->image->getClientOriginalExtension();
            $file_name = time() . '.' . $file_extension;
            $path = 'images/modules';
            $request->image->move($path, $file_name);
            $module->image = $file_name;
        }

        $module->save();

        $courses = Courses::where('module_id', $id)->get();
        foreach ($courses as $course) {
            $selectedCourse = Courses::find($course->id);
            $selectedCourse->module_id = null;
            $selectedCourse->save();
        }
        $request->collect('courses')->each(function ($cid) use ($module) {
            $course = Courses::find($cid);
            $course->module_id = $module->id;
            $course->save();
        });

        return redirect()->back()->with('success', 'Module is updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
