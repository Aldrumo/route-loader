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

    public function regenerateRoutes()
    {
        $this->clearRoutes();
        $this->generateRoutes();
    }

    public function generateRoutes()
    {
        if ($this->loadCachedRoutes(config('routeloader.cacheFile'))) {
            return;
        }

        $routes = $this->buildRoutes(
            config('routeloader.slugField'),
            config('routeloader.idField'),
            config('routeloader.controller')
        );

        if ($routes->count() > 0) {
            $this->storeRoutes(
                config('routeloader.cacheFile'),
                $routes
            );
        }
    }

    public function clearRoutes()
    {
        $this->clearCacheFile(
            config('routeloader.cacheFile')
        );
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
                return "Route::get('" . $page->$slugField . "', '" . $controller . "')->name('route-" .
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

    public function clearCacheFile(string $cachePath): void
    {
        Storage::delete(
            $cachePath
        );
    }
}
