<?php

declare(strict_types=1);

namespace Primus\Integer;

use Override;
use Primus\Number\Sticky as NumberSticky;
use Primus\Text\Text;

/**
 * Cached version of an {@see Integer}.
 *
 * Delegates memoization to {@see NumberSticky} and narrows the entry type to
 * {@see Integer} on the constructor and the implemented interface.
 *
 * Example:
 *     $cached = new Sticky(new SumOf(...$deepTree));
 *     $cached->asInt(); // computed once, traverses the tree
 *     $cached->asInt(); // cached
 */
final readonly class Sticky implements Integer
{
    private NumberSticky $delegate;

    /**
     * Ctor.
     *
     * @param Integer $origin The integer whose projections are cached.
     */
    public function __construct(Integer $origin)
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
}
