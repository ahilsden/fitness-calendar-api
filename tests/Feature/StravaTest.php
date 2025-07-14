<?php

namespace Tests\Feature;

use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class StravaTest extends TestCase
{
    #[Test]
    public function redirect_to_strava_returns_with_a_redirect_response()
    {
        $response = $this->getJson(route('web.strava.redirectToStrava'));
    }
}
