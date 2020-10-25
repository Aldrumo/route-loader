<?php

namespace Aldrumo\RouteLoader\Console;

use Aldrumo\RouteLoader\Generator;
use Illuminate\Console\Command;

class ClearRoutes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'aldrumo:clear-routes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear the compiled Aldrumo routes';

    public function handle(Generator $generator)
    {
        $generator->clearRoutes();

        $this->info('Compiled routes have been cleared.');
    }
}
