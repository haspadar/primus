<?php

declare(strict_types=1);

namespace Primus\Decimal;

use Override;
use Primus\Text\Text;
use Primus\Text\TextOf;

/**
 * Cached version of a {@see Decimal}.
 *
 * Evaluates `asString()` at most once and stores the numeric-string result.
 * Subsequent `asInt()`/`asFloat()`/`asText()`/`asString()` calls derive their
 * values from the cached string instead of re-traversing the origin's
 * decorator graph.
 *
 * The numeric-string projection is chosen as canonical because it is the
 * lossless form for arbitrary-precision decimals. Derived accessors use
 * PHP casts on top of the cached string: `asInt()` truncates toward zero
 * (`(int) $string`), `asFloat()` downcasts within float53 precision
 * (`(float) $string`). Origins whose own `asInt`/`asFloat` would round
 * differently — or whose `asFloat` would retain mantissa bits beyond
 * `(float) $string` — see the cast semantics here, not the origin's.
 *
 * This class is not thread-safe.
 *
 * Example:
 *     $cached = new Sticky(new SumOf(...));
 *     $cached->asString(); // computed once, walks the tree
 *     $cached->asString(); // cached
 *     $cached->asFloat(); // derived from the cached string, no extra traversal
 */
final class Sticky implements Decimal
{
    /** @phpstan-ignore haspadar.immutable (lazy memoization flag; idempotent externally) */
    private bool $computed = false;

    /**
     * @var numeric-string
     * @phpstan-ignore haspadar.immutable (lazy memoization slot; idempotent externally)
     */
    private string $stored = '0';

    /**
     * Ctor.
     *
     * @param Decimal $origin The decimal whose projection is cached.
     */
    public function __construct(private readonly Decimal $origin) {}

    #[Override]
    public function asInt(): int
    {
        return (int) $this->asString();
    }

    #[Override]
    public function asFloat(): float
    {
        return (float) $this->asString();
    }

    #[Override]
    public function asText(): Text
    {
        return TextOf::str($this->asString());
    }

    #[Override]
    public function asString(): string
    {
        if (!$this->computed) {
            $this->stored = $this->origin->asString();
            $this->computed = true;
        }

        return $this->stored;
    }
}
