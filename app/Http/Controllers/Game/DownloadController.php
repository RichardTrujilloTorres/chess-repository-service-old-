<?php

namespace App\Http\Controllers\Game;

use App\Http\Controllers\Controller;
use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class DownloadController extends Controller
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

        return response()->streamDownload(function () use ($game) {
            echo $game->moves;
        }, 'game-'.Str::uuid(6).'.'.Game::DEFAULT_FILE_EXTENSION);
    }
}
