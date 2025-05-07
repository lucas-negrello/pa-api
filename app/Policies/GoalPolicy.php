<?php

namespace App\Policies;

use App\Models\Goal;
use App\Models\User;
use App\Models\UserUser;

class GoalPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if(Goal::where('user_id', $user->id)->exists()){
            return true;
        }
        $permission = UserUser::where('granted_user_id', $user->id)
            ->where('resource_type', Goal::class)
            ->where('permission_id', function ($query) {
                $query->select('id')
                    ->from('permissions')
                    ->where('name', 'view-any-goal');
            })
            ->exists();

        if ($permission) return true;

        return false;

    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Goal $goal): bool
    {
        if($user->id === $goal->user_id){
            return true;
        }

        $permission = UserUser::where('granted_user_id', $user->id)
        ->where('resource_type', Goal::class)
        ->where('resource_id', $goal->id)
        ->where('permission_id', function ($query) {
            $query->select('id')
                ->from('permissions')
                ->where('name', 'view-goal');
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

        return $user->hasPermission('create-goal');

    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Goal $goal): bool
    {

        if($user->id === $goal->user_id){
            return true;
        }
        $permission = UserUser::where('granted_user_id', $user->id)
            ->where('resource_type', Goal::class)
            ->where('resource_id', $goal->id)
            ->where('permission_id', function ($query) {
                $query->select('id')
                    ->from('permissions')
                    ->where('name', 'update-goal');
            })
            ->exists();

        if ($permission) return true;

        return false;

    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Goal $goal): bool
    {
        if($user->id === $goal->user_id){
            return true;
        }
        $permission = UserUser::where('granted_user_id', $user->id)
            ->where('resource_type', Goal::class)
            ->where('resource_id', $goal->id)
            ->where('permission_id', function ($query) {
                $query->select('id')
                    ->from('permissions')
                    ->where('name', 'delete-goal');
            })
            ->exists();

        if ($permission) return true;

        return false;

    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Goal $goal): bool
    {
        return $user->hasPermission('restore-goal');

    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Goal $goal): bool
    {
        return $user->hasPermission('force-delete-goal');

    }
}
