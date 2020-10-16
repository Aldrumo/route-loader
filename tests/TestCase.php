<?php

namespace Aldrumo\RouteLoader\Tests;

use Aldrumo\RouteLoader\RouteLoaderServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app)
    {
        return [
            RouteLoaderServiceProvider::class,
        ];
    }
}
