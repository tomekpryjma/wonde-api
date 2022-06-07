<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function __construct()
    {
        $this->middleware('onlyCurrentEmployee');
    }

    public function upcomingClasses(Request $request)
    {
        // employee is passed in via the middleware.
        return view('upcoming-classes', [
            'employee' => $request->employee
        ]);
    }
}
