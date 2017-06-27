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

## Design Goals

1. **Expressive, Declarative syntax**.
2. **Encapsulate real-world ideas in testing language**, i.e. bugs are specialist
   test cases, to separate design from maintenance.
3. **No removal of repetition**, i.e. no `setup`/`tearDown` handling; these lead to
   developers having convenience for repeating code rather thinking about _why_
   they are unhappy repeating the code. For example, is the unit recieving
   too many inputs, supposing bloat?
4. **No mock object support**. Similar to the above, but also have a general
   tendancy to prompt developers to look at internal rather than external
   behaviour. If we have a dependency, generally we should use a real version
   of that dependency, rather than a mock.
5. **Limited assertions, front and centre**. Assertions to be injected into
   cases, reducing the elegance of the test. If you have too many injections,
   that impacts on the readability of the test, prompting that there are too
   many things being tested and that the design is possibly flawed. Limited
   amount of actual assertions available to the user to prevent convenience
   reducing design quality.









