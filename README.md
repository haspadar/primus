<picture>
    <source media="(prefers-color-scheme: dark)" srcset="assets/primus-banner-light.svg">
    <source media="(prefers-color-scheme: light)" srcset="assets/primus-banner-dark.svg">
    <img alt="Primus logo" width="280" src="assets/primus-banner-light.svg">
</picture>
<br><br>

[![CI](https://github.com/haspadar/primus/actions/workflows/sheriff.yml/badge.svg)](https://github.com/haspadar/primus/actions/workflows/sheriff.yml)
[![Coverage](https://codecov.io/gh/haspadar/primus/branch/main/graph/badge.svg)](https://codecov.io/gh/haspadar/primus)
[![Mutation testing badge](https://img.shields.io/endpoint?style=flat&url=https%3A%2F%2Fbadge-api.stryker-mutator.io%2Fgithub.com%2Fhaspadar%2Fprimus%2Fmain)](https://dashboard.stryker-mutator.io/reports/github.com/haspadar/primus/main)
[![PHPStan Level](https://img.shields.io/badge/PHPStan-Level%209-brightgreen)](https://phpstan.org/)
[![Psalm Level](https://img.shields.io/badge/Psalm-Level%201-brightgreen)](https://psalm.dev/)

---

# Object‑Oriented PHP Primitives

Primus is a library of object‑oriented PHP primitives.
It provides common operations as small composable objects instead of functions.

Procedural PHP buries the steps inside out — you read from the innermost call:

```php
strtolower(trim(substr($s, 0, 5)));
```

Primus reads top to bottom — each step is a named object:

```php
(new Lowered(
    new Trimmed(
        new Sub(new TextOf($s), 0, 5),
    ),
))->value();
```

The pipeline is a value itself: store it, pass it around, decorate it further.
Reading the result is always explicit — call `value()`.

## Why?

- **`null` everywhere.**  
  PHP's standard library leaks `null` through `array_search`, `preg_match`,
  `mb_strpos` even if you ban it in your project. Primus values are never
  `null` — missing input fails fast.

- **Bare `array` shapes.**  
  Procedural functions take `array`/`string` and you re‑describe their shape
  with PHPDoc at every call site. In Primus the type lives in the class —
  each operation has a narrow constructor signature you write once.

- **Closures hard to substitute.**  
  A `callable` is convenient until you need to swap it in a test, log every
  call, or wrap it in retry logic. A `Func`/`Predicate`/`BiFunc` object
  composes like any other class.

- **Controlled flow.**  
  Procedural chains run as you write them. A Primus pipeline runs only when
  `value()` is called — building, passing and composing it costs nothing
  until you ask for the result.

## Installation

```bash
composer require haspadar/primus
```

## Text

To trim and lowercase:

```php
$text = (new Lowered(new Trimmed(new TextOf('  Hello  '))))->value();
// "hello"
```

To take a substring:

```php
$text = (new Sub(new TextOf('Hello, world!'), 0, 5))->value();
// "Hello"
```

## Lists

To filter and sort:

```php
$big = (new Sorted(
    new Filtered(
        new ListOf(3, 1, 4, 1, 5, 9, 2, 6),
        new PredicateOf(static fn (int $x): bool => $x > 2),
    ),
))->value();
// [3, 4, 5, 6, 9]
```

To pluck a column from a list of rows:

```php
$names = (new Plucked(
    new ListOf(
        ['id' => 1, 'name' => 'Alice'],
        ['id' => 2, 'name' => 'Bob'],
    ),
    'name',
))->value();
// ['Alice', 'Bob']
```

## Maps

To merge two maps with last‑wins precedence:

```php
$merged = (new Merged(
    new MapOf(['a' => 1, 'b' => 2]),
    new MapOf(['b' => 99, 'c' => 3]),
))->value();
// ['a' => 1, 'b' => 99, 'c' => 3]
```

To index a list of rows by one column, with values from another:

```php
$byId = (new PluckedBy(
    new ListOf(
        ['id' => 1, 'name' => 'Alice'],
        ['id' => 2, 'name' => 'Bob'],
    ),
    'id',
    'name',
))->value();
// [1 => 'Alice', 2 => 'Bob']
```

## Scalars

To compose lazy boolean logic:

```php
$between = (new And_(
    new GreaterThan(new Constant(5), new Constant(0)),
    new LessThan(new Constant(5), new Constant(10)),
))->value();
// true
```

To memoize an expensive computation:

```php
$cached = new Sticky(
    new ScalarOf(static fn () => expensive_computation()),
);
$cached->value(); // expensive_computation() runs once
$cached->value(); // cached
```

## Functions

To wrap a callable as a reusable, swappable object:

```php
$double = new FuncOf(static fn (int $x): int => $x * 2);
$double->apply(21);
// 42
```

To memoize a function by its input:

```php
$cached = new StickyFunc(
    new FuncOf(static fn (int $id): User => $repo->find($id)),
);
$cached->apply(1); // hits the repo
$cached->apply(1); // cached
```

To fall back to another function on failure:

```php
$safe = new FuncWithFallback(
    new FuncOf(static fn (string $url): string => http_get($url)),
    new FuncOf(static fn (string $url): string => ''),
);
```

## Design rules

- No `null`, no `static` methods or properties, no `isset()`/`empty()`
- All state `readonly`, all classes `final`
- One class = one behavior; composition over inheritance
- Computation is lazy until `value()`

Enforced by [`haspadar/sheriff`](https://github.com/haspadar/sheriff) — a curated
bundle of PHPStan level 9, Psalm with custom EO rules, PHP‑CS‑Fixer, PHPMD,
PHPMetrics, Infection, and repository lints.

Inspired by [Elegant Objects](https://www.elegantobjects.org) and
[cactoos](https://github.com/yegor256/cactoos).

## Requirements

PHP **8.3+**.

## License

[MIT](LICENSE)
