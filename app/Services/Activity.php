<?php

namespace App\Services;

use App\Models\Activity as ActivityModel;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class Activity
{
    public function save(array $activity)
    {
        try {
            $newActivity = ActivityModel::create($activity);
        } catch (QueryException $error) {

            $returnErrorMessage = $error->getMessage();

            Log::error(
                'Error saving activities',
                [
                    'message' => $error->getMessage()
                ]
            );

            $returnErrorMessage = 'SQL error: new activity(ies) not persisted';

            return [
                'success' => false,
                'message' => $returnErrorMessage
            ];
        }

        return [
            'success' => true,
            'newActivity' => $newActivity
        ];
    }
}
