<?php

namespace App\Http\Controllers\Game;

use App\Http\Controllers\Controller;
use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DeleteController extends Controller
{
    public function __invoke(int $id, Request $request)
    {
        /**
         * @var Game $game
         */
        $game = Game::find($id);
        if (empty($game)) {
            return response()->json([
                'message' => 'Game not found.',
                'status' => 'error',
                'data' => [],
            ], Response::HTTP_NOT_FOUND);
        }

        $game->delete();

        return response()->json([
            'message' => '',
            'status' => 'success',
            'data' => [],
        ], Response::HTTP_CREATED);
    }
}
