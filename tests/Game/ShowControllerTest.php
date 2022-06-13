<?php

namespace Tests\Game;

use App\Models\Game;
use Illuminate\Http\Response;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Tests\TestCase;

class ShowControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function testShowsGame()
    {
        /**
         * @var Game $game
         */
        $game = Game::factory()->count(1)->create()->first();

        $this->call('GET', '/games/'.$game->id);

        $this->assertResponseOk();;
        $this->seeJson([
            'status' => 'success',
            'message' => '',
        ]);
        $this->seeJsonStructure([
            'data' => [
                'game',
            ],
        ]);
    }

    public function testHandlesNotFound()
    {
        $this->call('GET', '/games/11111');

        $this->assertResponseStatus(Response::HTTP_NOT_FOUND);
        $this->seeJsonEquals([
            'message' => 'Game not found.',
            'status' => 'error',
            'data' => [],
        ]);
    }
}
