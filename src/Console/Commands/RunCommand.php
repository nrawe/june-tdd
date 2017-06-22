<?php

namespace June\Console\Commands;

use June\Console\Command;
use June\Framework\Harness;
use Illuminate\Filesystem\Filesystem;

class RunCommand extends Command
{
    protected $signature = 'run';

    protected $description = 'Runs all of the tests in the current directory.';

    public function handle(Filesystem $fs, Harness $harness)
    {
        $require = static function ($file) {
            require $file;
        };

        foreach ($fs->allFiles(getcwd() . '/tests') as $file) {
            if (ends_with($file, 'Test.php')) {
                $require($file);
            }
        }

        $harness->finish();
    }
}
