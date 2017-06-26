# June -- A small, simple TDD Framework for PHP

The goal of this framework is to help developers _design their units
effectively_. TDD is *not about finding bugs*, but instead is *about finding
designs*. Getting the design for a unit requires us to *think small*. This
framework introduces constraints which are designed to help us *think small*.

The key goal is to enable developers to feel resistence while they are writing
their tests, so that they can rethink their design as they go. The more elegant
their tests, the more likely that they have a single Unit, and not multiple
Units.

It should be noted that the right Unit size is not about Single Responsibility
Principle. SRP is a good rule of thumb but cannot always be applied. So, while
it does suggest it, it isn't required to follow this principle.

An example of a test in June looks like--

```php
<?php

use function June\{unit, test, bug};

unit(Calculator::class, function () {

    test('2 + 2', function ($equal) {
        $calculator = new Calculator();

        $equal(
            $calculator->add(2, 2), 4
        );
    });

});

```

You can then run `$ june.phar path/to/test.php` to run just that individual
test. If you want to run all tests, run `$ june.phar` in a directory which
contains a `tests` folder, or `$ june.phar path/to/tests/`.

