<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;
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
        Gate::authorize('viewAny', Goal::class);
        $user = auth()->user();

        $goals = Goal::where('user_id', $user->id)->get();

        $sharedGoals = Goal::whereHas('sharedWith', function ($query) use ($user) {
            $query->where('granted_user_id', $user->id)
                ->where('resource_type', Goal::class);
        })->get();

        return response()->json([
            'goals' => $goals,
            'shared_goals' => $sharedGoals
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGoalRequest $request)
    {
        Gate::authorize('create', Goal::class);

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
        Gate::authorize('view', $goal);

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
        Gate::authorize('update', $goal);

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
        Gate::authorize('delete', $goal);

        $goal->delete();
        return response()->json([
            'message' => 'Goal deleted',
            'data' => $goal
        ]);
    }
}
