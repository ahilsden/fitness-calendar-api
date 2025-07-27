<?php

namespace App\Http\Controllers;

use App\Facades\Strava;
use Illuminate\Http\Request;
use App\Services\StravaActivities;
use Illuminate\Http\RedirectResponse;

class StravaController extends Controller
{
    private $stravaActivities;

    public function __construct(StravaActivities $stravaActivities)
    {
        $this->stravaActivities = $stravaActivities;
    }

    public function redirectToStrava(): RedirectResponse
    {
        return Strava::getAuthCode();
    }

    public function handleCallback(request $request)
    {
        if (!$request->has("code")) {
            // todo: redirect back to relevant SPA page
            return redirect('/')->withErrors('Auth failed');
        }

        return $this->store($request->code);
    }

    public function store(string $authCode)
    {
        $latestActivities = Strava::getLatestActivities($authCode);

        return $this->stravaActivities->saveActivities($latestActivities);
    }
}
