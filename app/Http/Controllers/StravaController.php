<?php

namespace App\Http\Controllers;

use App\Facades\Strava;


class StravaController extends Controller
{
    public function redirectToStrava()
    {
        return Strava::getAuthCode();
    }
}
