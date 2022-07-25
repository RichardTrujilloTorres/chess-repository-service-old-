<?php

namespace Tests\Game;

use App\Models\Game;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Tests\TestCase;

class IndexControllerTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
        Game::factory(100)->create();
    }

    public function testValidation()
    {
        $this->call('GET', '/games');
        $this->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->seeJsonEquals([
            'user_id' => ["The user id field is required."],
        ]);

        $this->call('GET', '/games', ['user_id' => '11111']);
        $this->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->seeJsonEquals([
            'user_id' => ["The selected user id is invalid."],
        ]);
    }

    public function testIndexGames()
    {
        $this->call('GET', '/games', ['user_id' => $this->user->id]);
        $this->assertResponseOk();

        /**
         * @var LengthAwarePaginator $games
         */
        $games = Game::byUser($this->user->id)->orderBy('id', 'DESC')->paginate();
        $this->seeJsonEquals([
            'message' => '',
            'status' => 'success',
            'data' => compact('games'),
        ]);
    }
}
