<?php

namespace Joshembling\ImageOptimizer\Commands;

use Illuminate\Console\Command;

class ImageOptimizerCommand extends Command
{
    public $signature = 'filament-image-optimizer';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
