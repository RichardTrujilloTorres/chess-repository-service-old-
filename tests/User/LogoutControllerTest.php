<?php

namespace Tests\User;

use Illuminate\Testing\TestResponse;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Tests\TestCase;

class LogoutControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function testLogoutUser()
    {
        /**
         * @var TestResponse $response
         */
        $response = $this->call('POST', '/auth/logout');

        $this->assertResponseOk();
        $response->assertExactJson([
            'status' => 'success',
            'message' => 'User logged out.',
        ]);
    }
}
