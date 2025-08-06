<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class StravaTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function can_get_and_store_activities_from_strava(): void
    {
        $stravaOauthUrl = "https://www.strava.com/oauth/token";
        $stravaActivitiesUrl = "https://www.strava.com/api/v3/athlete/activities";

        Http::fake([
            $stravaOauthUrl => Http::response(['access_token' => 'access1234'], 200),
        ]);

        Http::fake([
            $stravaActivitiesUrl => Http::response(
                [
                    'activity1' => [
                        'id' => 1,
                        'start_date' => '2018-10-29',
                        'name' => 'Morning Run',
                        'type' => 'Run',
                        'distance' => 103264,
                        'average_heartrate' => 115,
                        'max_heartrate' => 153,
                        'moving_time' => 500,
                        'elapsed_time' => 500,
                        'map' => ['summary_polyline' => 'plotting1234']
                    ],
                    'activity2' => [
                        'id' => 2,
                        'start_date' => '2018-10-29',
                        'name' => 'Morning Run',
                        'type' => 'Run',
                        'distance' => 103264,
                        'average_heartrate' => 115,
                        'max_heartrate' => 153,
                        'moving_time' => 500,
                        'elapsed_time' => 500,
                        'map' => ['summary_polyline' => 'plotting5678']
                    ],
                ],
                200
            ),
        ]);

        $response = $this->json(
            'GET',
            route('web.strava.handleCallback'),
            ["code" => "exchange_code1234"]
        );

        $response->assertCreated();
    }
}
