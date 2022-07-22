<?php

namespace Tests;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Lumen\Testing\TestCase as BaseTestCase;

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
        ]);
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
}
