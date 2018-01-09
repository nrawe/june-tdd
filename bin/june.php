<?php

require_once __DIR__ . '/../vendor/autoload.php';

use League\CLImate\CLImate;
use June\Framework\Runtime\{Loader, Harness, Runner};
use function June\harness;

$runner  = new Runner(new CLImate);
$harness = harness(new Harness(new Loader, $runner));
$harness->path($argv[1] ?? getcwd() . '/tests');

exit($harness->run());
