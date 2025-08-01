<?php

namespace Tests\Unit\Http\Requests;

use App\Models\Activity;
use Generator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Str;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

class ActivityRequestTest extends TestCase
{
    use RefreshDatabase;

    private string $routePrefix = 'api.activities.';

    #[Test]
    public function user_id_is_required()
    {
        $validatedField = 'user_id';
        $brokenRule = null;

        $activity = Activity::factory()->make([
            $validatedField => $brokenRule
        ]);

        $this->postJson(
            route($this->routePrefix . 'store'),
            $activity->toArray()
        )->assertJsonValidationErrors($validatedField);
    }

    #[Test]
    public function startDate_is_required()
    {
        $validatedField = 'start_date';
        $brokenRule = null;

        $activity = Activity::factory()->make([
            $validatedField => $brokenRule
        ]);

        $this->postJson(
            route($this->routePrefix . 'store'),
            $activity->toArray()
        )->assertJsonValidationErrors($validatedField);
    }

    #[Test]
    #[DataProvider('startDateDataProvider')]
    public function startDate_should_be_formatted_correctly(string $brokenRule)
    {
        $validatedField = 'start_date';

        $activity = Activity::factory()->make([
            $validatedField => $brokenRule
        ]);

        $this->postJson(
            route($this->routePrefix . 'store'),
            $activity->toArray()
        )->assertJsonValidationErrors($validatedField);
    }

    public static function startDateDataProvider(): Generator
    {
        yield ['2025-5-1'];
        yield ['2025-05-01 00:00:00'];
    }

    #[Test]
    public function type_is_required()
    {
        $validatedField = 'type';
        $brokenRule = null;

        $activity = Activity::factory()->make([
            $validatedField => $brokenRule
        ]);

        $this->postJson(
            route($this->routePrefix . 'store'),
            $activity->toArray()
        )->assertJsonValidationErrors($validatedField);
    }

    #[Test]
    #[DataProvider('typeDataProvider')]
    public function type_must_be_between_2_and_20_characters(string $brokenRule)
    {
        $validatedField = 'type';

        $activity = Activity::factory()->make([
            $validatedField => $brokenRule
        ]);

        $this->postJson(
            route($this->routePrefix . 'store'),
            $activity->toArray()
        )->assertJsonValidationErrors($validatedField);
    }

    #[Test]
    #[DataProvider('typeDataProvider')]
    public function sub_type_1_must_be_between_2_and_20_characters(string $brokenRule)
    {
        $validatedField = 'sub_type_1';

        $activity = Activity::factory()->make([
            $validatedField => $brokenRule
        ]);

        $this->postJson(
            route($this->routePrefix . 'store'),
            $activity->toArray()
        )->assertJsonValidationErrors($validatedField);
    }

    #[Test]
    #[DataProvider('typeDataProvider')]
    public function sub_type_2_must_be_between_2_and_20_characters(string $brokenRule)
    {
        $validatedField = 'sub_type_2';

        $activity = Activity::factory()->make([
            $validatedField => $brokenRule
        ]);

        $this->postJson(
            route($this->routePrefix . 'store'),
            $activity->toArray()
        )->assertJsonValidationErrors($validatedField);
    }

    #[Test]
    #[DataProvider('typeDataProvider')]
    public function sub_type_3_must_be_between_2_and_20_characters(string $brokenRule)
    {
        $validatedField = 'sub_type_3';

        $activity = Activity::factory()->make([
            $validatedField => $brokenRule
        ]);

        $this->postJson(
            route($this->routePrefix . 'store'),
            $activity->toArray()
        )->assertJsonValidationErrors($validatedField);
    }

    public static function typeDataProvider(): Generator
    {
        yield ['a'];
        yield [Str::random(21)];
    }

    #[Test]
    #[DataProvider('numberOfSetsDataProvider')]
    public function number_of_sets_1_must_be_a_positive_integer_between_between_1_and_12(int|float $brokenRule)
    {
        $validatedField = 'number_of_sets_1';

        $activity = Activity::factory()->make([
            $validatedField => $brokenRule
        ]);

        $this->postJson(
            route($this->routePrefix . 'store'),
            $activity->toArray()
        )->assertJsonValidationErrors($validatedField);
    }

    #[Test]
    #[DataProvider('numberOfSetsDataProvider')]
    public function number_of_sets_2_must_be_a_positive_integer_between_between_1_and_12(int|float $brokenRule)
    {
        $validatedField = 'number_of_sets_2';

        $activity = Activity::factory()->make([
            $validatedField => $brokenRule
        ]);

        $this->postJson(
            route($this->routePrefix . 'store'),
            $activity->toArray()
        )->assertJsonValidationErrors($validatedField);
    }

