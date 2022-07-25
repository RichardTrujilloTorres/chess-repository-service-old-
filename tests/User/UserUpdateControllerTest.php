<?php

namespace Tests\User;

use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Testing\TestResponse;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Tests\TestCase;

class UserUpdateControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function testValidation()
    {
        $this->call('PUT', '/users');

        $this->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->seeJsonEquals([
            'name' => ["The name field is required."],
        ]);

    }

    public function testUpdate()
    {
        $userData = [
            'name' => 'Dummy user --updated',
        ];
        $this->call('PUT', '/users', $userData);

        /**
         * @var User $user
         */
        $user = auth()->user();

        $this->seeInDatabase((new User())->getTable(), collect($userData)->except('password')->toArray());
        $this->assertResponseOk();
        $this->seeJsonEquals([
            'status' => 'success',
            'message' => '',
            'data' => compact('user'),
        ]);
    }
}
