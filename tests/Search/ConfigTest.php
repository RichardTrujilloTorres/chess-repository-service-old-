<?php

namespace Tests\Search;

use App\Providers\Search\Config\Config;
use App\Providers\Search\Config\Storage;
use Error;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Tests\TestCase;

class ConfigTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @var Config $searchConfig
     */
    protected $searchConfig;

    protected function setUp(): void
    {
        parent::setUp();
        $this->searchConfig = new Config;
    }

    public function testParse()
    {
        $this->assertTrue($this->searchConfig->parse() instanceof Storage);
    }

    public function testGetsConfig()
    {
        $searchConfigMock = \Mockery::mock(Config::class);
        $searchConfigMock->shouldReceive('__callStatic')
            ->andReturn(config('elasticsearch.user'));
        $this->searchConfig::user();

        $searchConfigMock->shouldReceive('__call')
            ->andReturn(config('elasticsearch.host'));
        $this->searchConfig->hosts();
        $searchConfigMock->shouldReceive('__call')
            ->andReturn(config('elasticsearch.apiKey'));
        $this->searchConfig->apiKey();

        $this->expectException(Error::class);
        $this->searchConfig->invalidMethod();
    }
}
