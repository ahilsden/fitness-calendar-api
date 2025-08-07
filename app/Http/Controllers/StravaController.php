<?php

namespace App\Http\Controllers;

use App\Facades\Strava;
use Illuminate\Http\Request;
use App\Services\StravaActivity;
use Illuminate\Http\RedirectResponse;

class StravaController extends Controller
{
    private $stravaActivity;

    public function __construct(StravaActivity $stravaActivity)
    {
        $this->stravaActivity = $stravaActivity;
    }

    public function redirectToStrava(): RedirectResponse
    {
        return Strava::getAuthCode();
    }

    public function handleCallback(Request $request)
    {
        if (!$request->has('code')) {
            // todo: redirect back to relevant SPA page
            return redirect('/')->withErrors('Auth failed');
        }

        return $this->store($request->code);
    }

    public function store(string $authCode)
    {
        $latestActivities = Strava::getLatestActivities($authCode);
        $response = $this->stravaActivity->saveActivities($latestActivities);

        if ($response['success'] === false) {
            return response()->json(['error' => $response['message']], 422);
        }

        return response()->json($response['recentActivities'], 201);
    }
}
