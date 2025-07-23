<?php

namespace App\Services;

use App\Models\StravaActivity;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class Strava
{
    private $stravaOauthUri = "https://www.strava.com/oauth";
    private $stravaUri = 'https://www.strava.com/api/v3';

    private $stravaClientId;
    private $stravaSecretId;
    private $stravaRedirectUri;

    public function __construct(
        string $stravaClientId,
        string $stravaSecretId,
        string $stravaRedirectUri
    ) {
        $this->stravaClientId = $stravaClientId;
        $this->stravaSecretId = $stravaSecretId;
        $this->stravaRedirectUri = $stravaRedirectUri;
    }

    public function getAuthCode(
        string $scope = "read_all,profile:read_all,activity:read_all"
    ): RedirectResponse {
        $query = http_build_query([
            'client_id' => $this->stravaClientId,
            'response_type' => 'code',
            'redirect_uri' => $this->stravaRedirectUri,
            'scope' => $scope,
            'state' => 'strava',
        ]);

        return redirect("{$this->stravaOauthUri}/authorize?{$query}");
    }

    public function downloadActivities(string $authCode): array
    {
        try {
            if (env("DATA_MODE") !== "hardcoded") {
                $tokenData = $this->getAthleteWithTokens($authCode);
                $activities = $this->getActivities($tokenData["access_token"]);
            } else {
                $activities = File::json(base_path('database/hardcodedData/stravaActivities.json'));
            }

            $mappedActivities = $this->mapActivities($activities);
            $recentActivities = $this->storeActivities($mappedActivities);

            return $recentActivities;
        } catch (Exception $error) {
            if ($error instanceof QueryException) {
                Log::error(
                    'Error attempting to save Strava activities',
                    [
                        'message' => $error->getMessage()
                    ]
                );
            }

            return [
                'success' => false,
                'message' => $error->getMessage()
            ];
        }
    }

    private function getAthleteWithTokens(string $authCode): array
    {
        $url = "{$this->stravaOauthUri}/token";
        $config = [
            'client_id' => $this->stravaClientId,
            'client_secret' => $this->stravaSecretId,
            'code' => $authCode,
            'grant_type' => 'authorization_code'
        ];

        $response = Http::post($url, $config);

        if ($response->ok()) {
            return json_decode($response->getBody(), true);
        }

        $statusCode = $response->getStatusCode();
        $jsonResponse = $response->json();
        $errorMessage = $jsonResponse["message"] ?? "Strava Service not available";

        Log::error(
            'Error getting Strava athlete',
            [
                'status' => $statusCode,
                'message' => $errorMessage
            ]
        );

        throw new Exception("Strava API error: {$statusCode}: {$errorMessage}");
    }

    private function getActivities(string $token): array
    {
        $url = "{$this->stravaUri}/athlete/activities";

        $response = Http::withToken($token)->get($url);

        if ($response->ok()) {
            return json_decode($response->getBody()->getContents(), true);
        }

        $statusCode = $response->getStatusCode();
        $jsonResponse = $response->json();
        $errorMessage = $jsonResponse["message"] ?? "Strava Service not available";

        Log::error(
            'Error getting Strava activities',
            [
                'status' => $statusCode,
                'message' => $errorMessage
            ]
        );

        throw new Exception("Strava API error: {$statusCode}: {$errorMessage}");
    }

    // todo: Once refactored, add code with explanation to readme file
    private function mapActivities(array $activities): array
    {
        $dataStatisticsToBeMapped = Schema::getColumnListing('strava_activities');

        return array_map(function ($activity) use ($dataStatisticsToBeMapped) {
            $activity["strava_id"] = $activity["id"];
            $activity["map_polyline"] = $activity["map"]["summary_polyline"];
            unset($activity["id"]);
            unset($activity["map"]);

            return array_filter($activity, function ($statItem) use ($dataStatisticsToBeMapped) {
                return (in_array($statItem, $dataStatisticsToBeMapped));
            }, ARRAY_FILTER_USE_KEY);
        }, $activities);
    }

    private function storeActivities(array $mappedActivities): array
    {
        $recentActivities = [];

        foreach ($mappedActivities as $mappedActivity) {
            $newActivity = StravaActivity::firstOrCreate(
                ["strava_id" => $mappedActivity["strava_id"]],
                $mappedActivity
            );

            if ($newActivity->wasRecentlyCreated) {
                array_push($recentActivities, $mappedActivity);
            }
        }

        return $recentActivities;
    }
}
