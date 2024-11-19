<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', Task::class);
        $user = auth()->user();

        $tasks = Task::where('user_id', $user->id)->get();

        $sharedTasks = Task::whereHas('sharedWith', function ($query) use ($user) {
            $query->where('granted_user_id', $user->id)
                ->where('resource_type', Task::class);
        })->get();

        return response()->json([
            'tasks' => $tasks,
            'shared_tasks' => $sharedTasks
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        Gate::authorize('create', Task::class);

        $task = Task::create($request->validated());
        return response()->json([
            'message' => 'Task created successfully',
            'data' => $task,
        ], ResponseAlias::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        Gate::authorize('view', $task);

        return response()->json([
            'message' => 'Task retrieved successfully',
            'data' => $task,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        Gate::authorize('update', $task);

        $task->update($request->validated());
        return response()->json([
            'message' => 'Task updated successfully',
            'data' => $task,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        Gate::authorize('destroy', $task);

        $task->delete();
        return response()->json([
            'message' => 'Task deleted successfully',
            'data' => $task,
        ]);
    }
}
