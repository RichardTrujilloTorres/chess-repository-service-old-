<?php

namespace Tests\Game;

use App\Models\Game;
use Illuminate\Http\Response;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Tests\TestCase;

class DeleteControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function testDeletesGame()
    {
        /**
         * @var Game $game
         */
        $game = Game::factory()->count(1)->create()->first();

        $this->call('DELETE', '/games/'.$game->id);
        $this->assertResponseStatus(Response::HTTP_CREATED);
        $this->seeJsonEquals([
            'status' => 'success',
            'message' => '',
            'data' => [],
        ]);
        $this->notSeeInDatabase((new Game())->getTable(), [
            'user_id' => $game->user_id,
            'moves' => $game->moves,
        ]);
    }

    public function testHandlesNotFound()
    {
        $this->call('DELETE', '/games/11111');

        $this->assertResponseStatus(Response::HTTP_NOT_FOUND);
        $this->seeJsonEquals([
            'message' => 'Game not found.',
            'status' => 'error',
            'data' => [],
        ]);
    }
}
