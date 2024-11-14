<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\Mail\MailVerifyNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        if (!$user->hasVerifiedEmail()) {
            return response()->json(['message' => 'Your email address is not verified.'], 403);
        }
        if (!$user->active){
            return response()->json(['message' => 'Your account is disabled.'], 403);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Successful login',
            'email' => $user->email,
            'token' => $token,
        ]);
    }

    public function logout(Request $request)
    {
        $currentAccessToken = $request->user()->currentAccessToken();

        $currentAccessToken->delete();

        return response()->json(['message' => 'Successful Logout']);
    }

    public function register(Request $request)
    {

        $rules = [
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ];

        $request->validate($rules);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $routePrefix = $request->route()->getPrefix();

        $verificationCode = env('APP_URL').':'.env('APP_DEV_PORT').'/'.$routePrefix.'/email/verify/'.$user->id.'/'.sha1($user->email);

        $user->notify(new MailVerifyNotification($user));

        return response()->json([
            'message' => 'User have been successfully registered. Please check your email',
            'name' => $user->name,
            'email' => $user->email,
            'verification_url' => $verificationCode,
            'verification_id' => $user->id,
            'verification_hash' => sha1($user->email),
        ]);
    }
}
