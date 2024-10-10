<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;


class BannerController extends Controller
{

    public function index()
    {
        $banners = Banner::orderBy('arrange')->get();
        return view('dashboard.banner.index', ['banners' => $banners]);
    }

    public function create()
    {
        return view('banners.create');
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:banners|max:100',
            // 'name_ar' => 'required|unique:categories|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'boolean',
            'arrange' => 'integer',
            'url' => 'nullable|url',
        ], [
            // 'name_en.required' => 'يرجى إدخال اسم الاعلان باللغة الإنجليزية',
            // 'name_en.unique' => 'اسم الاعلان باللغة الإنجليزية مُسجل مسبقًا',
            // 'name_en.max' => 'يجب ألا يتجاوز اسم الاعلان باللغة الإنجليزية 100 حرف',
            'name.required' => 'يرجى إدخال اسم الاعلان باللغة العربية',
            'name.unique' => 'اسم الاعلان باللغة العربية مُسجل مسبقًا',
            'name.max' => 'يجب ألا يتجاوز اسم الاعلان باللغة العربية 100 حرف',
            'image.image' => 'يرجى اختيار صورة صالحة',
            'image.mimes' => 'صيغ الصور المدعومة هي: jpeg, png, jpg, gif, svg',
            'status.boolean' => 'قيمة حالة الاعلان يجب أن تكون صحيحة أو خاطئة',
            'arrange.integer' => 'قيمة ترتيب الاعلان يجب أن تكون عددًا صحيحًا',
            'url.url' => 'لا بد أن يكون اللينك رابطا صحيحا',
        ]);

        if ($validator->fails()) {
            session()->flash('delete', 'لم يتم حفظ الاعلان بسبب مشكله ما');

            return redirect()->back()->withErrors($validator)->withInput();
        }
        if($request->hasFile('image')){
            $file_extension = $request->image->getClientOriginalExtension();
            $file_name = time() . '.' . $file_extension;
            $path = 'images/courses';
            $request->image->move($path, $file_name);
        }else{
            $file_name = null;
        }
        $banner = new Banner;
        // $banner->name_en = $request->input('name_en');
        $banner->name = $request->input('name');
        $banner->type = $request->input('type');
        $banner->url = $request->input('url');
        $banner->image =  $file_name;
        $banner->status = $request->input('status', true);
        $banner->arrange = $request->input('arrange', 1);
        $banner->save();
        session()->flash('Add', 'تم اضافة الاعلان بنجاح ');

        return redirect()->route('banners')->with('success', 'لآanner created successfully');
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



        $banner = Banner::find($categoryId);

        if ($banner) {
            // Update the status field
            $banner->status = $status;
            $banner->save();

            return response()->json(['success' => true, 'message' => 'banner status  updated successfully']);
        }

        return response()->json(['success' => false, 'message' => 'banner not found']);
    }



    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // 'name_en' => 'required|max:100|unique:categories,name_en,' . $request->id . ',id',
            'name' => 'required|max:100|unique:banners,name,' . $request->id . ',id',
            'image' => 'nullable|image',
            'status' => 'boolean',
            'arrange' => 'integer',
            'url' => 'nullable|url',
        ], [
            // 'name_en.required' => 'يرجى إدخال اسم الاعلان باللغة الإنجليزية',
            // 'name_en.max' => 'يجب أن يكون طول اسم الاعلان باللغة الإنجليزية حتى 100 حرف',
            // 'name_en.unique' => 'اسم الاعلان باللغة الإنجليزية مسجل بالفعل',
            'name.required' => 'يرجى إدخال اسم الاعلان باللغة العربية',
            'name.max' => 'يجب أن يكون طول اسم الاعلان باللغة العربية حتى 100 حرف',
            'name.unique' => 'اسم الاعلان باللغة العربية مسجل بالفعل',
            'image.image' => 'يجب أن تكون الصورة من نوع صورة',
            'status.boolean' => 'حالة الاعلان يجب أن تكون صحيحة أو خاطئة',
            'arrange.integer' => 'الترتيب يجب أن يكون عددًا صحيحًا',
            'url.url' => 'لا بد أن يكون اللينك رابطا صحيحا',
        ]);


        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $banner = Banner::findOrFail($request->id);

        $data = $request->except(['_token', '_method']);

        if ($request->hasFile('image')) {
            $file_extension = $request->image->getClientOriginalExtension();
            $file_name = time() . '.' . $file_extension;
            $path = 'images/courses';
            $request->image->move($path, $file_name);

            $data['image'] = $file_name;
        }

        $banner->update($data);
        session()->flash('Add', 'تم تحديث بيانات القسم بنجاح ');
        return redirect()->route('banners')->with('success', 'Category updated successfully');
    }

    public function destroy(Request $request)
    {
        $category = Banner::find($request->id);

        // Delete the associated image
        // $this->deleteImage($category->image);

        // Delete the category
        $category->delete();
        session()->flash('delete', 'تم حذف القسم ');
        return redirect()->route('banners')->with('success', 'Category deleted successfully');
    }
}