<?php

namespace Tests\Game;

use App\Models\Game;
use App\Models\User;
use Illuminate\Http\Response;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
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


        /**
         * @var User $user
         */
        $user = User::factory()->count(1)->create()->first();
        $this->call('POST', '/games', [
            'user_id' => $user->id,
            'moves' => 'test-moves-here...',
        ]);

    }

    public function testStoresGame()
    {
        /**
         * @var User $user
         */
        $user = User::factory()->count(1)->create()->first();

        $gameData = [
            'moves' => 'test moves in here...',
            'user_id' => $user->id,
        ];

        $response = $this->call('POST', '/games', $gameData);

        $this->seeInDatabase((new Game())->getTable(), $gameData);

        /**
         * @var Game $game
         */
        $game = $user->games()->first();

        $this->assertResponseStatus(Response::HTTP_CREATED);;
        $this->seeJsonEquals([
            'message' => 'Game uploaded.',
            'status' => 'success',
            'data' => compact('game'),
        ]);
    }
}
