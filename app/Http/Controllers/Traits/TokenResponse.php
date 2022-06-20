<?php

namespace App\Http\Controllers\Traits;

trait TokenResponse
{
    protected function respondWithToken($token): \Illuminate\Http\JsonResponse
    {
//        return response()->json([
////            'access_token' => $token,
//            'token' => $token,
//            'token_type' => 'bearer',
//            'expires_in' => auth()->factory()->getTTL() * 60
//        ])->withHeaders([
//            'Authorization' => 'Bearer '.$token,
//        ]);

        return response()->json([
            'access_token' => $token,
//            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
