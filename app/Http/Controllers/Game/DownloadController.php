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
        $game = Game::findOrFail($id);

        return response()->streamDownload(function () use ($game) {
            echo $game->moves;
        }, 'game-'.Str::uuid(6).'.'.Game::DEFAULT_FILE_EXTENSION);
    }
}
