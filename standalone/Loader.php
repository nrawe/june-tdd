<?php

namespace June\Framework;

use InvalidArgumentException;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use function June\Framework\{ends_with, starts_with};

class Loader
{
    public function load(string $path): void
    {
        is_dir($path) ? $this->loadDirectory($path) : $this->loadFile($path, true);
    }

    protected function loadDirectory(string $path): void
    {
        foreach (new RecursiveDirectoryIterator($path) as $file) {
            if (ends_with($file, 'Test.php')) {
                $this->loadFile($file, false);
            }
        }
    }

    protected function loadFile(string $path, bool $mustExist): void
    {
        if (! is_file($path) && $mustExist) {
            throw new InvalidArgumentException(
                'File does not exist: "' . $path . '"'
            );
        }

        $this->require($path);
    }

    protected function require(string $path): void
    {
        $require = static function ($path) {
            require $path;
        };

        $require($path);
    }
}
