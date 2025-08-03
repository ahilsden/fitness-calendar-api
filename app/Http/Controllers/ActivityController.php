<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActivityRequest;
use App\Services\Activity;
use Illuminate\Http\JsonResponse;

class ActivityController extends Controller
{
    private $activity;

    public function __construct(Activity $activity)
    {
        $this->activity = $activity;
    }

    public function index()
    {
        return "Getting internally created activities";
    }

    public function store(ActivityRequest $request): JsonResponse
    {
        $response = $this->activity->save($request->validated());

        if ($response["success"] === false) {
            return response()->json(["error" => $response["message"]], 422);
        }

        return response()->json($response['newActivities'], 201);
    }
}
