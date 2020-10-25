<?php

namespace Aldrumo\RouteLoader\Tests\Console;

use Aldrumo\RouteLoader\Generator;
use Aldrumo\RouteLoader\Tests\TestCase;
use Illuminate\Support\Facades\Storage;

class ClearRouteTest extends TestCase
{
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

        Storage::disk('local')->assertExists('page-routes.php');

        $this->artisan('aldrumo:clear-routes')
            ->expectsOutput('Compiled routes have been cleared.');

        Storage::disk('local')->assertMissing('page-routes.php');
    }
}
