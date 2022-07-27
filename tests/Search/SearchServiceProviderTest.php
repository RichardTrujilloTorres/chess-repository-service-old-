<?php

namespace Tests\Search;

use App\Providers\Search\Config\Config;
use App\Providers\Search\Config\Storage;
use App\Providers\Search\SearchServiceProvider;
use Elastic\Elasticsearch\Client;
use Error;
use Illuminate\Container\Container;
use Laravel\Lumen\Application;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Mockery;
use phpDocumentor\Reflection\Types\Void_;
use Tests\TestCase;

class SearchServiceProviderTest extends TestCase
{
    use DatabaseMigrations;

    protected $searchProvider;
    protected $searchProviderMock;

    protected function setUp(): void
    {
        parent::setUp();
        $this->searchProvider = new SearchServiceProvider($this->app);
        $this->searchProviderMock = Mockery::mock(SearchServiceProvider::class);
    }

    public function testProvides()
    {
        $this->assertEquals([Client::class], $this->searchProvider->provides());
    }
}
