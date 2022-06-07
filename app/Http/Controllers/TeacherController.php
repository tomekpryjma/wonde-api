<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function __construct()
    {
        $this->middleware('onlyCurrentEmployee');
    }

    public function upcomingClasses()
    {
        return view('upcoming-classes');
    }
}
