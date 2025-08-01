<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActivityRequest;
use App\Models\Activity;
use Illuminate\Http\JsonResponse;

class ActivityController extends Controller
{
    public function index()
    {
        // todo
        return "Getting internally created activities";
    }

    public function store(ActivityRequest $request): JsonResponse
    {
        $activity = Activity::create($request->toArray());

        return response()->json($activity, 201);
    }
}
