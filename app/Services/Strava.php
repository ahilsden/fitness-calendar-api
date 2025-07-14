<?php

namespace App\Services;

use GuzzleHttp\ClientInterface;
use Illuminate\Http\RedirectResponse;

class Strava
{
    private $strava_uri = 'https://www.strava.com/api/v3';
    private $strava_oauth_uri = 'https://www.strava.com/oauth';
    private $client;
    private $client_id;
    private $client_secret;
    private $redirect_uri;

    public function __construct(
        ClientInterface $client,
        string $client_id,
        string $client_secret,
        string $redirect_uri
    ) {
        $this->client = $client;
        $this->client_id = $client_id;
        $this->client_secret = $client_secret;
        $this->redirect_uri = $redirect_uri;
    }

    public function getAuthCode(
        string $scope = "read_all,profile:read_all,activity:read_all"
    ): RedirectResponse {
        $query = http_build_query([
            'client_id' => $this->client_id,
            'response_type' => 'code',
            'redirect_uri' => $this->redirect_uri,
            'scope' => $scope,
            'state' => 'strava',
        ]);

        return redirect("{$this->strava_oauth_uri}/authorize?{$query}");
    }
}
