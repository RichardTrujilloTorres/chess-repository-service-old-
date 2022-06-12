<?php

namespace App\Http\Controllers\Game;

use App\Http\Controllers\Controller;
use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ShowController extends Controller
{
    public function __invoke(int $id, Request $request)
    {
        // parse different data elaboration options

        /**
         * @var Game $game
         */
        $game = Game::with(['user', 'analysis'])->find($id);
        if (empty($game)) {
            return response()->json([
                'message' => 'Game not found.',
                'status' => 'error',
                'data' => [],
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'message' => '',
            'status' => 'success',
            'data' => compact('game'),
        ]);
    }
}
