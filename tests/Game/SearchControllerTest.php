<?php

namespace Tests\Game;

use App\Models\Game;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Testing\TestResponse;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Tests\TestCase;

class SearchControllerTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
        Game::factory(2)->create();
        Artisan::call('scout:import', [
            'model' => Game::class,
        ]);
    }

    public function testValidation()
    {
        $this->call('GET', '/games/search');

        $this->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->seeJsonEquals([
            'user_id' => ["The user id field is required."],
        ]);

        $this->call('GET', '/games/search', [
            'user_id' => $this->user->id,
            'query' => 1,
        ]);
        $this->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->seeJsonEquals([
            'query' => ["The query must be a string."],
        ]);

        $this->call('GET', '/games/search', [
            'user_id' => 1111,
        ]);
        $this->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->seeJsonEquals([
            'user_id' => ["The selected user id is invalid."],
        ]);
    }

    public function testSearchGames()
    {
        $query = 'Karpov';
        /**
         * @var TestResponse $response
         */
        $response = $this->call('GET', '/games/search', [
            'user_id' => $this->user->id,
            'query' => $query,
        ]);

        $responseData = json_decode($response->getContent(), true);
        /**
         * @var Collection $games
         */
        $games = Game::search($query)->where('user_id', $this->user->id)->get()->values();

        $this->assertResponseOk();;
        $this->seeJsonStructure([
            'message',
            'status',
            'data' => ['games'],
        ]);
        $this->assertEquals($responseData['data']['games'], $games->toArray());
    }
}
