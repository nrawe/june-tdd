#!/usr/bin/env php
<?php


namespace June\Framework {

use ReflectionFunction;

class AbstractCase
{
    protected $case;

    protected $name;

    public function __construct(string $name, callable $case)
    {
        $this->case = $case;
        $this->name = $name;
    }

    public function execute()
    {
        try {
            $case = $this->case;
            $case(...$this->assertions());

            $this->pass();

        } catch (AssertionException $e) {
            $this->fail($e);
        }
    }

    protected function assertions(): array
    {
        $assertions = [];
        $reflection = new ReflectionFunction($this->case);

        foreach ($reflection->getParameters() as $parameter) {
            $assertions[] = new Assertion($parameter->getName());
        }

        return $assertions;
    }

    protected function pass()
    {
        echo ' - ', $this->name, ' ✓', PHP_EOL;
    }

    protected function fail()
    {
        echo ' - ', $this->name, ' ✗', PHP_EOL;
    }
}
}


namespace June\Framework {

/**
 * Handles the comparison of values.
 *
 * The class operates as a function which executes the actual comparison when
 * called.
 */
class Assertion
{
    /**
     * The name of the assertion to be called.
     *
     * @var string
     */
    protected $name;

    /**
     * Creates a new instance of the assertion, taking in the name of the
     * assertion to be run when the class is invoked.
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * Calls the assertion.
     */
    public function __invoke(...$args)
    {
        call_user_func_array([$this, $this->name], $args);
    }

    /**
     * Handles the actual assertion, throwing an AssertionException in the
     * instance that the condition is false.
     */
    protected function assert(bool $condition)
    {
        if (! $condition) {
            throw new AssertionException();
        }
    }

    /**
     * Compares arguments for equality.
     */
    protected function equal($a, $b)
    {
        $this->assert($a === $b);
    }

    /**
     * Compares arguments for inequality.
     */
    protected function unequal($a, $b)
    {
        $this->assert($a !== $b);
    }
}
}


namespace June\Framework {

class AssertionException extends \Exception { }
}


namespace June\Framework {

class BugCase extends AbstractCase { }
}


namespace June {

    use June\Framework\{BugCase, TestCase, SkippedBugCase, SkippedTestCase};

    function bug(string $name, callable $case)
    {
        (new BugCase($name, $case))->execute();
    }

    function test(string $name, callable $case)
    {
        (new TestCase($name, $case))->execute();
    }

    function unit(string $unit, callable $tests)
    {
        echo $unit, ': ', PHP_EOL;

        $tests();

        echo PHP_EOL;
    }

    function xbug(string $name, callable $case)
    {
        (new SkippedBugCase($name, $case))->execute();
    }

    function xtest(string $name, callable $case)
    {
        (new SkippedTestCase($name, $case))->execute();
    }
}



namespace June\Framework {

use Throwable;

class Harness
{
    /**
     * The path which we should find files in.
     *
     * @var string
     */
    protected $path;

    public function __construct(Loader $loader)
    {
        $this->loader = $loader;
    }

    public function path(string $path)
    {
        $this->path = $path;
    }

    public function run(): int
    {
        $t = null;

        try {
            $this->loader->load($this->path);

        } catch (Throwable $t) {
            echo $t->getMessage(), PHP_EOL;
        }

        return $t ? -1 : 0;
    }
}
}


namespace June\Framework {

function starts_with(string $haystack, string $needle): bool
{
    return substr($haystack, 0, strlen($needle)) === $needle;
}

function ends_with(string $haystack, string $needle): bool
{
    return substr($haystack, -strlen($needle)) === $needle;
}
}


namespace June\Framework {

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
}


namespace June\Framework {

class SkippedBugCase extends BugCase { }
}


namespace June\Framework {

class SkippedTestCase extends TestCase { }
}


namespace June\Framework {

class TestCase extends AbstractCase { }
}

namespace {

    use June\Framework\{Loader, Harness};

    $harness = new Harness(new Loader);
    $harness->path($argv[1] ?? getcwd() . '/tests');

    exit($harness->run());
}
