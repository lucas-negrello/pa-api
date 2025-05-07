<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function attachPermission(Request $request){
        $user_id = $request->input('user_id');
        $permission = $request->input('permission');
        $user = User::where('id',$user_id)->first();

        if(!$user){
            return response()->json([
                'message' => 'User not found'
            ]);
        }

        if(!$permission){
            return response()->json([
                'message' => 'Permission not found'
            ]);
        }


        $user->assignPermission($permission);

        return response()->json([
            'message' => 'Permission attached',
            'user' => $user->attributesToArray(),
            'permission' => $permission
        ]);
    }

    public function detachPermission(Request $request)
    {
        $user_id = $request->input('user_id');
        $permission = $request->input('permission');
        $user = User::where('id',$user_id)->first();

        if(!$user){
            return response()->json([
                'message' => 'User not found'
            ]);
        }

        if(!$permission){
            return response()->json([
                'message' => 'Permission not found'
            ]);
        }

        $user->removePermission($permission);

        return response()->json([
            'message' => 'Permission removed',
            'user' => $user->attributesToArray(),
            'permission' => $permission
        ]);
    }
}
