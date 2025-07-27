<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Http;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class StravaTest extends TestCase
{
    #[Test]
    public function can_get_activities_from_strava(): void
    {
        $stravaOauthUrl = "https://www.strava.com/oauth/token";
        $stravaActivitiesUrl = "https://www.strava.com/api/v3/athlete/activities";

        // todo fake Http calls and assert activity json data

        $response = $this->json(
            'GET',
            route('web.strava.handleCallback'),
            ["code" => "exchange_code1234"]
        );

        $this->assertEquals(200, $response->status());

        // todo tests for differenct redirects
        // i.e. $this->assertEquals(302, $response->status());
    }
}
