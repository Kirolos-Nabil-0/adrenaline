<?php

namespace App\Http\Controllers;

use App\Models\College;
use App\Models\University;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CollegeController extends Controller
{
    public function index()
    {
        $universities = University::all();
        $colleges = College::all();

        return view('dashboard.college.index', compact('universities', 'colleges'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:100',


        ], [
            'name.required' => 'يرجى إدخال اسم الفئة باللغة الإنجليزية',
            'name.unique' => 'اسم الفئة باللغة الإنجليزية مُسجل مسبقًا',

        ]);

        if ($validator->fails()) {
            session()->flash('delete', 'لم يتم حفظ بسبب مشكله ما');

            return redirect()->back()->withErrors($validator)->withInput();
        }
        $file_extension = $request->image->getClientOriginalExtension();
        $file_name = time() . '.' . $file_extension;
        $path = 'images/courses';
        $request->image->move($path, $file_name);
        $color = new College;
        $color->name = $request->input('name');
        $color->university_id = $request->input('university_id');
        $color->image =  $file_name;
        $color->save();
        session()->flash('Add', 'تم الاضافه بنجاح ');
        return back();
    }


    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:100',
            'image' => 'nullable|image',
        ], [
            'name.required' => 'يرجى إدخال اسم الفئة باللغة الإنجليزية',
            'name.max' => 'يجب أن يكون طول اسم الفئة باللغة الإنجليزية حتى 100 حرف',

        ]);


        if ($validator->fails()) {
            session()->flash('delete', 'لم يتم حفظ بسبب مشكله ما');
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $color = College::findOrFail($request->id);
        $data = $request->except(['_token', '_method']);
        $color->name = $data['name'];
        if ($request->hasFile('image')) {
            $file_extension = $request->image->getClientOriginalExtension();
            $file_name = time() . '.' . $file_extension;
            $path = 'images/courses';
            $request->image->move($path, $file_name);
            $color->image = $file_name;
        }
        $color->save();
        session()->flash('Add', 'تم تحديث البيانات  بنجاح ');
        return back();
    }


    public function destroy(Request $request)
    {
        $color = College::find($request->id);
        $color->delete();
        session()->flash('delete', 'تم الحذف  ');
        return back();
    }
    public function updateStatusBanner(Request $request)
    {
        $isToggleOnString = (string) $request->isToggleOn;
        $status = true;
        $categoryId = $request->input('categoryId');
        if ($isToggleOnString == "true") {
            $status = true;
        } else {
            $status = false;
        }
        $banner = College::find($categoryId);
        if ($banner) {
            $banner->status = $status;
            $banner->save();
            return response()->json(['success' => true, 'message' => 'banner status  updated successfully']);
        }

        return response()->json(['success' => false, 'message' => 'banner not found']);
    }
}
