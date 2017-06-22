<?php

require_once __DIR__ . '/../vendor/autoload.php';

$container = Illuminate\Container\Container::getInstance();

$application = new June\Console\Application($container, '1.0.0');
$application->resolveCommands([
    June\Console\Commands\TestCommand::class,
]);

$application->run();
