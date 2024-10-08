<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InsController extends Controller
{
    public function index(Request $request){
        if($request->ajax()){
            $users=User::where('role','<>','admin')->orWhereNull('role')->get();
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
}
