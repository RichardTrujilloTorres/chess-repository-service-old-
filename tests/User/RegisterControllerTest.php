<?php

namespace Tests\User;

use App\Models\User;
use Illuminate\Http\Response;
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
