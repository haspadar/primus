<?php

declare(strict_types=1);

namespace Primus\IntNumber;

use Override;
use Primus\Text\Text;
use Primus\Text\TextOf;

/**
 * IntNumber lifted from a native int.
 *
 * Example:
 *     $n = new IntNumberOf(42);
 *     $n->asInt(); // 42
 *     $n->asFloat(); // 42.0
 *     $n->asText()->value(); // "42"
 */
final readonly class IntNumberOf implements IntNumber
{
    /**
     * Ctor.
     *
     * @param int $value The native int to wrap.
     */
    public function __construct(private int $value) {}

    #[Override]
    public function asInt(): int
    {
        return $this->value;
    }

    #[Override]
    public function asFloat(): float
    {
        return (float) $this->value;
    }

    #[Override]
    public function asText(): Text
    {
        return new TextOf((string) $this->value);
    }
}
