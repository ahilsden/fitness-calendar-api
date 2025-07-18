<?php

namespace App\Http\Controllers;

use App\Facades\Strava;
use Illuminate\Http\Request;

class StravaController extends Controller
{
    public function redirectToStrava()
    {
        return Strava::getAuthCode();
    }

    public function handleCallback(request $request)
    {
        return "Callback function...";
    }
}
