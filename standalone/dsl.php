<?php

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
