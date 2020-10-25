<?php

namespace Aldrumo\RouteLoader\Contracts;

use Illuminate\Support\Collection;

interface RouteLoader
{
    public function getRoutes(): Collection;
}
