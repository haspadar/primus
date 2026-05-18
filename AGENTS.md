# AGENTS.md

Guidance for AI agents (Claude Code, Codex, Cursor, Aider, Gemini CLI,
Continue, and any tool that respects the `agentsmd.org` convention) when
working **with** the `haspadar/primus` library — either as a consumer
through Composer or as a contributor inside the repository.

This file is the public agent contract. Read it before touching the code.

**Required prerequisite:** read [`README.md`](README.md) first. It covers
what Primus is, the philosophy (`Why?`), and themed end-user examples
(Text, Lists, Maps, Scalars, Functions, Numbers, Time, Bytes). This file
does **not** repeat that material — it adds what an agent needs on top.

Supports PHP `~8.3.16 || ~8.4.3 || ~8.5.0`.

---

## How to discover classes

Every class lives under `src/<Namespace>/<ClassName>.php`. To find what's
available without grepping the world:

```sh
ls src/                      # list namespaces
ls src/Text/                 # classes in a namespace
```

Every class has a PHPDoc summary plus a runnable usage example. To get
the exact constructor signature and return type, read the file directly —
do **not** guess.

### Namespace map

The lists below are highlights, not exhaustive. Run `ls src/<Namespace>/`
for the full inventory and read the PHPDoc on each class. Most namespaces
also have an `<Namespace>Envelope` abstract class that simplifies writing
new decorators — extend it to inherit interface compliance for free.

Classes marked `@internal` in PHPDoc (e.g. delegates of named-constructor
factories) are reachable via autoload but are not part of the public API.
They are omitted from the lists below and may change without a deprecation
cycle. Compose through the documented public surface instead.

- **`Primus\Text`** — string operations.
  `TextOf`, `Trimmed`, `TrimmedLeft`, `TrimmedRight`, `Lowered`, `Uppered`,
  `Sub`, `HtmlEscaped`, `WithoutTags`, `Mapped` (string→string transform),
  `Joined`, `Repeated`, `Replaced`, `Split`, `Capitalized`, `Normalized`,
  `Abbreviated`, `LeftPadded`, `RightPadded`, `IsEmpty`, `LengthOfText`,
  `RandomText`, `TextEnvelope`.

- **`Primus\List`** — ordered list operations over `List_<T>` (the
  trailing underscore avoids the reserved keyword).
  `ListOf`, `Filtered`, `Mapped`, `Sorted`, `SortedBy`, `Plucked`, `Unique`,
  `NoNulls`, `Chunks`, `Sliced`, `Range`, `Reversed`, `Joined`,
  `Contains`, `IndexOf`, `Difference`, `Intersection`, `ListEnvelope`.

- **`Primus\Map`** — associative-map operations over `Map<K, V>`.
  `MapOf`, `Merged`, `Combined`, `PluckedBy`, `Filtered`, `Mapped`,
  `BiFiltered`, `BiMapped`, `NoNulls`, `Diff`, `DiffAssoc`, `Intersect`,
  `IntersectAssoc`, `Keys`, `Values`, `Sliced`, `Unique`, `MapEnvelope`.

- **`Primus\Scalar`** — generic `Scalar<T>` plus boolean and control
  primitives.
  `ScalarOf`, `Constant`, `Sticky` (memoize), `Ternary`, `And_`, `Or_`,
  `Not`, `Xor_`, `RootCause` (unwrap a Throwable chain), `ScalarEnvelope`.

- **`Primus\Number`** — root numeric contract.
  `Number` interface with three projections (`asInt()`, `asFloat()`,
  `asText()`). Memoization is provided per-family, not at this level —
  see `Integer\Sticky` and `Decimal\Sticky`.

- **`Primus\Integer`** — whole-number primitives backed by native PHP
  int arithmetic. `Integer` interface (marker extending `Number`),
  `IntegerOf`, `SumOf`, `MultOf`, `MaxOf`, `MinOf`, `DivOf` (truncating),
  `ModOf`, `Abs`, `Sticky` (caches `asInt`, derives `asFloat`/`asText`).

