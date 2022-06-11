<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'onlyCurrentEmployee']);
    }

    public function upcomingClasses(Request $request)
    {
        // employee is passed in via the onlyCurrentEmployee middleware.
        return view('upcoming-classes', [
            'employeeId' => $request->employeeId
        ]);
    }
}
