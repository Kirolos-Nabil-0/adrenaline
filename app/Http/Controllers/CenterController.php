<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class CenterController extends Controller
{
    public function index(Request $request){
        if ($request->ajax()) {
            $users = User::where('role', '=','center')->get();
            return datatables()->of($users)
                ->addIndexColumn()
                ->make(true);
        }
        return view('dashboard.centers');
    }

    public function create(){
        return view("dashboard.create_center");
    }
    public function store(Request $request){

        $request->validate([
            'name' => ['required', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'min:8'],
        ], [
            'name.required' => 'الاسم مطلوب',
            'email.required' => 'البريد الالكتروني مطلوب',
            'email.unique' => 'البريد الالكتروني موجود من قبل',
            'password.required' => 'كلمة المرور مطلوبه',
            'password.min' => 'كلمة المرور يجب ألا تقل عن 8 حروف'
        ]);
        User::create([
            'firstname' => $request->name,
            'lastname' => 'Center',
            'email' => $request->email,
            'country' => 'Egypt',
            'password' => Hash::make($request->password),
            'device_token' => null,
            'role' => 'center',
            "email_verified_at" => now(),
        ]);
        return back()->with('success', 'Center Created Successfully');
    }

}