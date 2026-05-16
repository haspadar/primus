<?php

declare(strict_types=1);

namespace Primus\Decimal;

use Override;
use Primus\Number\Sticky as NumberSticky;
use Primus\Text\Text;

/**
 * Cached version of a {@see Decimal}.
 *
 * Delegates int, float and text caching to {@see NumberSticky} and adds
 * its own slot for the numeric-string projection so each origin call
 * happens at most once.
 *
 * Example:
 *     $cached = new Sticky(new SumOf(...));
 *     $cached->asString(); // computed once, walks the tree
 *     $cached->asString(); // cached
 */
final class Sticky implements Decimal
{
    private readonly NumberSticky $delegate;

    /** @phpstan-ignore haspadar.immutable (lazy memoization flag; idempotent externally) */
    private bool $stringComputed = false;

    /**
     * @var numeric-string
     * @phpstan-ignore haspadar.immutable (lazy memoization slot; idempotent externally)
     */
    private string $stringStored = '0';

    /**
     * Ctor.
     *
     * @param Decimal $origin The decimal whose projections are cached.
     */
    public function __construct(private readonly Decimal $origin)
    {
        $this->delegate = new NumberSticky($origin);
    }

    #[Override]
    public function asInt(): int
    {
        return $this->delegate->asInt();
    }

    #[Override]
    public function asFloat(): float
    {
        return $this->delegate->asFloat();
    }

    #[Override]
    public function asText(): Text
    {
        return $this->delegate->asText();
    }

    #[Override]
    public function asString(): string
    {
        if (!$this->stringComputed) {
            $this->stringStored = $this->origin->asString();
            $this->stringComputed = true;
        }

        return $this->stringStored;
    }
}
