<?php

namespace Aldrumo\RouteLoader\Tests\Fixtures;

use Aldrumo\RouteLoader\Contracts\RouteLoader;
use Illuminate\Support\Collection;

class EmptyRouteLoader implements RouteLoader
{
    public function getRoutes(): Collection
    {
        return collect([]);
    }
}
