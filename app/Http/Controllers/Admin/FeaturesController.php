<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FeaturesController extends Controller
{
    // Display all features
    public function index()
    {
        return view('admin.features.index');
    }

    // Display reports page
    public function reports()
    {
        return view('admin.features.reports');
    }
}
