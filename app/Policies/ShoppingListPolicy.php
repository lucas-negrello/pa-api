<?php

namespace App\Policies;

use App\Models\ShoppingList;
use App\Models\User;
use App\Models\UserUser;
use Illuminate\Auth\Access\Response;

class ShoppingListPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if(ShoppingList::where('user_id', $user->id)->exists()){
            return true;
        }
        $permission = UserUser::where('granted_user_id', $user->id)
            ->where('resource_type', ShoppingList::class)
            ->where('permission_id', function ($query) {
                $query->select('id')
                    ->from('permissions')
                    ->where('name', 'view-any-shopping-list');
            })
            ->exists();

        if ($permission) return true;

        return false;

    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ShoppingList $shoppingList): bool
    {
        if($user->id === $shoppingList->user_id){
            return true;
        }

        $permission = UserUser::where('granted_user_id', $user->id)
            ->where('resource_type', ShoppingList::class)
            ->where('resource_id', $shoppingList->id)
            ->where('permission_id', function ($query) {
                $query->select('id')
                    ->from('permissions')
                    ->where('name', 'view-shopping-list');
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
        return $user->hasPermission('create-shopping-list');

    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ShoppingList $shoppingList): bool
    {
        if($user->id === $shoppingList->user_id){
            return true;
        }
        $permission = UserUser::where('granted_user_id', $user->id)
            ->where('resource_type', ShoppingList::class)
            ->where('resource_id', $shoppingList->id)
            ->where('permission_id', function ($query) {
                $query->select('id')
                    ->from('permissions')
                    ->where('name', 'update-shopping-list');
            })
            ->exists();

        if ($permission) return true;

        return false;

    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ShoppingList $shoppingList): bool
    {
        if($user->id === $shoppingList->user_id){
            return true;
        }
        $permission = UserUser::where('granted_user_id', $user->id)
            ->where('resource_type', ShoppingList::class)
            ->where('resource_id', $shoppingList->id)
            ->where('permission_id', function ($query) {
                $query->select('id')
                    ->from('permissions')
                    ->where('name', 'delete-shopping-list');
            })
            ->exists();

        if ($permission) return true;

        return false;

    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ShoppingList $shoppingList): bool
    {
        return $user->hasPermission('restore-shopping-list');

    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ShoppingList $shoppingList): bool
    {
        return $user->hasPermission('force-delete-shopping-list');

    }
}
