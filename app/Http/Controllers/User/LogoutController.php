<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;

class LogoutController extends Controller
{
    public function __invoke(Request $request)
    {
        try {
            auth()->invalidate(true);
        } catch (JWTException $exception) {
            return response()->json([
                'status' => 'error',
                'message' => 'Could not log user out.',
                'exceptionMessage' => $exception->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }

        auth()->logout();

        return response()->json([
            'status' => 'success',
            'message' => 'User logged out.',
        ]);
    }
}
