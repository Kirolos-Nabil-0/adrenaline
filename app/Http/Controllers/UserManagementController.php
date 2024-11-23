<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    public function index(Request $request){
        $users = User::whereNull('role')->get();
        return view('dashboard.users.index', compact('users'));
    }

    public function change_user_role(Request $request, User $user){
        $request->validate([
            'role' => 'required|string|in:instructor,center'
        ]);

        $user->role = $request->role;
        $user->save();
        
        return redirect()->route('users')->with('success', 'User is now an instructor, you can view his profile in the instructors page');
    }
    
    public function destroy(User $user){
        $user->delete();
        return redirect()->route('users')->with('success', 'تم حذف الطالب بنجاح');
    }
}