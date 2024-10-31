<?php

namespace App\Http\Controllers;

use App\Models\Courses;
use App\Models\User;
use Illuminate\Http\Request;

class StatsController extends Controller{
    public function index(){
        $data['total_students'] = User::whereNull('role')->count();
        $data['total_courses_visit'] = Courses::sum('students');
        return response()->json($data);
    }
}