<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use App\Http\Requests\StoreGoalRequest;
use App\Http\Requests\UpdateGoalRequest;
use App\Models\Goal;

class GoalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $goals = Goal::all();
        return response()->json($goals);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGoalRequest $request)
    {
        $goal = Goal::create($request->validated());
        return response()->json([
            'message' => 'Goal created',
            'data' => $goal
        ], ResponseAlias::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Goal $goal)
    {
        return response()->json([
            'message' => 'Goal retrieved',
            'data' => $goal
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGoalRequest $request, Goal $goal)
    {
        $goal->update($request->validated());
        return response()->json([
            'message' => 'Goal updated',
            'data' => $goal
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Goal $goal)
    {
        $goal->delete();
        return response()->json([
            'message' => 'Goal deleted',
            'data' => $goal
        ]);
    }
}
