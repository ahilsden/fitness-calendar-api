<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index()
    {
        // todo
        return "Getting internally created activities";
    }

    public function store(Request $request): JsonResponse
    {
        $activity = Activity::create($request->toArray());

        return response()->json($activity, 201);
    }
}
