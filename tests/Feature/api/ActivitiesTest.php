<?php

namespace Tests\Feature\api;

use App\Models\Activity;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ActivitiesTest extends TestCase
{
    use RefreshDatabase;

    private string $routePrefix = 'api.activities.';

    #[Test]
    public function can_store_an_activity(): void
    {
        $newActivity = Activity::factory()->make();

        $response = $this->postJson(
            route($this->routePrefix . 'store'),
            $newActivity->toArray()
        );

        $response->assertCreated();
        $response->assertJson([
            'user_id' => $newActivity->user_id,
            'start_date' => $newActivity->start_date,
            'type' => $newActivity->type,
            'sub_type_1' => $newActivity->sub_type_1,
            'number_of_sets_1' => $newActivity->number_of_sets_1,
            'number_of_reps_1' => $newActivity->number_of_reps_1,
            'weight_1' => $newActivity->weight_1,
            'distance' => $newActivity->distance
        ]);
        $this->assertDatabaseHas(
            'activities',
            $newActivity->toArray()
        );
    }
}
