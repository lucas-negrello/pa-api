<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Goal;
use App\Models\Permission;
use App\Models\ShoppingList;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class HandlePermissions extends Controller
{
    private $allowedModels = [
        'Task' => Task::class,
        'Goal' => Goal::class,
        'Appointment' => Appointment::class,
        'ShoppingList' => ShoppingList::class,
    ];

    public function findResource(string $resourceType, int $resourceId): Model
    {
        if (!isset($this->allowedModels[$resourceType])) {
            throw new \Exception("Model not found");
        }
        $modelClass = $this->allowedModels[$resourceType];
        return $modelClass::findOrFail($resourceId);
    }

    public static function grantPermissionToOwnResources(User $user){
        $tasks = $user->tasks;
        $permissions = $user->permissions;
        if($tasks != null){
            foreach($tasks as $task){
                foreach ($permissions as $permission) {
                    $user->sharedPermissions()->create([
                        'granted_user_id' => $user->id,
                        'permission_id' => $permission->id,
                        'resource_id' => $task->id,
                    ]);
                }
            }
        }
    }

    public function grantPermissionsToAnotherUser(Request $request, $user_id, $granted_user_id){

        $permissionName = $request->input('permission');
        $resourceId = $request->input('resource_id');
        $resourceType = $request->input('resource_type');
        $user = User::findOrFail($user_id);
        $grantedUser = User::findOrFail($granted_user_id);
        $resource = $this->findResource($resourceType, $resourceId);

        if($user->id !== $resource->user_id){
            throw new \Exception("Cannot give permission for not owned resources");
        }

        $permission = Permission::where('name', $permissionName)->firstOrFail();


        $user->sharedPermissions()->create([
            'user_id' => $user->id,
            'resource_id' => $resource->id,
            'resource_type' => $resourceType,
            'permission_id' => $permission->id,
            'granted_user_id' => $grantedUser->id
        ]);

        return response()->json([
            'message' => 'Permission granted successfully.',
            'user' => $user,
            'grantedUser' => $grantedUser,
            'permission' => $permission,
            'resourceType' => $resourceType
        ], 200);

        // TODO - ESTÁ ENVIANDO OS DADOS CORRETAMENTE PRA RESPONSE MAS SALVA ERRADO NO DB
    }
}
