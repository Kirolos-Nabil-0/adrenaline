<?php

namespace App\Http\Controllers;

use App\Models\University;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UniversityController extends Controller
{
    public function index()
    {
        $universities = University::all();


        return view('dashboard.universty.index', compact('universities'));
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:universities|max:100',
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
        $color = new University;
        $color->name = $request->input('name');
        $color->image =  $file_name;
        $color->save();
        session()->flash('Add', 'تم الاضافه بنجاح ');

        return back();
    }


    public function update(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:100|unique:universities,name,' . $request->id . ',id',
        ], [
            'name.required' => 'يرجى إدخال اسم الفئة باللغة الإنجليزية',
            'name.max' => 'يجب أن يكون طول اسم الفئة باللغة الإنجليزية حتى 100 حرف',
        ]);


        if ($validator->fails()) {
            session()->flash('delete', 'لم يتم حفظ بسبب مشكله ما');
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $color = University::findOrFail($request->id);
        $data = $request->except(['_token', '_method']);
        if ($request->hasFile('image')) {

            $file_extension = $request->image->getClientOriginalExtension();
            $file_name = time() . '.' . $file_extension;
            $path = 'images/courses';
            $request->image->move($path, $file_name);
            $color->image = $file_name;
        }
        $color->name = $data['name'];

        $color->save();
        session()->flash('Add', 'تم تحديث البيانات  بنجاح ');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $color = University::find($request->id);
        $color->delete();
        session()->flash('delete', 'تم الحذف  ');
        return back();
    }
}
