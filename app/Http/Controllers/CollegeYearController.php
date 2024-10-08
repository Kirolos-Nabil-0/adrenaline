<?php

namespace App\Http\Controllers;

use App\Models\College;
use App\Models\CollegeYear;
use App\Models\Semester;
use App\Models\University;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CollegeYearController extends Controller
{
    public function index()
    {
        $universities = University::all();
        $collegeyears = CollegeYear::all();

        return view('dashboard.collegeyear.index', compact('universities', 'collegeyears'));
    }


    public function collegeById(Request $request)
    {

        $colleges = College::where('university_id', $request->id)->get();
        return response()->json($colleges, 200);
    }

    public function collegeYearById(Request $request)
    {

        $collegesYears = CollegeYear::where('college_id', $request->id)->get();
        return response()->json($collegesYears, 200);
    }
    public function store(Request $request)
    {
        // return $request;
        $validator = Validator::make($request->all(), [
            'year_number' => 'required|max:100',


        ], [
            'year_number.required' => 'يرجى إدخال اسم الفئة باللغة الإنجليزية',
            'year_number.unique' => 'اسم الفئة باللغة الإنجليزية مُسجل مسبقًا',

        ]);

        if ($validator->fails()) {
            session()->flash('delete', 'لم يتم حفظ بسبب مشكله ما');

            return redirect()->back()->withErrors($validator)->withInput();
        }
        $collegeYear = new CollegeYear;
        $collegeYear->year_number = $request->input('year_number');
        $collegeYear->college_id = $request->input('college_id');
        $collegeYear->save();


        $semester = new Semester;
        $semester->college_year_id = $collegeYear->id;
        $semester->semester_name = "Semester first";
        $semester->save();

        $semester = new Semester;
        $semester->college_year_id = $collegeYear->id;
        $semester->semester_name = "Semester second";
        $semester->save();


        session()->flash('Add', 'تم الاضافه بنجاح');
        return back();
    }


    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'year_number' => 'required|max:100',
        ], [
            'year_number.required' => 'يرجى إدخال اسم الفئة باللغة الإنجليزية',
            'year_number.max' => 'يجب أن يكون طول اسم الفئة باللغة الإنجليزية حتى 100 حرف',

        ]);


        if ($validator->fails()) {
            session()->flash('delete', 'لم يتم حفظ بسبب مشكله ما');
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $color = CollegeYear::findOrFail($request->id);
        $data = $request->except(['_token', '_method']);
        $color->year_number = $data['year_number'];
        $color->save();
        session()->flash('Add', 'تم تحديث البيانات  بنجاح ');
        return back();
    }


    public function destroy(Request $request)
    {
        try {
            $collegeYear = CollegeYear::find($request->id);

            if ($collegeYear) {
                // Delete related semesters
                $collegeYear->semesters()->delete();

                // Delete the college year
                $collegeYear->delete();

                session()->flash('delete', 'تم الحذف');
            } else {
                session()->flash('delete', 'السنه غير موجودة');
            }
            return back();
        } catch (\Throwable $th) {
            session()->flash('delete', 'لا يمكن حذف هذه السنه لانها تحتوي علي دورات تعليمية متعلقة بها');
            return back();
        }
    }
}