- **`Primus\Decimal`** — arbitrary-precision decimal primitives backed
  by bcmath. `Decimal` interface (marker extending `Number`) with a
  fourth projection `asString(): numeric-string` ready for bcmath
  consumption. Wrappers `DecimalOf`, `DecimalOfFloat`, `DecimalOfInt`,
  `DecimalOfScalar` (lazy from a `Scalar<numeric-string>`). Binary
  aggregates `SumOf`, `MultOf`, `MaxOf`, `MinOf`, `DivOf`, `ModOf`, and
  unary `Abs` each take an explicit `int $scale`. `DecimalEnvelope` base class
  removes projection boilerplate from aggregates. `Sticky` caches the
  numeric-string projection and derives the other accessors from it.

- **`Primus\Time`** — `DateTimeImmutable` wrappers.
  `Time` interface, `TimeOf` (wrap a string or `DateTimeImmutable`),
  `Iso` (format as ISO 8601 string). Sources of the current moment stay
  on the caller (`new TimeOf(new DateTimeImmutable())`).

- **`Primus\Bytes`** — byte-sequence primitives.
  `Bytes` interface, `BytesOf`, `Base64Encoded`, `Base64Decoded`,
  `HexEncoded`, `HexDecoded`, `Md5`, `Sha256`. Random byte sources stay
  on the caller (`new BytesOf(random_bytes(...))`).

- **`Primus\Func`** — function-as-object primitives.
  `Func<I, O>` (`apply()`; use `Func<T, bool>` for boolean predicates),
  `Proc<X>` (`exec()`, side-effect), plus `FuncOf`, `BiFunc`/`BiFuncOf`,
  `ProcOf`, `BiProc`/`BiProcOf`, `StickyFunc`, `FuncWithFallback`,
  `Repeated`, `ForEach_` (iterate a `List_` with a `Proc`), `FuncEnvelope`.

---

## Composition rules (binding contract)

These rules describe how Primus objects behave. Code that uses Primus
must respect them, otherwise it will not type-check, will fail the
project's lint gates, or will surprise the caller at runtime.

1. **Construction never executes work.** `new Trimmed(TextOf::str($s))`
   does no string work. Computation happens only when `value()` (or
   `asInt()`/`asFloat()`/`exec()`/etc.) is called.

2. **Computation methods are repeatable but not memoized by default.**
   Each call to `value()` (or its peers) may recompute. A caller that
   feeds a non-deterministic source (e.g. `new BytesOf(random_bytes(16))`
   that is read by the parent decorator on every projection) will see
   different results per call. To freeze a result, wrap in `Sticky`
   (per-namespace memoizer: `Scalar\Sticky`, `Integer\Sticky`,
   `Decimal\Sticky`, `Func\StickyFunc`).

3. **No `null` ever crosses an API boundary.** Constructors take concrete
   typed values; computation methods return concrete typed values.
   Missing data fails fast with an exception, not a `null` return.

4. **Compose by wrapping, not by configuration.** Behaviour changes by
   constructing a new decorator (`Sticky(new ScalarOf(...))`), not by
   passing flags to an existing class.

5. **Interfaces are the substitution points.** Anywhere a class accepts
   `Text`, `Bytes`, `List_<T>`, `Map<K, V>`, `Scalar<T>`, `Number`,
   `Time`, `Func<I, O>`, or `Proc<X>`, you can pass any
   implementation — including a test stub built from a literal value via
   `TextOf` / `BytesOf` / `ListOf` / `Constant`.

---

## What NOT to do

Patterns that look reasonable but are wrong for Primus:

- **Do not call computation methods inside a constructor.**
  `new Trimmed((TextOf::str($s))->value())` is wrong — the inner call
  eagerly extracts the value and breaks composition. Pass the decorator
  object, not its result.

- **Do not mutate instances.** Every concrete class is `final readonly`
  with the sole exception of `Sticky` variants, whose mutation is the
  memoization slot. Trying to clone-with-replacement is a sign you
  picked the wrong decorator — look for an existing one that takes the
  parameter you wanted to mutate.

- **Do not pass raw `null` where a primitive is expected.** There is no
  `?Text`, no `?Number`. If a value is genuinely optional in your
  application logic, that's a higher-level concern — handle it with
  `Ternary`, `Or_`, or explicit branching in caller code.

