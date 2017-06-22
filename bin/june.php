<?php

require_once __DIR__ . '/../vendor/autoload.php';

$container = Illuminate\Container\Container::getInstance();

$container->singleton(June\Framework\Harness::class, function ($app) {

    return new June\Framework\Harness(
        $app->make(June\Framework\Reporter::class),
        $app->make(June\Framework\Stats::class)
    );
});

$application = new June\Console\Application($container, '1.0.0');
$application->resolveCommands([
    June\Console\Commands\RunCommand::class,
]);

$application->run();
