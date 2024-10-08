<?php

namespace App\Http\Controllers;

use App\Models\College;
use App\Models\CollegeYear;
use App\Models\Semester;
use App\Models\University;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SemesterController extends Controller
{
    public function index()
    {
        $universities = University::all();
        $collegeyears = CollegeYear::all();
        $semesters = Semester::all();
        return view('dashboard.semester.index', compact('universities', 'collegeyears', 'semesters'));
    }


    public function collegeById(Request $request)
    {

        $colleges = College::where('university_id', $request->id)->get();
        return response()->json($colleges, 200);
    }

    public function store(Request $request)
    {
        // return $request;
        $validator = Validator::make($request->all(), [
            'year_number' => 'required|unique:college_years|max:100',


        ], [
            'year_number.required' => 'يرجى إدخال اسم الفئة باللغة الإنجليزية',
            'year_number.unique' => 'اسم الفئة باللغة الإنجليزية مُسجل مسبقًا',

        ]);

        if ($validator->fails()) {
            session()->flash('delete', 'لم يتم حفظ بسبب مشكله ما');

            return redirect()->back()->withErrors($validator)->withInput();
        }
        $color = new Semester;
        $color->year_number = $request->input('year_number');
        $color->college_id = $request->input('college_id');
        $color->save();
        session()->flash('Add', 'تم الاضافه بنجاح ');
        return back();
    }


    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'year_number' => 'required|max:100|unique:college_years,year_number,' . $request->id . ',id',
        ], [
            'year_number.required' => 'يرجى إدخال اسم الفئة باللغة الإنجليزية',
            'year_number.max' => 'يجب أن يكون طول اسم الفئة باللغة الإنجليزية حتى 100 حرف',

        ]);


        if ($validator->fails()) {
            session()->flash('delete', 'لم يتم حفظ بسبب مشكله ما');
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $color = Semester::findOrFail($request->id);
        $data = $request->except(['_token', '_method']);
        $color->year_number = $data['year_number'];
        $color->save();
        session()->flash('Add', 'تم تحديث البيانات  بنجاح ');
        return back();
    }


    public function destroy(Request $request)
    {
        $color = Semester::find($request->id);
        $color->delete();
        session()->flash('delete', 'تم الحذف  ');
        return back();
    }
}
