<?php

declare(strict_types=1);

namespace Primus\Integer;

use Override;
use Primus\Text\Text;
use Primus\Text\TextOf;

/**
 * Cached version of an {@see Integer}.
 *
 * Evaluates `asInt()` at most once and stores the result. Subsequent
 * `asInt()`/`asFloat()`/`asText()` calls derive their values from the cached
 * integer, never re-traversing the origin's decorator graph. Suitable for
 * deep aggregate trees where each projection would otherwise walk the
 * structure independently.
 *
 * This class is not thread-safe.
 *
 * Example:
 *     $cached = new Sticky(new SumOf(...$deepTree));
 *     $cached->asInt(); // computed once, traverses the tree
 *     $cached->asInt(); // cached
 *     $cached->asFloat(); // derived from the cached int, no extra traversal
 */
final class Sticky implements Integer
{
    /** @phpstan-ignore haspadar.immutable (lazy memoization flag; idempotent externally) */
    private bool $computed = false;

    /** @phpstan-ignore haspadar.immutable (lazy memoization slot; idempotent externally) */
    private int $stored = 0;

    /**
     * Ctor.
     *
     * @param Integer $origin The integer whose projection is cached.
     */
    public function __construct(private readonly Integer $origin) {}

    #[Override]
    public function asInt(): int
    {
        if (!$this->computed) {
            $this->stored = $this->origin->asInt();
            $this->computed = true;
        }

        return $this->stored;
    }

    #[Override]
    public function asFloat(): float
    {
        return (float) $this->asInt();
    }

    #[Override]
    public function asText(): Text
    {
        return TextOf::str((string) $this->asInt());
    }
}
