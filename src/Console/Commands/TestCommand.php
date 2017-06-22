<?php

namespace June\Console\Commands;

use June\Console\Command;
use Illuminate\Filesystem\Filesystem;

class TestCommand extends Command
{
    protected $signature = 'test';

    protected $description = 'Runs all of the tests in the current directory.';

    public function handle(Filesystem $fs)
    {
        $require = static function ($file) {
            require $file;
        };

        foreach ($fs->files(getcwd() . '/tests') as $file) {
            $require($file);
        }
    }
}
