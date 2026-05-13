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
$result = array_values(array_filter([3, 1, 4, 1, 5], fn ($x) => $x > 2));
sort($result);
```

Primus reads top to bottom — each step is a named object:

```php
(new Sorted(
    new Filtered(
        new ListOf(3, 1, 4, 1, 5),
        new PredicateOf(fn (int $x) => $x > 2),
    ),
))->value();
```

The pipeline is a value itself: store it, pass it around, decorate it further.
Reading the result is always explicit — call `value()`.

## Installation

```bash
composer require haspadar/primus
```

## Why?

- **The pipeline is a value.**  
  Build it, pass it, store it, decorate it further. Nothing runs until `value()`.

  You can return a pipeline from a function, cache it, or wrap it in
  retry/logging — things you can't do with a procedural chain.

  ```php
  $headline = new Lowered(new Trimmed(new TextOf($raw)));
  $cached   = new Sticky(new ScalarOf(fn () => $headline->value()));
  // No work done yet.
  ```

- **Constructors only remember.**  
  No I/O, no branches, no work in `__construct` — just dependency capture.

  You can substitute `RandomBytes` with a fixed `BytesOf` in tests — no
  framework, no mocking library, just a different constructor argument.

  ```php
  $uuid = new UuidV4(new RandomBytes(16));
  $hex  = new HexEncoded($uuid);
  ```

- **Every operation is a class.**  
  Named types replace anonymous `array`/`string`/`callable`.

  You can extend `Mapped` by wrapping it, not by passing more flags.
  A `Logged(new Mapped(...))` decorator works the same way.

  ```php
  $doubled = new Mapped(
      new ListOf(1, 2, 3),
      new FuncOf(fn (int $x): int => $x * 2),
  );
  ```

- **No `null`, no mutation, no statics.**  
  Missing input fails fast; state is `readonly`; behaviour belongs to instances.

  You can pass a `Number` deep into your code without `?Number` types or
  null-guards at every boundary.

  ```php
  $n = new NumberOfText(new TextOf('42'));  // throws on bad input — never returns null
  $n->asInt();                              // 42
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

To unwrap an exception chain to its underlying cause:

```php
try {
    $repo->save($entity);
} catch (\Throwable $e) {
    $root = (new RootCause($e))->value();
    logger()->error($root->getMessage());
}
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

To run a side-effect over every list element:

```php
(new ForEach_(
    new ListOf('a', 'b', 'c'),
    new ProcOf(fn (string $s) => error_log($s)),
))->exec();
```

## Numbers

To parse and read a numeric value:

```php
$n = new NumberOfText(new TextOf('42'));
$n->asInt();    // 42
$n->asFloat();  // 42.0
```

To aggregate a list of numbers:

```php
$total = (new SumOf(
    new NumberOf(10),
    new NumberOf(20),
    new NumberOf(12),
))->asFloat();
// 42.0

$avg = (new AvgOf(new NumberOf(1), new NumberOf(2), new NumberOf(3)))->asFloat();
// 2.0
```

## Time

To capture and format the current moment:

```php
$now = new Now();
(new Iso($now))->value();
// e.g. "2026-05-13T07:14:00+00:00"
```

To parse an existing timestamp:

```php
$ts = new TimeOf('2026-05-12T12:00:00Z');
$ts->value()->format('Y-m-d'); // "2026-05-12"
```

## Bytes

To hash and hex-encode raw bytes:

```php
$digest = (new HexEncoded(new Sha256(new BytesOf('hello'))))->value();
// "2cf24dba5fb0a30e26e83b2ac5b9e29e1b161e5c1fa7425e73043362938b9824"
```

To generate a UUID v4 from injectable randomness:

```php
$uuid = (new HexEncoded(new UuidV4(new RandomBytes(16))))->value();
// 32 lowercase hex chars
```

To make a time-ordered UUID v7 — sortable, ideal for database keys:

```php
$uuid = (new HexEncoded(new UuidV7(new Now(), new RandomBytes(10))))->value();
```

## Design rules

Every primitive in this library is built to the same set of rules. They
explain what you can expect from any class you pick and how your own
extensions should look.

- **`final readonly` classes.**  
  Every instance is a value — safe to share, pass, decorate, without
  defensive copies. There are no setters and no inheritance points for
  "convenience" overrides.

- **No work in constructors.**  
  Building a graph of objects is always free — no I/O, no parsing, no
  branching. Failures surface in the computation method (`value()` /
  `asInt()` / `exec()` …), at the call site that asked for the result.

- **One class, one behaviour.**  
  When you need two behaviours, compose two classes. Memoization is
  `Sticky`. Fallback on failure is `FuncWithFallback`. Iteration with
  side-effect is `ForEach_`. No class carries a flag that toggles its
  behaviour.

- **Composition over inheritance.**  
  Every class is `final`. You change behaviour by **wrapping** an object,
  not by subclassing it.

- **No `null` ever.**  
  No method returns it, no method accepts it. There is no `?Text`, no
  `?Number`. Missing data fails fast at the boundary with a real exception.

- **No `static`, no `isset`, no `empty`.**  
  Behaviour belongs to instances, never to classes. Signatures must be
  honest — no hidden "I might be absent" checks.

- **No getters and setters.**  
  A class exposes **behaviour**, not data. `name()` returns a value
  because asking is a behaviour; there is no `setName()` because changing
  state means constructing a new object.

- **Computation is lazy.**  
  Nothing runs until you call the computation method. A pipeline built
  with ten decorators costs no CPU until you ask for `value()`.

Enforced by [`haspadar/sheriff`](https://github.com/haspadar/sheriff) — a
curated bundle of PHPStan level 9, Psalm with custom EO rules,
PHP‑CS‑Fixer, PHPMD, PHPMetrics, Infection, and repository lints.

Inspired by [Elegant Objects](https://www.elegantobjects.org) (Yegor
Bugayenko) and [cactoos](https://github.com/yegor256/cactoos).

## Requirements

PHP **8.3+**.

## Working with AI agents

Using an AI coding assistant (Claude Code, Codex, Cursor, Aider, …) with
this library? See [`AGENTS.md`](AGENTS.md) for the namespace map,
composition contract, antipatterns, and a step-by-step guide for adding
new primitives.

## License

[MIT](LICENSE)
