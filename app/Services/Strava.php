<?php

namespace App\Services;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Http;

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
        $url = "{$this->stravaOauthUri}/token";
        $config = [
            'client_id' => $this->stravaClientId,
            'client_secret' => $this->stravaSecretId,
            'code' => $authCode,
            'grant_type' => 'authorization_code'
        ];
        $response = Http::post($url, $config);

        return json_decode($response->getBody(), true);
    }
}
