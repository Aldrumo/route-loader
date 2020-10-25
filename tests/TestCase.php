<?php

namespace Aldrumo\RouteLoader\Tests;

use Aldrumo\RouteLoader\Contracts\RouteLoader;
use Aldrumo\RouteLoader\RouteLoaderServiceProvider;
use Aldrumo\RouteLoader\Tests\Fixtures\EmptyRouteLoader;
use Aldrumo\RouteLoader\Tests\Fixtures\FilledRouteLoader;
use Orchestra\Testbench\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app)
    {
        return [
            RouteLoaderServiceProvider::class,
        ];
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set(
            'filesystems.disks.local.root',
            __DIR__ . '/Fixtures'
        );

        $app['config']->set(
            'routeloader.controller',
            "'PageController@load'"
        );
    }

    protected function emptyRouteLoader()
    {
        $this->app->bind(
            RouteLoader::class,
            EmptyRouteLoader::class
        );
    }

    protected function filledRouteLoader()
    {
        $this->app->bind(
            RouteLoader::class,
            FilledRouteLoader::class
        );
    }
}
