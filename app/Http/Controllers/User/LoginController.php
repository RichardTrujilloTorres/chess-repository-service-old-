<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\TokenResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LoginController extends Controller
{
    use TokenResponse;

    public function __invoke(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|exists:users|max:255',
            'password' => 'required|min:6|max:255',
        ]);

        /**
         * @var array $credentials
         */
        $credentials = $request->only(['email', 'password']);
        if (! $token = auth()->attempt($credentials)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized.',
            ], Response::HTTP_UNAUTHORIZED);
        }

        return $this->respondWithToken($token);
    }
}
