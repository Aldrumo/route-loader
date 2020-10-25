<?php

namespace Aldrumo\RouteLoader;

use Aldrumo\RouteLoader\Contracts\RouteLoader;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

class Generator
{
    /** @var RouteLoader */
    protected $routeLoader;

    public function __construct(RouteLoader $routeLoader)
    {
        $this->routeLoader = $routeLoader;
    }

    public function generateRoutes()
    {
        if ($this->loadCachedRoutes(config('routeloader.cacheFile'))) {
            return;
        }

        $routes = $this->buildRoutes(
            config('routerloader.slugField'),
            config('routerloader.idField'),
            config('routerloader.controller')
        );

        if ($routes->count() > 0) {
            $this->storeRoutes(
                config('routeloader.cacheFile'),
                $routes
            );
        }
    }

    public function loadCachedRoutes(string $cachePath): bool
    {
        if (Storage::exists($cachePath)) {
            require_once Storage::path($cachePath);
            return true;
        }

        return false;
    }

    public function buildRoutes(string $slugField, string $idField, string $controller): Collection
    {
        return $this->routeLoader->getRoutes()
            ->each(
                function ($page) use ($slugField, $idField, $controller) {
                    Route::get(
                        $page->$slugField,
                        $controller
                    )->name('route-' . $page->$idField);
                }
            )
            ->map(function ($page) use ($slugField, $idField, $controller) {
                return "Route::get('" . $page->$slugField . "', " . $controller . ")->name('route-" .
                    $page->$idField . "');";
            });
    }

    public function storeRoutes(string $cachePath, Collection $routes): void
    {
        Storage::put(
            $cachePath,
            "<?php\n\n" .
            "use Illuminate\Support\Facades\Route;\n\n" .
            $routes->implode("\n")
        );
    }

    public function clearRoutes(string $cachePath): void
    {
        Storage::delete(
            $cachePath
        );
    }
}
