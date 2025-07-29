<?php

namespace App\Services;

use App\Models\StravaActivity;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class StravaActivities
{
    // Type hint array of models?
    public function saveActivities(array $activities): array
    {
        $mappedActivities = $this->mapActivities($activities);

        try {
            $recentActivities = $this->storeActivities($mappedActivities);
        } catch (QueryException $error) {
            $returnErrorMessage = $error->getMessage();

            Log::error(
                'Error saving Strava activities',
                [
                    'message' => $error->getMessage()
                ]
            );

            $returnErrorMessage = "SQL error: Strava activity(ies) not persisted";

            return [
                'success' => false,
                'message' => $returnErrorMessage
            ];
        }

        return $recentActivities;
    }

    // todo: Once refactored, add code with explanation to readme file
    private function mapActivities(array $activities): array
    {
        // $dataStatisticsToBeMapped = Schema::getColumnListing('strava_activities');

        $dataStatisticsToBeMapped = [
            "id",
            "strava_id",
            "start_date",
            "name",
            "type",
            "distance",
            "average_heartrate",
            "max_heartrate",
            "moving_time",
            "elapsed_time",
            "map_polyline",
            "start_latlng",
            "end_latlng",
            "created_at",
            "updated_at"
        ];

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
