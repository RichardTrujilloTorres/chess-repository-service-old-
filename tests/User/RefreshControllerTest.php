<?php

namespace Tests\User;

use Illuminate\Testing\TestResponse;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Tests\TestCase;

class RefreshControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function testRefresh()
    {
        /**
         * @var TestResponse $response
         */
        $response = $this->call('GET', '/auth/refresh');

        $this->assertResponseOk();
        $response->assertJsonStructure([
            'access_token',
            'token_type',
            'expires_in',
        ]);
    }
}