    #[Test]
    #[DataProvider('numberOfSetsDataProvider')]
    public function number_of_sets_3_must_be_a_positive_integer_between_between_1_and_12(int|float $brokenRule)
    {
        $validatedField = 'number_of_sets_3';

        $activity = Activity::factory()->make([
            $validatedField => $brokenRule
        ]);

        $this->postJson(
            route($this->routePrefix . 'store'),
            $activity->toArray()
        )->assertJsonValidationErrors($validatedField);
    }

    public static function numberOfSetsDataProvider(): Generator
    {
        yield 'negative number' => [-1];
        yield 'zero' => [0];
        yield 'greater than 12' => [13];
        yield 'decimal' => [1.1];
    }

    #[Test]
    #[DataProvider('numberOfRepsDataProvider')]
    public function number_of_reps_1_must_be_a_positive_integer_between_between_1_and_1000(int|float $brokenRule)
    {
        $validatedField = 'number_of_reps_1';

        $activity = Activity::factory()->make([
            $validatedField => $brokenRule
        ]);

        $this->postJson(
            route($this->routePrefix . 'store'),
            $activity->toArray()
        )->assertJsonValidationErrors($validatedField);
    }

    #[Test]
    #[DataProvider('numberOfRepsDataProvider')]
    public function number_of_reps_2_must_be_a_positive_integer_between_between_1_and_1000(int|float $brokenRule)
    {
        $validatedField = 'number_of_reps_2';

        $activity = Activity::factory()->make([
            $validatedField => $brokenRule
        ]);

        $this->postJson(
            route($this->routePrefix . 'store'),
            $activity->toArray()
        )->assertJsonValidationErrors($validatedField);
    }

    #[Test]
    #[DataProvider('numberOfRepsDataProvider')]
    public function number_of_reps_3_must_be_a_positive_integer_between_between_1_and_1000(int|float $brokenRule)
    {
        $validatedField = 'number_of_reps_3';

        $activity = Activity::factory()->make([
            $validatedField => $brokenRule
        ]);

        $this->postJson(
            route($this->routePrefix . 'store'),
            $activity->toArray()
        )->assertJsonValidationErrors($validatedField);
    }

    public static function numberOfRepsDataProvider(): Generator
    {
        yield 'negative number' => [-1];
        yield 'zero' => [0];
        yield 'greater than 1000' => [1001];
        yield 'decimal' => [1.1];
    }

    #[Test]
    #[DataProvider('weightDataProvider')]
    public function weight_1_must_be_a_positive_number_between_1_and_1000_up_to_2_decimal_places(int|float $brokenRule)
    {
        $validatedField = 'weight_1';

        $activity = Activity::factory()->make([
            $validatedField => $brokenRule
        ]);

        $this->postJson(
            route($this->routePrefix . 'store'),
            $activity->toArray()
        )->assertJsonValidationErrors($validatedField);
    }

    #[Test]
    #[DataProvider('weightDataProvider')]
    public function weight_2_must_be_a_positive_number_between_1_and_1000_up_to_2_decimal_places(int|float $brokenRule)
    {
        $validatedField = 'weight_2';

        $activity = Activity::factory()->make([
            $validatedField => $brokenRule
        ]);

        $this->postJson(
            route($this->routePrefix . 'store'),
            $activity->toArray()
        )->assertJsonValidationErrors($validatedField);
    }

    #[Test]
    #[DataProvider('weightDataProvider')]
    public function weight_3_must_be_a_positive_number_between_1_and_1000_up_to_2_decimal_places(int|float $brokenRule)
    {
        $validatedField = 'weight_3';

        $activity = Activity::factory()->make([
            $validatedField => $brokenRule
        ]);

        $this->postJson(
            route($this->routePrefix . 'store'),
            $activity->toArray()
        )->assertJsonValidationErrors($validatedField);
    }

    public static function weightDataProvider(): Generator
    {
        yield 'negative number' => [-1];
        yield 'zero' => [0];
        yield 'greater than 1000' => [1001];
        yield 'number to 3 decimal places' => [1.123];
    }

    #[Test]
    #[DataProvider('distanceDataProvider')]
    public function distance_must_be_a_positive_number_between_1_and_1000000_up_to_2_decimal_places(int|float $brokenRule)
    {
        $validatedField = 'distance';

        $activity = Activity::factory()->make([
            $validatedField => $brokenRule
        ]);

        $this->postJson(
            route($this->routePrefix . 'store'),
            $activity->toArray()
        )->assertJsonValidationErrors($validatedField);
    }

    public static function distanceDataProvider(): Generator
    {
        yield 'negative number' => [-1];
        yield 'zero' => [0];
        yield 'greater than a million' => [1000001];
        yield 'number to 3 decimal places' => [1.123];
    }
}
