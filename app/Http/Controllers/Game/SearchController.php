<?php

namespace App\Http\Controllers\Game;

use App\Http\Controllers\Controller;
use App\Models\Game;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function __invoke(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required|exists:users,id',
            'query' => 'sometimes|string',
        ]);

        /**
         * @var Collection $games
         */
        $games = Game::search($request->input('query'))->where('user_id', $request->user_id)->get();

        return response()->json([
            'message' => '',
            'status' => 'success',
            'data' => compact('games'),
        ]);
    }
}
