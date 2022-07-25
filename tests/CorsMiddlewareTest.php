<?php

namespace Tests;

use App\Models\Analysis;
use App\Models\Game;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Testing\TestResponse;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Tests\TestCase;

class CorsMiddlewareTest extends TestCase
{
    use DatabaseMigrations;

    public function testOptions()
    {
        /**
         * @var TestResponse $response
         */
        $response = $this->call('OPTIONS', '');

        $responseData = json_decode($response->getContent(), true);
        $this->assertResponseOk();
        $this->assertEquals('{"method":"OPTIONS"}', $responseData);
    }

    public function testHeaders()
    {
        $this->call('GET', '');

        $this->seeHeader('Access-Control-Allow-Origin', '*');
        $this->seeHeader('Access-Control-Allow-Methods', 'POST, GET, OPTIONS, PUT, DELETE');
        $this->seeHeader('Access-Control-Allow-Credentials', 'true');
        $this->seeHeader('Access-Control-Max-Age', '86400');
        $this->seeHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With');
    }
}
