<?php

namespace Tests\Game;

use App\Models\Analysis;
use App\Models\Game;
use App\Models\User;
use Illuminate\Http\Response;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Tests\TestCase;

class GameModelTest extends TestCase
{
    use DatabaseMigrations;

    public function testUserRelation()
    {
        /**
         * @var Game $game
         */
        $game = Game::create([
            'user_id' => $this->user->id,
            'moves' => Game::factory(1)->make()->first()['moves'],
        ]);

        $this->assertEquals($game->user()->first()->toArray(), $this->user->toArray());
    }

    public function testAnalysisRelation()
    {
        /**
         * @var Game $game
         */
        $game = Game::create([
            'user_id' => $this->user->id,
            'moves' => Game::factory(1)->make()->first()['moves'],
        ]);
        /**
         * @var Analysis $analysis
         */
        $analysis = Analysis::create([
            'game_id' => $game->id,
            'moves' => 'analysis moves...',
        ]);

        $this->assertEquals($game->analysis()->first()->toArray(), $analysis->toArray());
    }

    public function testByUserScope()
    {
        /**
         * @var Game $game
         */
        $game = Game::create([
            'user_id' => $this->user->id,
            'moves' => Game::factory(1)->make()->first()['moves'],
        ]);

        /**
         * @var Game $userGame
         */
        $userGame = Game::byUser($this->user->id)->first();
        $this->assertEquals($userGame->pluck('user_id', 'moves')->toArray(), $game->pluck('user_id', 'moves')->toArray());
    }
}
