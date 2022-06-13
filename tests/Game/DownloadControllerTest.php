<?php

namespace Tests\Game;

use App\Models\Game;
use App\Models\User;
use Illuminate\Http\Response;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Tests\TestCase;

class DownloadControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function testDownloadGame()
    {
        Game::factory()->count(1)->create();

        $response = $this->call('GET', '/games/1/download');

        $this->assertResponseOk();;
        $this->assertFalse($response->isEmpty());
        $this->seeHeader('content-type', 'text/html; charset=UTF-8');
    }

    public function testHandlesNotFound()
    {
        $this->call('GET', '/games/11111/download');

        $this->assertResponseStatus(Response::HTTP_NOT_FOUND);
        $this->seeJsonEquals([
            'message' => 'Game not found.',
            'status' => 'error',
            'data' => [],
        ]);
    }
}
