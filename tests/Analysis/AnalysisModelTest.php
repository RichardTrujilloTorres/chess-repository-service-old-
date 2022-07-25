<?php

namespace Tests\Analysis;

use App\Models\Analysis;
use App\Models\Game;
use App\Models\User;
use Illuminate\Http\Response;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Tests\TestCase;

class AnalysisModelTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
        Game::factory(1)->create();
    }

    public function testGameRelation()
    {
        /**
         * @var Game $game
         */
        $game = $this->user->games->first();
        /**
         * @var Analysis $analysis
         */
        $analysis = Analysis::create([
            'game_id' => $game->id,
            'moves' => 'analysis moves...',
        ]);

        $this->assertEquals($game->toArray(), $analysis->game->toArray());
    }
}
