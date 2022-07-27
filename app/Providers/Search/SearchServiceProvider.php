<?php

declare(strict_types=1);

namespace App\Providers\Search;

use App\Providers\Search\Config\Config;
use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Illuminate\Support\ServiceProvider;
use Matchish\ScoutElasticSearch\ElasticSearch\EloquentHitsIteratorAggregate;
use Matchish\ScoutElasticSearch\ElasticSearch\HitsIteratorAggregate;

class SearchServiceProvider extends ServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function register(): void
    {
        // @codeCoverageIgnoreStart
        $this->mergeConfigFrom(__DIR__ . './../../../config/elasticsearch.php', 'elasticsearch');

        $this->app->bind(Client::class, function () {
            $clientBuilder = ClientBuilder::create()->setHosts(Config::hosts());
            /** @phpstan-ignore-next-line */
            if ($user = Config::user()) {
                $clientBuilder->setBasicAuthentication($user, Config::password()); /** @phpstan-ignore-line */
            }

            /** @phpstan-ignore-next-line */
            if ($cloudId = Config::elasticCloudId()) {
                $clientBuilder->setElasticCloudId($cloudId)
                    ->setApiKey(Config::apiKey()); /** @phpstan-ignore-line */
            }

            $clientBuilder->setCABundle(base_path(Config::cert())); /** @phpstan-ignore-line */

            return $clientBuilder->build();
        });

        $this->app->bind(
            HitsIteratorAggregate::class,
            EloquentHitsIteratorAggregate::class
        );
        // @codeCoverageIgnoreEnd
    }

    /**
     * {@inheritdoc}
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/elasticsearch.php' => config_path('elasticsearch.php'),
        ], 'config');
    }

    /**
     * {@inheritdoc}
     */
    public function provides(): array
    {
        return [Client::class];
    }
}
