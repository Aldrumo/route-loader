<?php

namespace Aldrumo\RouteLoader\Tests;

use Aldrumo\RouteLoader\Generator;
use Illuminate\Support\Facades\Storage;

class GeneratorTest extends TestCase
{
    /** @test */
    public function can_build_route_collection()
    {
        $this->filledRouteLoader();

        $routes = resolve(Generator::class)->buildRoutes('slug', 'id', "'PageController@load'");

        $expected = "Route::get('/', 'PageController@load')->name('route-1');\n" .
            "Route::get('/about', 'PageController@load')->name('route-2');\n" .
            "Route::get('/products', 'PageController@load')->name('route-3');\n" .
            "Route::get('/contact-us', 'PageController@load')->name('route-4');";

        $this->assertSame(
            $expected,
            $routes->implode("\n")
        );

        $this->assertCount(
            4,
            resolve('router')->getRoutes()
        );
    }

    /** @test */
    public function can_handle_no_routes()
    {
        $this->emptyRouteLoader();

        $routes = resolve(Generator::class)->buildRoutes('slug', 'id', 'PageController@load');

        $this->assertEmpty(
            $routes->implode("\n")
        );

        $this->assertCount(
            0,
            resolve('router')->getRoutes()
        );
    }

    /** @test */
    public function can_load_and_include_cached_routes()
    {
        $this->emptyRouteLoader();

        $result = resolve(Generator::class)->loadCachedRoutes('cached-routes.php');

        $this->assertTrue(
            $result
        );

        $this->assertCount(
            4,
            resolve('router')->getRoutes()
        );
    }

    /** @test */
    public function can_save_new_cache_file()
    {
        Storage::fake('local');

        $this->filledRouteLoader();
        $generator = resolve(Generator::class);
        $result = $generator->storeRoutes(
            'new-cache-routes.php',
            $generator->buildRoutes('slug', 'id', "'PageController@load'")
        );

        Storage::disk('local')->assertExists('new-cache-routes.php');

        $cacheContents = Storage::disk('local')->get('new-cache-routes.php');
        $expected = "<?php\n\n" .
            "use Illuminate\Support\Facades\Route;\n\n" .
            "Route::get('/', 'PageController@load')->name('route-1');\n" .
            "Route::get('/about', 'PageController@load')->name('route-2');\n" .
            "Route::get('/products', 'PageController@load')->name('route-3');\n" .
            "Route::get('/contact-us', 'PageController@load')->name('route-4');";

        $this->assertSame(
            $expected,
            $cacheContents
        );
    }

    /** @test */
    public function can_save_new_cache_file_when_routes_empty()
    {
        Storage::fake('local');

        $this->emptyRouteLoader();
        $generator = resolve(Generator::class);
        $result = $generator->storeRoutes(
            'new-cache-routes.php',
            $generator->buildRoutes('slug', 'id', "'PageController@load'")
        );

        Storage::disk('local')->assertExists('new-cache-routes.php');

        $cacheContents = Storage::disk('local')->get('new-cache-routes.php');
        $expected = "<?php\n\n" .
            "use Illuminate\Support\Facades\Route;\n\n";

        $this->assertSame(
            $expected,
            $cacheContents
        );
    }

    /** @test */
    public function can_delete_cache_file()
    {
        Storage::fake('local');

        $this->filledRouteLoader();
        $generator = resolve(Generator::class);
        $result = $generator->storeRoutes(
            'new-cache-routes.php',
            $generator->buildRoutes('slug', 'id', "'PageController@load'")
        );

        $generator->clearCacheFile('new-cache-routes.php');

        Storage::disk('local')->assertMissing('new-cache-routes.php');
    }

    /** @test */
    public function can_generate_routes()
    {
        $this->filledRouteLoader();
        Storage::fake('local');

        resolve(Generator::class)->generateRoutes();

        Storage::disk('local')->assertExists('page-routes.php');

        $this->assertCount(
            4,
            resolve('router')->getRoutes()
        );
    }

    /** @test */
    public function can_clear_routes()
    {
        Storage::fake('local');

        $this->filledRouteLoader();
        $generator = resolve(Generator::class);
        $result = $generator->storeRoutes(
            'page-routes.php',
            $generator->buildRoutes('slug', 'id', "'PageController@load'")
        );

        $generator->clearRoutes();

        Storage::disk('local')->assertMissing('page-routes.php');
    }
}
