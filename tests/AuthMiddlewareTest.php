<?php

namespace Tests;

use Illuminate\Http\Response;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\TestCase as BaseTestCase;

class AuthMiddlewareTest extends BaseTestCase
{
    use DatabaseMigrations;

    public function testUnauthorized()
    {
        $this->call('GET', 'auth/user');
        $this->assertResponseStatus(Response::HTTP_UNAUTHORIZED);
    }

    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        return require __DIR__.'/../bootstrap/app.php';
    }
}
