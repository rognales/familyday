<?php

namespace App\Http\Controllers;

class AttendanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('event.index');
    }
}
