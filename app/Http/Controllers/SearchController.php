<?php

namespace App\Http\Controllers;

use App\Models\Courses;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $searchQuery = $request->input('search');
        $data = Courses::where('is_archived', '0')->where('name', 'like', '%' . request('search') . '%')->withCount('users')->get();

        return view('search', compact('data', 'searchQuery'));
    }
}
