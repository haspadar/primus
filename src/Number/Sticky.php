<?php

declare(strict_types=1);

namespace Primus\Number;

use Override;

/**
 * Cached version of a {@see Number}.
 *
 * Evaluates each projection (asInt, asFloat) at most once and stores the
 * result. Subsequent calls return the cached value instead of re-traversing
 * the underlying decorator graph.
 *
 * This class is not thread-safe. To share cached data across threads use an
 * external synchronization mechanism.
 *
 * Example:
 *     $cached = new Sticky(new SumOf(...$deepTree));
 *     $cached->asFloat(); // computed once, traverses the tree
 *     $cached->asFloat(); // cached
 *     $cached->asInt(); // computed once, traverses the tree
 *     $cached->asInt(); // cached
 */
final class Sticky implements Number
{
    private const int EMPTY_INT = 0;
    private const float EMPTY_FLOAT = 0.0;

    /** @phpstan-ignore haspadar.immutable (lazy memoization flag; idempotent externally) */
    private bool $intComputed = false;

    /** @phpstan-ignore haspadar.immutable (lazy memoization slot; idempotent externally) */
    private int $intStored = self::EMPTY_INT;

    /** @phpstan-ignore haspadar.immutable (lazy memoization flag; idempotent externally) */
    private bool $floatComputed = false;

    /** @phpstan-ignore haspadar.immutable (lazy memoization slot; idempotent externally) */
    private float $floatStored = self::EMPTY_FLOAT;

    /**
     * Ctor.
     *
     * @param Number $origin The number whose projections are cached.
     */
    public function __construct(private readonly Number $origin) {}

    #[Override]
    public function asInt(): int
    {
        if (!$this->intComputed) {
            $this->intStored = $this->origin->asInt();
            $this->intComputed = true;
        }

        return $this->intStored;
    }

    #[Override]
    public function asFloat(): float
    {
        if (!$this->floatComputed) {
            $this->floatStored = $this->origin->asFloat();
            $this->floatComputed = true;
        }

        return $this->floatStored;
    }
}
