<?php

namespace Tests\Analysis;

use App\Models\Analysis;
use App\Models\Game;
use App\Models\User;
use Illuminate\Http\Response;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Tests\TestCase;

class AppendControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function testValidation()
    {
        /**
         * @var Game $game
         */
        $game = Game::factory()->count(1)->create()->first();

        $this->call('POST', '/analysis/'.$game->id);

        $this->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->seeJsonEquals([
            'game_id' => ["The game id field is required."],
            'moves' => ["The moves field is required."],
        ]);

        $this->call('POST', '/analysis/'.$game->id, [
            'game_id' => 11111,
        ]);

        $this->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->seeJsonEquals([
            'game_id' => ["The selected game id is invalid."],
            'moves' => ["The moves field is required."],
        ]);


        $this->call('POST', '/analysis/'.$game->id, [
            'game_id' => $game->id,
            'moves' => 'test-moves-here...',
        ]);
        $this->assertResponseStatus(Response::HTTP_CREATED);
    }

    public function testAppendsAnalysis()
    {
        /**
         * @var Game $game
         */
        $game = Game::factory()->count(1)->create()->first();

        $analysisData = [
            'moves' => 'test moves in here...',
            'game_id' => $game->id,
        ];

        $response = $this->call('POST', '/analysis/'.$game->id, $analysisData);

        $this->seeInDatabase((new Analysis())->getTable(), $analysisData);
        $this->assertResponseStatus(Response::HTTP_CREATED);;
        $this->seeJsonContains([
            'message' => 'Analysis appended.',
            'status' => 'success',
        ]);

        $this->seeJsonStructure([
            'message',
            'status',
            'data',
        ]);

        $this->assertArrayHasKey('analysis', json_decode($response->getContent(), true)['data'][0]);
        $this->assertArrayHasKey('game', json_decode($response->getContent(), true)['data'][1]);
    }
}
