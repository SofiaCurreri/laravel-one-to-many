<?php

namespace App\Http\Controllers\Guest;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index() {
        $recent_projects = Project::where('is_published', 1)->orderBy('updated_at', 'DESC')->limit(8)->get();
        return view('guest.home', compact('recent_projects'));
    }
}