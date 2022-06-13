<?php

namespace App\Http\Controllers\Game;

use App\Http\Controllers\Controller;
use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class StoreController extends Controller
{
    public function __invoke(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required|exists:users,id',
            'moves' => 'required|string|min:5|max:10000',
        ]);

        /**
         * @var Game $game
         */
        $game = Game::create([
            'user_id' => $request->user_id,
            'opponent' => (string)$request->opponent,
            'moves' => $request->moves,
            'result' => (string)$request->result,
        ]);

        return response()->json([
            'message' => 'Game uploaded.',
            'status' => 'success',
            'data' => compact('game'),
        ], Response::HTTP_CREATED);
    }
}
