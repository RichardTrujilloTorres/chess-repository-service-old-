<?php

namespace Tests\User;

use Illuminate\Http\Response;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function testValidation()
    {
        $this->call('POST', '/auth/login');

        $this->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->seeJsonEquals([
            'email' => ["The email field is required."],
            'password' => ["The password field is required."],
        ]);
    }

    public function testLoginUser()
    {
        $userData = [
            'email' => $this->userData()['email'],
            'password' => $this->userData()['password'],
        ];

        /**
         * @var Response $response
         */
        $response = $this->call('POST', '/auth/login', $userData);

        $this->assertResponseOk();
        $response->assertJsonStructure([
            'access_token',
            'token_type',
            'expires_in',
        ]);
    }

    public function testInvalidUser()
    {
        $userData = [
            'email' => 'invalid@useremail.io',
            'password' => 'dummy-password',
        ];

        $this->call('POST', '/auth/login', $userData);
        $this->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function testInvalidCredentials()
    {
        $userData = [
            'email' => $this->userData()['email'],
            'password' => 'dummy-password',
        ];

        $this->call('POST', '/auth/login', $userData);
        $this->assertResponseStatus(Response::HTTP_UNAUTHORIZED);
    }
}
