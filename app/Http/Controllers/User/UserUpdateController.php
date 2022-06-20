<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserUpdateController extends Controller
{
    public function __invoke(Request $request): \Illuminate\Http\JsonResponse
    {
        $this->validate($request, [
            'name' => 'required|string|min:5|max:255',
        ]);

        /**
         * @var User $user
         */
        $user = auth()->user();
        $user->fill($request->only(['name']))->save();

        return response()->json([
            'status' => 'success',
            'message' => '',
            'data' => compact('user'),
        ]);
    }
}
