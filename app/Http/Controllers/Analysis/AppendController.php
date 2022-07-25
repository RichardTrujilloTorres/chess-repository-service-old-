<?php

namespace App\Http\Controllers\Analysis;

use App\Http\Controllers\Controller;
use App\Models\Analysis;
use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AppendController extends Controller
{
    public function __invoke(Request $request)
    {
        $this->validate($request, [
            'game_id' => 'required|exists:games,id',
            'moves' => 'required|string|min:5|max:10000',
        ]);

        /**
         * @var Game $game
         */
        $game = Game::find($request->game_id);

        /**
         * @var Analysis $analysis
         */
        $analysis = Analysis::create([
            'game_id' => $request->game_id,
            'moves' => $request->moves,
        ]);

        $game->load(['user', 'analysis']);

        return response()->json([
            'message' => 'Analysis appended.',
            'status' => 'success',
            'data' => [
                compact('analysis'),
                compact('game'),
            ],
        ], Response::HTTP_CREATED);
    }
}
