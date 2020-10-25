# Route Loader

Laravel package for loading dynamic sluggable routes.

## Setup

Create class that implements `\Aldrumo\RouteLoader\Contracts\RouteLoader`.

This should return a collection that contains items with a `slug` and `id` attribute. This will likely be "Page" models.

```php
<?php

namespace App\Routes;

use Aldrumo\RouteLoader\Contracts\RouteLoader;
use App\Models\Page;
use Illuminate\Support\Collection;

class FilledRouteLoader implements RouteLoader
{
    public function getRoutes(): Collection
    {
        return Page::where('is_active', true)->get();
    }
}

```

Register this to the container in your app service provider.

```php
use Aldrumo\RouteLoader\Contracts\RouteLoader;
use App\Routes\PageRouteLoader;
$this->app->bind(
    RouteLoader::class,
    PageRouteLoader::class
);
```

## Generator

Place the following lins in the "boot" method of your apps service provider

```php
use Aldrumo\RouteLoader\Generator;
use Illuminate\Support\Facades\Route;

Route::middleware('web')
    ->group(
        function () {
            $this->app[Generator::class]->generateRoutes();
        }
    );
```

### Clearing Routes

```php
resolve(\Aldrumo\RouteLoader\Generator::class)->clearRoutes();
```

```bash
php artisan aldrumo:clear-routes
```