- **Static methods are reserved for named constructors.** A class whose
  only static methods return `self` (or `static`) — wrapping different
  input forms (`TextOf::str`, `TextOf::scalar`) — is the sanctioned
  PHP analogue of overloaded constructors in Cactoos Java. Anything else
  static (helper methods, factories returning unrelated types, `Trimmed::of`)
  is still forbidden.

---

## Extending: how to add a new primitive

A typical contribution adds one class plus one test file, ~50 lines of
code, fits in a single ~250-line PR.

### 1. Pick the namespace

Match the value's nature, not the operation:

- transforms a string → `src/Text/`
- transforms a list of T → `src/List/`
- transforms an assoc-map → `src/Map/`
- numeric → `src/Number/`
- moment in time → `src/Time/`
- byte sequence → `src/Bytes/`
- generic computation → `src/Scalar/`
- function-like → `src/Func/`

### 2. Decide what it decorates

A Primus class is almost always a **decorator over its own interface**:

```php
final readonly class Trimmed implements Text
{
    public function __construct(private Text $origin) {}
}
```

If the new class produces a `Text` from a `Text`, it implements `Text`
and accepts `Text` in the constructor. Same for `Number → Number`,
`Bytes → Bytes`, etc. Cross-type decorators are also valid: `HexEncoded`
takes `Bytes` and implements `Text`. The constructor parameter is the
"input type"; the implemented interface is the "output type".

### 3. Write the class

Template:

```php
<?php

declare(strict_types=1);

namespace Primus\Text;

use Override;

/**
 * <One-line summary that does NOT start with a digit.>
 *
 * <Optional second paragraph with the "why".>
 *
 * Example:
 *     $value = (new MyDecorator(TextOf::str('input')))->value();
 *     // expected output
 */
final readonly class MyDecorator implements Text
{
    /**
     * Ctor.
     *
     * @param Text $origin <What this dependency represents>.
     */
    public function __construct(private Text $origin) {}

    #[Override]
    public function value(): string
    {
        // All work happens here. Constructor is empty.
        return /* transform $this->origin->value() */;
    }
}
```

Constructor must do **nothing** beyond property capture — no `throw`, no
branches, no I/O. Validation, parsing, anything that can fail belongs
inside the computation method.

### 4. Write the test

Follow Angry Tests: inline `new` of the SUT, no factories, no `setUp`,
no shared state. One behaviour per `#[Test]` method.

```php
<?php

declare(strict_types=1);

namespace Primus\Tests\Text;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Text\MyDecorator;
use Primus\Text\TextOf;

final class MyDecoratorTest extends TestCase
{
    #[Test]
    public function transformsInputDeterministically(): void
    {
        $this->assertSame(
            'expected',
            (new MyDecorator(TextOf::str('input')))->value(),
        );
    }
}
```

Cover edge cases that change behaviour: empty input, boundary values,
error paths. Do not test PHP itself.

### 5. Magic numbers → constants

Any literal except `0`, `1`, `-1` triggers `haspadar.constantUsage`:

```php
private const int UUID_LENGTH = 16;
private const int VERSION_BYTE = 6;
```

Name the constant by **what the number means**, not by its value.

### 6. Run the gate

```sh
vendor/bin/sheriff check        # all linters + tests + mutation
vendor/bin/sheriff fix          # auto-fix what can be auto-fixed
```

Green locally → push. CI re-runs the same checks plus Codecov,
SonarCloud, PR-size, release-label, Infection mutation.

---

## Design principles (with rationale)

Each rule is enforced by a linter; the **why** explains the tradeoff so
you can argue an exception when it really makes sense.

- **`final readonly` classes.**
  Final blocks accidental inheritance; readonly blocks accidental
  mutation. Together they make every instance a value, safe to share,
  pass, and reason about without defensive copying. Exception: the
  `Sticky` variants, whose private memoization slot is the documented
  mutation point.

- **No work in `__construct`.** (`haspadar.constructorInit`)
  Construction must always succeed. If parsing/IO/branching lives in the
  ctor, building a graph of objects can fail unexpectedly, and lazy
  composition stops working. Move work into the computation method.

- **One class = one behaviour.**
  When you need two behaviours, write two classes and compose them. The
  cost is one extra wrapper — the benefit is each class staying testable
  and swappable on its own.

