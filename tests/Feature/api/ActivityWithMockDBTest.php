<?php

namespace Tests\Feature\api;

use App\Models\Activity;
use Mockery;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ActivityWithMockDBTest extends TestCase
{
    // Not to be run as part of test suite
    public function can_store_an_activity(): void
    {
        $activityData = [
            "user_id" => 1,
            "start_date" => "1944-11-11",
            "type" => "Run",
            "sub_type_1" => "Trail run"
        ];

        $mock = Mockery::mock('alias:' . Activity::class);

        $mock->shouldReceive('create')
            ->once()
            ->with($activityData)->andReturn(new Activity($activityData));

        $response = $this->json(
            'POST',
            route('api.activities.store'),
            $activityData
        );

        $response->assertCreated();
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
