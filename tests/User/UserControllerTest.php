<?php

namespace Tests\User;

use Illuminate\Http\Response;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function testRetrievesUser()
    {
        $this->call('GET', '/auth/user');

        $this->assertResponseOk();
        $this->seeJsonStructure([
            'data' => ['user'],
        ]);
    }
}
