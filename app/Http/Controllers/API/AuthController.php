<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Traits\ResponseAPI;
class AuthController extends Controller
{
    use ResponseAPI;
   /**
    * Get a JWT via given credentials.
    *
    * @return \Illuminate\Http\JsonResponse
    */
   public function login()
   {
       $credentials = request(['email', 'password']);
 
       if (! $token = auth('api')->attempt($credentials)) {
           return response()->json(['error' => 'Unauthorized'], 401);
       }
 
       return $this->respondWithToken($token);
   }
 
   /**
    * Get the authenticated User.
    *
    * @return \Illuminate\Http\JsonResponse
    */
   public function me()
   {
       return response()->json(auth('api')->user());
   }
 
   /**
    * Log the user out (Invalidate the token).
    *
    * @return \Illuminate\Http\JsonResponse
    */
   public function logout()
   {
       auth()->logout();
 
       return response()->json(['message' => 'Successfully logged out']);
   }
 
   /**
    * Refresh a token.
    *
    * @return \Illuminate\Http\JsonResponse
    */
   public function refresh()
   {
       return $this->respondWithToken(auth('api')->refresh());
   }
 
   /**
    * Get the token array structure.
    *
    * @param  string $token
    *
    * @return \Illuminate\Http\JsonResponse
    */
   protected function respondWithToken($token)
   {
        return $this->success("Login Success", [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 3600
        ]);
   }
}