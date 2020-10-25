<?php

namespace Aldrumo\RouteLoader\Tests\Fixtures;

use Aldrumo\RouteLoader\Contracts\RouteLoader;
use Illuminate\Support\Collection;

class FilledRouteLoader implements RouteLoader
{
    public function getRoutes(): Collection
    {
        $home = new Page();
        $home->slug = '/';
        $home->id = 1;

        $about = new Page();
        $about->slug = '/about';
        $about->id = 2;

        $products = new Page();
        $products->slug = '/products';
        $products->id = 3;

        $contact = new Page();
        $contact->slug = '/contact-us';
        $contact->id = 4;

        return collect([
            $home,
            $about,
            $products,
            $contact
        ]);
    }
}
