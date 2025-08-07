<?php

namespace App\Services;

use Exception;
use Illuminate\Http\Client\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Strava
{
    private $stravaOauthUri = 'https://www.strava.com/oauth';
    private $stravaUri = 'https://www.strava.com/api/v3';

    private $stravaClientId;
    private $stravaSecretId;
    private $stravaRedirectUri;

    public function __construct(
        string $stravaClientId,
        string $stravaSecretId,
        string $stravaRedirectUri,
    ) {
        $this->stravaClientId = $stravaClientId;
        $this->stravaSecretId = $stravaSecretId;
        $this->stravaRedirectUri = $stravaRedirectUri;
    }

    public function getAuthCode(
        string $scope = 'read_all,profile:read_all,activity:read_all'
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

    public function getLatestActivities(string $authCode): array
    {
        try {
            if (env('DATA_MODE') !== 'hardcoded') {
                $tokenData = $this->getAthleteWithTokens($authCode);
                $activities = $this->getActivities($tokenData['access_token']);
            } else {
                $activities = File::json(base_path('database/hardcodedData/stravaActivities.json'));
            }

            return $activities;
        } catch (Exception $error) {
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

        $this->throwError($response);

        return [];
    }

    private function getActivities(string $token): array
    {
        $url = "{$this->stravaUri}/athlete/activities";

        $response = Http::withToken($token)->get($url);
        if ($response->ok()) {
            return json_decode($response->getBody()->getContents(), true);
        }

        $this->throwError($response);

        return [];
    }

    private function throwError(Response $response): void
    {
        $statusCode = $response->getStatusCode();
        $jsonResponse = $response->json();
        $errorMessage = $jsonResponse['message'] ?? 'Strava Service not available';

        Log::error(
            'Error getting Strava activities',
            [
                'status' => $statusCode,
                'message' => $errorMessage
            ]
        );

        throw new Exception("Strava API error: {$statusCode}: {$errorMessage}");
    }
}
