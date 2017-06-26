<?php

//
// Builds the june.php script which can be used as a really simple test runner.
//

$compiled = start();

foreach (new FilesystemIterator(__DIR__ . '/standalone') as $file) {

    $contents  = substr(file_get_contents($file), 5);
    $namespace = 'namespace June\Framework;';

    if (strpos($contents, $namespace) !== false) {
        $contents = str_replace(
            $namespace, 'namespace June\Framework {', $contents
        ) . '}';
    }

    $compiled .= $contents . PHP_EOL;
}

$compiled .= finish();

file_put_contents('june.php', $compiled);







function start(): string
{
        return <<<'STUB'
#!/usr/bin/env php
<?php

STUB;
}

function finish(): string
{
    return <<<'STUB'

namespace {

    use June\Framework\{Loader, Harness};

    $harness = new Harness(new Loader);
    $harness->path($argv[1] ?? getcwd() . '/tests');

    exit($harness->run());
}

STUB;
}
