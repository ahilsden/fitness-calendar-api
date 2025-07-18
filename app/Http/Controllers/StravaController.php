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
        if (!$request->has("code")) {
            // todo: redirect back to relevant SPA page
            return redirect('/')->withErrors('Auth failed');
        }

        return Strava::downloadActivities($request->code);
    }
}
