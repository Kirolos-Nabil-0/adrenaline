<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class InsController extends Controller
{
    public function index(Request $request){
        if($request->ajax()){
            $user = User::find(Auth::id());
            if($user->role == 'admin'){
                $users=User::where('role','=', 'instructor')->orWhereNull('role')->get();
            }else if($user->role == 'center'){
                $users=User::where('role','=', 'instructor')->where('center_id', $user->id)->get();
            }
            return datatables()->of($users)->addIndexColumn()->make(true);
        }
        return view('dashboard.instructors');
    }

    public static function isInstructor()
    {
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
    public function remove_user(Request $request)
    {
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
        return view("dashboard.create_instructor");
    }
    public function store(Request $request){
        $user = User::find(Auth::id());
        
        $request->validate([
            'firstname' => ['required', 'max:255'],
            'lastname' => ['required', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'min:8'],
        ], [
            'firstname.required' => 'الاسم الاول مطلوب',
            'lastname.required' => 'الاسم الثاني مطلوب',
            'email.required' => 'البريد الالكتروني مطلوب',
            'email.unique' => 'البريد الالكتروني موجود من قبل',
            'password.required' => 'كلمة المرور مطلوبه',
            'password.min' => 'كلمة المرور يجب ألا تقل عن 8 حروف'
        ]);
        User::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'country' => 'Egypt',
            'password' => Hash::make($request->password),
            'device_token' => null,
            'role' => 'instructor',
            "email_verified_at" => now(),
            'center_id' => $user->role == 'center' ? $user->id : null
        ]);
        return back()->with('success', 'Instructor Created Successfully');
    }
}