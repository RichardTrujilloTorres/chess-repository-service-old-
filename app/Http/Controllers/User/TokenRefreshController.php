<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\TokenResponse;
use Illuminate\Http\Request;

class TokenRefreshController extends Controller
{
    use TokenResponse;

    public function __invoke(Request $request): \Illuminate\Http\JsonResponse
    {
        return $this->respondWithToken(auth()->refresh());
    }
}
