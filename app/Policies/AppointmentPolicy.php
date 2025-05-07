<?php

namespace App\Policies;

use App\Models\Appointment;
use App\Models\User;
use App\Models\UserUser;

class AppointmentPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if(Appointment::where('user_id', $user->id)->exists()){
            return true;
        }
        $permission = UserUser::where('granted_user_id', $user->id)
            ->where('resource_type', Appointment::class)
            ->where('permission_id', function ($query) {
                $query->select('id')
                    ->from('permissions')
                    ->where('name', 'view-any-appointment');
            })
            ->exists();

        if ($permission) return true;

        return false;

    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Appointment $appointment): bool
    {
        if($user->id === $appointment->user_id){
            return true;
        }

        $permission = UserUser::where('granted_user_id', $user->id)
            ->where('resource_type', Appointment::class)
            ->where('resource_id', $appointment->id)
            ->where('permission_id', function ($query) {
                $query->select('id')
                    ->from('permissions')
                    ->where('name', 'view-appointment');
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
        return $user->hasPermission('create-appointment');

    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Appointment $appointment): bool
    {

        if($user->id === $appointment->user_id){
            return true;
        }
        $permission = UserUser::where('granted_user_id', $user->id)
            ->where('resource_type', Appointment::class)
            ->where('resource_id', $appointment->id)
            ->where('permission_id', function ($query) {
                $query->select('id')
                    ->from('permissions')
                    ->where('name', 'update-appointment');
            })
            ->exists();

        if ($permission) return true;

        return false;

    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Appointment $appointment): bool
    {
        if($user->id === $appointment->user_id){
            return true;
        }
        $permission = UserUser::where('granted_user_id', $user->id)
            ->where('resource_type', Appointment::class)
            ->where('resource_id', $appointment->id)
            ->where('permission_id', function ($query) {
                $query->select('id')
                    ->from('permissions')
                    ->where('name', 'delete-appointment');
            })
            ->exists();

        if ($permission) return true;

        return false;

    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Appointment $appointment): bool
    {
        return $user->hasPermission('restore-appointment');

    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Appointment $appointment): bool
    {
        return $user->hasPermission('force-delete-appointment');

    }
}
