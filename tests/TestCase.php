<?php

namespace Tests;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\TestResponse;
use Laravel\Lumen\Testing\TestCase as BaseTestCase;
use Symfony\Component\HttpFoundation\Response;

abstract class TestCase extends BaseTestCase
{
    /**
     * @var \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|mixed
     */
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->count(1)->create([
            'email' => $this->userData()['email'],
            'name' => $this->userData()['name'],
            'password' => Hash::make($this->userData()['password']),
        ])->first();

        $this->logUser();
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

    protected function userData(): array
    {
        return [
            'email' => 'dummy@test.io',
            'name' => 'Dummy user',
            'password' => 'secretpassword',
        ];
    }

    protected function logUser()
    {
        /**
         * @var TestResponse $response
         */
        $response = $this->call('POST', '/auth/login', collect($this->userData())->except('name')->toArray());

        return $response->getStatusCode() === Response::HTTP_OK ?
            json_decode($response->getContent(), true) :
            null;
    }
}
