<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    public function __invoke(): \Illuminate\Http\JsonResponse
    {
        /**
         * @var User $user
         */
        $user = auth()->user();

        return response()->json([
            'status' => 'success',
            'message' => '',
            'data' => compact('user'),
        ]);
    }
}
