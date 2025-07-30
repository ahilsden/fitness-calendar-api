<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index()
    {
        return "Getting internally created activities";
    }

    public function store(Request $request) {}
}
