<?php

namespace App\Swagger;


/**
 * @OA\Tag(
 *     name="Authentication",
 *     description="Endpoints for user authentication."
 * )
 */

/**
 * @OA\Post(
 *     path="/api/v1/login",
 *     tags={"Authentication"},
 *     summary="User Login",
 *     description="Authenticates a user using their email and password.",
 *     operationId="login",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"email", "password"},
 *             @OA\Property(property="email", type="string", example="user@example.com"),
 *             @OA\Property(property="password", type="string", example="password123")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful login.",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Successful login"),
 *             @OA\Property(property="email", type="string", example="user@example.com"),
 *             @OA\Property(property="token", type="string", example="your-api-token-here")
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized access due to invalid credentials.",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Unauthorized")
 *         )
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Access forbidden due to unverified email or disabled account.",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Your email address is not verified.")
 *         )
 *     )
 * )
 */

/**
 * @OA\Post(
 *     path="/api/v1/logout",
 *     tags={"Authentication"},
 *     summary="User Logout",
 *     description="Logs out the authenticated user by revoking their current token.",
 *     operationId="logout",
 *     security={{"bearerAuth": {}}},
 *     @OA\Response(
 *         response=200,
 *         description="Successful logout.",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Successful Logout")
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized request due to missing or invalid token.",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Unauthorized")
 *         )
 *     )
 * )
 */

/**
 * @OA\Post(
 *     path="/api/v1/register",
 *     tags={"Authentication"},
 *     summary="User Registration",
 *     description="Registers a new user and sends a verification email.",
 *     operationId="register",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name", "email", "password", "password_confirmation"},
 *             @OA\Property(property="name", type="string", example="John Doe"),
 *             @OA\Property(property="email", type="string", example="user@example.com"),
 *             @OA\Property(property="password", type="string", example="password123"),
 *             @OA\Property(property="password_confirmation", type="string", example="password123")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User successfully registered. Verification email sent.",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="User have been successfully registered. Please check your email"),
 *             @OA\Property(property="name", type="string", example="John Doe"),
 *             @OA\Property(property="email", type="string", example="user@example.com"),
 *             @OA\Property(property="verification_url", type="string", example="https://app.example.com/api/v1/email/verify/1/123456"),
 *             @OA\Property(property="verification_id", type="integer", example=1),
 *             @OA\Property(property="verification_hash", type="string", example="123456")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Invalid input data.",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="The given data was invalid.")
 *         )
 *     ),
 *     @OA\Response(
 *         response=409,
 *         description="Email already registered.",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="The email has already been taken.")
 *         )
 *     )
 * )
 */

class AuthSwagger
{

}
