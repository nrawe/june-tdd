<?php

namespace June\Framework\Runtime;

use June\Framework\Exceptions\BadUserException;
use function June\Framework\{ends_with, starts_with};
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

/**
 * Handles the loading of tests into memory.
 */
class Loader
{
    /**
     * Loads the file or files in the directory pointed to by $path into memory.
     * 
     * Test files must be suffixed with `Test.php` to be included.
     */
    public function load(string $path): void
    {
        if (is_dir($path)) {
            $this->loadDirectory($path);
            return;
        }
     
        if ($this->isValidTestFile($path)) {
            $this->loadFile($path);
            return;
        }

        throw BadUserException::new(
            BadUserException::TEST_FILE_MALFORMED, ['name' => $path]
        );
    }

    /**
     * Returns whether the given file name is valid for inclusion.
     */
    protected function isInvalidTestFile(string $file): bool
    {
        return ! ends_with($file, 'Test.php');
    }

    /**
     * Returns whether the given file name is not valid for inclusion.
     */
    protected function isValidTestFile(string $file): bool
    {
        return ! $this->isInvalidTestFile($file);
    }

    /**
     * Attempts to load test files in the given directory.
     */
    protected function loadDirectory(string $path): void
    {
        foreach (new RecursiveDirectoryIterator($path) as $file) {
            if ($this->isValidTestFile($file)) {
                $this->loadFile($file, false);
            }
        }
    }

    /**
     * Attempts to load a test file.
     */
    protected function loadFile(string $path, bool $mustExist = true): void
    {
        if (! is_file($path) && $mustExist) {
            throw BadUserException::new(
                BadUserException::TEST_FILE_NONEXISTANT, ['name' => $path]
            );
        }

        $this->require($path);
    }

    /**
     * Provides a scope isolated require.
     */
    protected function require(string $path): void
    {
        $require = static function ($path) {
            require $path;
        };

        $require($path);
    }
}
