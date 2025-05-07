<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Goal;
use App\Models\Permission;
use App\Models\ShoppingList;
use App\Models\Task;
use App\Models\User;
use App\Models\UserUser;
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

    public function setResourceTypeAttribute($resourceName)
    {
        return 'App\\Models\\'.class_basename($resourceName);
    }

    public function findResource(string $resourceType, int $resourceId): Model
    {
        if (!isset($this->allowedModels[$resourceType])) {
            throw new \Exception("Model not found");
        }
        $modelClass = $this->allowedModels[$resourceType];
        return $modelClass::findOrFail($resourceId);
    }

    public function grantPermissionsToAnotherUser(Request $request){

        $permissionName = $request->input('permission');
        $resourceId = $request->input('resource_id');
        $resourceType = $request->input('resource_type');
        $user = User::findOrFail($request->input('user_id'));
        $grantedUser = User::findOrFail($request->input('granted_user_id'));
        $resource = $this->findResource($resourceType, $resourceId);

        if($user->id !== $resource->user_id){
            throw new \Exception("Cannot give permission for not owned resources");
        }

        $permission = Permission::where('name', $permissionName)->firstOrFail();

        $existingPermissions = UserUser::where('user_id', $user->id)
            ->where('resource_id', $resourceId)
            ->where('resource_type', $resourceType)
            ->where('granted_user_id', $grantedUser->id)
            ->where('permission_id', $permission->id)
            ->first();

        if($existingPermissions){
            return response()->json([
                'message' => 'Permission already granted'
            ], 400);
        }

        UserUser::create([
            'user_id' => $user->id,
            'resource_id' => $resource->id,
            'resource_type' => $this->setResourceTypeAttribute($resourceType),
            'permission_id' => $permission->id,
            'granted_user_id' => $grantedUser->id
        ]);

        return response()->json([
            'message' => 'Permission granted successfully.',
            'user' => $user->attributesToArray(),
            'grantedUser' => $grantedUser->attributesToArray(),
            'permission' => $permission->attributesToArray(),
            'resourceType' => $resourceType
        ], 200);

    }

    public function removePermissionsFromAnotherUser(Request $request)
    {
        $permissionName = $request->input('permission');
        $resourceId = $request->input('resource_id');
        $resourceType = $this->setResourceTypeAttribute($request->input('resource_type'));
        $user = User::findOrFail($request->input('user_id'));
        $grantedUser = User::findOrFail($request->input('granted_user_id'));
        $resource = $this->findResource($resourceType, $resourceId);

        if($user->id !== $resource->user_id){
            throw new \Exception("Cannot remove permission for not owned resources");
        }

        $permission = Permission::where('name', $permissionName)->firstOrFail();

        $existingPermission = UserUser::where('user_id', $user->id)
            ->where('resource_id', $resourceId)
            ->where('resource_type', $resourceType)
            ->where('granted_user_id', $grantedUser->id)
            ->where('permission_id', $permission->id)
            ->first();

        if(!$existingPermission){
            return response()->json([
                'message' => 'Permission is not granted for this user'
            ], 404);
        }

        $existingPermission->delete();

        return response()->json([
            'message' => 'Permission revoked successfully.',
            'user' => $user->attributesToArray(),
            'grantedUser' => $grantedUser->attributesToArray(),
            'permission' => $permission->attributesToArray(),
            'resourceType' => $resourceType
        ], 200);
    }

    public function getAllPermissionsFromUser(Request $request)
    {
        $authenticatedUser = $request->user();

        $receivedPermissions = UserUser::with('permission', 'resource')
            ->where('granted_user_id', $authenticatedUser->id)
            ->get();

        $givenPermissions = UserUser::with('permission', 'resource')
            ->where('user_id', $authenticatedUser->id)
            ->get();

        if(!$givenPermissions && !$receivedPermissions){
            return response()->json([
                'message' => 'Permissions not found',
            ], 404);
        }

        return response()->json([
            'message' => 'Permissions found successfully.',
            'received_permissions' => $receivedPermissions,
            'given_permissions' => $givenPermissions
        ], 200);
    }
}
