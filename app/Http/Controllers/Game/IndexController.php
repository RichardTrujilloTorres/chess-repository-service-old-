<?php

namespace App\Http\Controllers\Game;

use App\Http\Controllers\Controller;
use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class IndexController extends Controller
{
    public function __invoke(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required|exists:users,id',
        ]);

        /**
         * @var LengthAwarePaginator $games
         */
        $games = Game::byUser($request->user_id)->orderBy('id', 'DESC')->paginate();

        return response()->json([
            'message' => '',
            'status' => 'success',
            'data' => compact('games'),
        ]);
    }
}
