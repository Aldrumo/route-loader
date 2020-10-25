<?php

namespace Aldrumo\RouteLoader;

use Aldrumo\RouteLoader\Console\ClearRoutes;
use Aldrumo\RouteLoader\Contracts\RouteLoader;
use Illuminate\Support\ServiceProvider;

class RouteLoaderServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            Generator::class,
            function ($app) {
                return new Generator(
                    $app[RouteLoader::class]
                );
            }
        );

        $this->mergeConfigFrom(
            __DIR__ . '/../config/routeloader.php',
            'routeloader'
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes(
            [
                __DIR__ . '/../config/routeloader.php' => config_path('routeloader.php'),
            ],
            'aldrumo'
        );

        if ($this->app->runningInConsole()) {
            $this->commands([
                ClearRoutes::class,
            ]);
        }
    }
}
