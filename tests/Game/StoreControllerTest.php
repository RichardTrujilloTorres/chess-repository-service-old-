<?php

namespace Tests\Game;

use App\Models\Game;
use Database\Factories\GameFactory;
use Illuminate\Http\Response;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Tests\TestCase;

class StoreControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function testValidation()
    {
        $this->call('POST', '/games');

        $this->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->seeJsonEquals([
            'user_id' => ["The user id field is required."],
            'moves' => ["The moves field is required."],
        ]);

        $this->call('POST', '/games', [
            'user_id' => 11111,
        ]);

        $this->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->seeJsonEquals([
            'user_id' => ["The selected user id is invalid."],
            'moves' => ["The moves field is required."],
        ]);
    }

    public function testStoresGame()
    {
        $gameData = [
            'moves' => (new GameFactory)->definition()['moves'],
            'user_id' => $this->user->id,
        ];

        $this->call('POST', '/games', $gameData);

        /**
         * @var Game $game
         */
        $game = $this->user->games()->first();
        $game->load(['user']);

        $this->seeInDatabase((new Game())->getTable(), $gameData);
        $this->assertResponseStatus(Response::HTTP_CREATED);;
        $this->seeJsonEquals([
            'message' => 'Game uploaded.',
            'status' => 'success',
            'data' => compact('game'),
        ]);
    }
}
