<?php

namespace Aldrumo\RouteLoader\Tests;

use Aldrumo\RouteLoader\Generator;

class RouteLoaderServiceProviderTest extends TestCase
{
    /** @test */
    public function route_generator_is_loaded()
    {
        $this->emptyRouteLoader();

        $this->assertInstanceOf(
            Generator::class,
            $this->app[Generator::class]
        );

        $this->assertInstanceOf(
            Generator::class,
            app(Generator::class)
        );
    }
}
