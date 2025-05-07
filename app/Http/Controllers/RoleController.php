<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function attachRole(Request $request){
        $user_id = $request->input('user_id');
        $role = $request->input('role');
        $user = User::where('id',$user_id)->first();

        if(!$user){
            return response()->json([
                'message' => 'User not found'
            ]);
        }

        if(!$role){
            return response()->json([
                'message' => 'Role not found'
            ]);
        }


        $user->assignRole($role);

        return response()->json([
            'message' => 'Role attached',
            'user' => $user->attributesToArray(),
            'role' => $role
        ]);
    }

    public function detachRole(Request $request)
    {
        $user_id = $request->input('user_id');
        $role = $request->input('role');
        $user = User::where('id',$user_id)->first();

        if(!$user){
            return response()->json([
                'message' => 'User not found'
            ]);
        }

        if(!$role){
            return response()->json([
                'message' => 'Role not found'
            ]);
        }

        $user->removeRole($role);

        return response()->json([
            'message' => 'Role removed',
            'user' => $user->attributesToArray(),
            'role' => $role
        ]);
    }
}