- **No `null`, no `isset`, no `empty`.**
  These make signatures lie. A `?Text` parameter says "this might be
  nothing" and forces every caller to check. Use a real fallback object
  (`Constant`, `Ternary`, `FuncWithFallback`) at the boundary where the
  optionality is decided.

- **No `static` methods or properties beyond named constructors.**
  Static means "behaviour owned by a class, not an instance". You lose
  substitution: you can't swap `Trimmed::of($s)` for a test double.
  The only sanctioned exception is named constructors — static methods
  returning `self`/`static` that wrap different input forms (`TextOf::str`,
  `TextOf::scalar`), playing the role of overloaded constructors absent
  from PHP. Any other static is still forbidden.

- **No procedural helpers, no mutable state.**
  Functions that take an array and mutate it (`sort()`, `array_push()`,
  …) cannot be lazily composed. A Primus decorator returns a new value.

- **One computation method per class.**
  `value()` for generic scalars, `asInt()`/`asFloat()` for `Number`,
  `exec()` for `Proc`. Don't invent new method names; pick the one that
  matches your interface.

- **PHPDoc summary does not start with a digit.** (`haspadar.phpdocStyle`)
  Tools choke on summaries like `16-byte digest...`. Rephrase as
  `Raw 16-byte digest...`.

---

## Quality gates

The pre-push hook and CI run `vendor/bin/sheriff check`. Tools that will
trip your branch:

- **phpstan** (level 9, custom `haspadar.*` rules) — type holes, missing
  PHPDoc on non-trivial constructors, magic numbers, mutable state.
- **psalm** with EO rules — same niche, slightly different angle.
- **phpcs** (PSR-12) — formatting; mostly auto-fixed by `sheriff fix`.
- **php-cs-fixer** — additional formatting passes; also auto-fixable.
- **phpmd** — complexity metrics.
- **phpmetrics** — afferent coupling hard gate (regression fails build).
- **infection** — mutation testing; new code is expected to kill its
  mutations.
- **phpunit** — full test suite; new code is expected at 100% coverage
  on the patch (Codecov gate).
- **typos / markdownlint / yamllint / shellcheck / hadolint** — infra.

Common stumbles:

- "Magic number 16 found" → `private const int NAME = 16;`.
- "Property must be readonly" → mark `private readonly Foo $bar;` or use
  promoted properties.
- "PHPDoc summary starts with a digit" → reorder the summary.
- "Symbol declared but not used" → drop the unused import.

### Suppression policy

Do not add `@phpstan-ignore`, `@psalm-suppress`, `// NOSONAR`, baseline
entries, or equivalents without explicit user approval. Investigate the
root cause first. The only sanctioned suppressions live inside the
`Sticky` variants, where memoization inherently requires a mutable slot.

### CI extras beyond `sheriff check`

- **PR size limit: 500 changed lines** (target ~250). Split larger work.
- **Exactly one release label** (`feat`, `fix`, `refactor`, `docs`,
  `ci`, `chore`, `test`, `dependencies`) unless the PR has
  `skip-changelog`.
- **Codecov** patch coverage on changed lines.
- **SonarCloud** Quality Gate; cryptographic primitives (`Md5`,
  `Sha256`, `Base64*`) trigger Security Hotspots that are marked Safe
  per project policy (this is a primitives library, not auth code).

---

## File layout

```
src/<Namespace>/<ClassName>.php           # production code, one class per file
tests/<Namespace>/<ClassName>Test.php     # one test class per production class
tests/<Namespace>/Fakes/<Name>.php        # named test doubles (PSR-1, autoloaded)
README.md                                  # end-user examples and philosophy
AGENTS.md                                  # this file — agent contract
composer.json                              # package metadata, PHP version range
.sheriff/                                  # generated lint configuration; do not edit
.github/workflows/                         # CI definitions; do not edit
```

---

## Links

- Source: <https://github.com/haspadar/primus>
- Packagist: <https://packagist.org/packages/haspadar/primus>
- Elegant Objects manifesto: <https://www.elegantobjects.org>
- Cactoos (Java inspiration): <https://github.com/yegor256/cactoos>
