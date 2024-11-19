<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;
use App\Models\UserUser;
use Illuminate\Auth\Access\Response;

class TaskPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if(Task::where('user_id', $user->id)->exists()){
            return true;
        }
        $permission = UserUser::where('granted_user_id', $user->id)
            ->where('resource_type', Task::class)
            ->where('permission_id', function ($query) {
                $query->select('id')
                    ->from('permissions')
                    ->where('name', 'view-any-task');
            })
            ->exists();

        if ($permission) return true;

        return false;

    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Task $task): bool
    {
        if($user->id === $task->user_id){
            return true;
        }

        $permission = UserUser::where('granted_user_id', $user->id)
            ->where('resource_type', Task::class)
            ->where('resource_id', $task->id)
            ->where('permission_id', function ($query) {
                $query->select('id')
                    ->from('permissions')
                    ->where('name', 'view-task');
            })
            ->exists();

        if ($permission) {
            return true;
        }

        return false;

    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermission('create-task');

    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Task $task): bool
    {
        if($user->id === $task->user_id){
            return true;
        }
        $permission = UserUser::where('granted_user_id', $user->id)
            ->where('resource_type', Task::class)
            ->where('resource_id', $task->id)
            ->where('permission_id', function ($query) {
                $query->select('id')
                    ->from('permissions')
                    ->where('name', 'update-task');
            })
            ->exists();

        if ($permission) return true;

        return false;

    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Task $task): bool
    {
        if($user->id === $task->user_id){
            return true;
        }
        $permission = UserUser::where('granted_user_id', $user->id)
            ->where('resource_type', Task::class)
            ->where('resource_id', $task->id)
            ->where('permission_id', function ($query) {
                $query->select('id')
                    ->from('permissions')
                    ->where('name', 'delete-task');
            })
            ->exists();

        if ($permission) return true;

        return false;


    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Task $task): bool
    {
        return $user->hasPermission('restore-task');

    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Task $task): bool
    {
        return $user->hasPermission('force-delete-task');

    }
}
