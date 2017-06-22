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
