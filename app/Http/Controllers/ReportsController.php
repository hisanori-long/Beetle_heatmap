<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportsController extends Controller
{
    //
    public function index()
    {
        return view("reports.index");
    }

    public function create()
    {
        return view("reports.create");
    }
}
