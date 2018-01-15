# June
> A clean, small and modern unit testing framework for PHP

I wrote this framework as a bit of a whim based on my experiences on writing
[tapped](https://github.com/nrawe/tapped), but actually... I quite like it!

The goal of this framework is to provide a syntatically clean way of structuring
tests, leveraging language improvements in PHP. Its founding principle is that
TDD is about finding **designs**, not **bugs**. We still need to provide cases
for bugs, but they're not the day one most important thing.

My experience with the current array of testing frameworks is that they don't
really provide a clear separation of these concepts in their Domain Specific
Languages and they can sometimes be a bit cumbersome to work with. I've tried
to make this a doddle to learn and use.


## Running tests
```bash
php /path/to/june.phar [file]
```

By default, the framework assumes that the tests should be run from the `tests/`
directory in the current working directory. If an argument is passed, it is
assumed to be the file path to the test that needs to be run.


## A basic test
```php
<?php
// tests/CalculatorTest.php

use Calculator;
use function June\{unit, test};

unit(Calculator::class, function () {

    test('It can perform addition', function ($equals) {

        $calculator = new Calculator();

        $equals($calculator->add(1, 1), 2);
    });

});
```

This is as simple as it gets. Using the `use function` syntax, you can import
in the testing framework functions. The `unit()` function groups the steps which
need to be performed in order verify correct function, and the `test()` function
defines what needs to be tested.

The callback provided to `test()` can optionally request assertions to be
injected, in this case `$equals`. These assertions are invoked as a
function and always take the form of `assertion($actual, $expected)`.

The reason that assertions are exposed in this fashion is to provide a bit of
a steer on code quality. If you write a test with a lot of assertions, it's
might be an indication that there's something wrong with the design. To achieve
this, we provide a visual cue via the length of the callback signature that
this may not be optimal.

The list of available assertions is [here](README.md#available-assertions).

## Bugs
```php
<?php
// tests/CalculatorTest.php

use Calculator;
use function June\{bug, unit, test};

unit(Calculator::class, function () {

    test('It can perform addition', function ($equals) {

        $calculator = new Calculator();

        $equals($calculator->add(1, 1), 2);
    });

    bug('Some weird edge case with additions', function ($equals) {
        $calculator = new Calculator();

        $equals($calculator->add(1, 4), 5);
    });

});
```

We've all been there: code done broke. We have to fix it. Really, bugs shouldn't
effect the overall design of a unit and so the framework provides a semantic
differential of these types of cases. When you're looking through, you can get
a feel for the kinds of bugs that have been discovered and this might give you
an indication about the quality of the units' design.

## Disabling tests
```php
<?php
// tests/CalculatorTest.php

use Calculator;
use function June\{unit, xbug, xtest};

unit(Calculator::class, function () {

    xtest('It can perform addition', function ($equals) {

        $calculator = new Calculator();

        $equals($calculator->add(1, 1), 2);
    });

    xbug('Some weird edge case with additions', function ($equals) {
        $calculator = new Calculator();

        $equals($calculator->add(1, 4), 5);
    });

});
```

Sometimes we need to disable a failing test. The framework provides an `xbug()`
and `xtest()` function, similar to other frameworks, to allow you to quickly
disable a test without having to get your comment on.

## Debugging
```php
<?php
// tests/CalculatorTest.php

use Calculator;
use function June\{unit, test, tinker};

unit(Calculator::class, function () {

    test('It can perform addition', function ($equals) {

        $calculator = new Calculator();

        tinker();

        $equals($calculator->add(1, 1), 2);
    });

});
```

Sometimes, you just need to get into the runtime to understand your test. The
framework provides the `tinker()` helper function to do just that. When you
have `psy/psysh` installed and invoke this function, a debug shell will be
brought up so you can interact with the currently running step.


## Available Assertions
* `$equals($actual, $expected)` returns whether the two arguments are strictly equal
* `$unequal($actual, $expected)` returns whether the two are strictly unequal


## License
[MIT Licensed](LICENSE), go bat-nuts crazy.
