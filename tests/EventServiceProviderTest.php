<?php

namespace Tests;

use App\Providers\EventServiceProvider;
use Laravel\Lumen\Application;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Mockery\Mock;

class EventServiceProviderTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @var Mock
     */
    protected $appMock;
    /**
     * @var EventServiceProvider
     */
    protected $eventServiceProvider;

    protected function setUp(): void
    {
        parent::setUp();

        $this->appMock = \Mockery::mock(Application::class);
        $this->eventServiceProvider = new EventServiceProvider($this->appMock);
    }

    public function testShouldDiscoverEvents()
    {
        $this->assertEquals(false, $this->eventServiceProvider->shouldDiscoverEvents());
    }
}
