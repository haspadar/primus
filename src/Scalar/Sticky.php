<?php

declare(strict_types=1);

namespace Primus\Scalar;

use Override;

/**
 * Cached version of a {@see Scalar}.
 *
 * Evaluates the wrapped scalar once and stores the result in memory.
 * Subsequent calls to {@see value()} return the same cached value.
 *
 * This class is not thread-safe. To share cached data across objects,
 * use an external cache or synchronization mechanism.
 *
 * Construction forms:
 *
 * - `new Sticky(Scalar)` — wrap a {@see Scalar} value.
 * - `Sticky::ofScalar(Scalar)` — named-constructor alias of the primary ctor.
 *
 * Example:
 *     $scalar = Sticky::ofScalar(new ScalarOf(fn() => time()));
 *     echo $scalar->value(); // computed once
 *     echo $scalar->value(); // cached value
 *
 * @template T
 * @implements Scalar<T>
 */
final class Sticky implements Scalar
{
    /** @phpstan-ignore haspadar.immutable (lazy memoization flag; idempotent externally) */
    private bool $computed = false;

    /**
     * @var T
     * @psalm-suppress PropertyNotSetInConstructor Lazy-initialized in value()
     * @phpstan-ignore haspadar.immutable (lazy memoization slot; idempotent externally)
     */
    private $stored;

    /**
     * Ctor.
     *
     * @param Scalar<T> $origin The scalar whose value is cached.
     */
    public function __construct(private readonly Scalar $origin) {}

    /**
     * Memoises the value of a {@see Scalar}.
     *
     * @template U
     * @param Scalar<U> $scalar The scalar whose value is cached.
     * @return self<U>
     * @psalm-api
     */
    public static function ofScalar(Scalar $scalar): self
    {
        return new self($scalar);
    }

    #[Override]
    public function value()
    {
        if (!$this->computed) {
            $this->stored = $this->origin->value();
            $this->computed = true;
        }

        return $this->stored;
    }
}
