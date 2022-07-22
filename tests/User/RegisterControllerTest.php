<?php

namespace Tests\User;

use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Testing\TestResponse;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Tests\TestCase;

class RegisterControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function testValidation()
    {
        $this->call('POST', '/auth/register');

        $this->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->seeJsonEquals([
            'email' => ["The email field is required."],
            'name' => ["The name field is required."],
            'password' => ["The password field is required."],
        ]);

        /**
         * @var TestResponse $response
         */
        $response = $this->call('POST', '/auth/register', [
            'name' => 'not5',
            'email' => 'some-email@test.com',
            'password' => 'somepassword',
        ]);
        $this->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('name', null);

        /**
         * @var TestResponse $response
         */
        $response = $this->call('POST', '/auth/register', [
            'name' => 'Dummy user',
            'email' => 'some-email@test.com',
            'password' => 'not6',
        ]);
        $this->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('password', null);

        /**
         * @var TestResponse $response
         */
        $response = $this->call('POST', '/auth/register', [
            'name' => 'Dummy user',
            'email' => $this->userData()['email'],
            'password' => $this->userData()['password'],
        ]);
        $this->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('email', null);
    }

    public function testRegisterUser()
    {
        $userData = [
            'email' => 'dummy@cr-service.io',
            'name' => 'Dummy user',
            'password' => 'testpassword',
        ];
        $this->call('POST', '/auth/register', $userData);

        /**
         * @var User $user
         */
        $user = User::where('email', $userData['email'])->first();

        $this->seeInDatabase((new User())->getTable(), collect($userData)->except('password')->toArray());
        $this->assertResponseStatus(Response::HTTP_CREATED);;
        $this->seeJsonEquals([
            'message' => 'User registered.',
            'status' => 'success',
            'data' => compact('user'),
        ]);
    }
}
