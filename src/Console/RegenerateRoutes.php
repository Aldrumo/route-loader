<?php

namespace Aldrumo\RouteLoader\Console;

use Aldrumo\RouteLoader\Generator;
use Illuminate\Console\Command;

class RegenerateRoutes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'aldrumo:routes:regenerate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Regenerate the compiled Aldrumo routes';

    public function handle(Generator $generator)
    {
        $generator->regenerateRoutes();

        $this->info('Compiled routes have been regenerated.');
    }
}
