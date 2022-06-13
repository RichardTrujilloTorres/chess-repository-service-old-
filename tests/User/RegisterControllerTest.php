<?php

namespace Tests\User;

use App\Models\Analysis;
use App\Models\Game;
use App\Models\User;
use Illuminate\Http\Response;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Tests\TestCase;

class RegisterControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function testValidation()
    {
        $this->call('POST', '/users');

        $this->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->seeJsonEquals([
            'email' => ["The email field is required."],
            'name' => ["The name field is required."],
            'password' => ["The password field is required."],
        ]);
    }

    public function testRegisterUser()
    {
        $userData = [
            'email' => 'dummy@test.io',
            'name' => 'Dummy user',
            'password' => 'secretpassword',
        ];

        $this->call('POST', '/users', $userData);

        /**
         * @var User $user
         */
        $user = User::first();

        $this->seeInDatabase((new User())->getTable(), collect($userData)->except('password')->toArray());
        $this->assertResponseStatus(Response::HTTP_CREATED);;
        $this->seeJsonEquals([
            'message' => 'User registered.',
            'status' => 'success',
            'data' => compact('user'),
        ]);
    }
}
