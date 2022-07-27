<?php

namespace Tests;

use App\Providers\AuthServiceProvider;
use Illuminate\Auth\AuthManager;
use Illuminate\Config\Repository;
use Laravel\Lumen\Application;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Mockery\Mock;

class AuthServiceProviderTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @var Mock
     */
    protected $appMock;
    /**
     * @var AuthServiceProvider
     */
    protected $authServiceProvider;

    protected function setUp(): void
    {
        parent::setUp();
        $this->appMock = \Mockery::mock(Application::class);
        $this->authServiceProvider = new AuthServiceProvider(['auth' => $this->appMock]);
    }

    public function testProviderIsConstructed()
    {
        $this->assertInstanceOf(AuthServiceProvider::class, $this->authServiceProvider);
    }

    public function testViaRequest()
    {
        $this->appMock->shouldReceive('viaRequest')
            ->once();
        $this->authServiceProvider->boot();
    }
}
