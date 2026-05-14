<?php

declare(strict_types=1);

namespace Primus\Number;

use Override;
use Primus\Text\Text;
use Primus\Text\TextOf;

/**
 * Number lifted from a native int or float scalar.
 *
 * Example:
 *     $n = new NumberOf(3.7);
 *     $n->asInt(); // 3 (truncate)
 *     $n->asFloat(); // 3.7
 */
final readonly class NumberOf implements Number
{
    /**
     * Ctor.
     *
     * @param int|float $value The native numeric scalar to wrap.
     */
    public function __construct(private int|float $value) {}

    #[Override]
    public function asInt(): int
    {
        return (int) $this->value;
    }

    #[Override]
    public function asFloat(): float
    {
        return (float) $this->value;
    }

    #[Override]
    public function asText(): Text
    {
        return new TextOf((string) (float) $this->value);
    }
}
