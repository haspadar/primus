<?php

declare(strict_types=1);

namespace Primus\Decimal;

use Override;
use Primus\Text\Text;
use Primus\Text\TextOf;

/**
 * Decimal lifted from a native int.
 *
 * Always exact — every PHP int fits in its string form without precision
 * loss. The text projection has scale 0 (no fractional part).
 *
 * Example:
 *     $d = new DecimalOfInt(42);
 *     $d->asText()->value(); // "42"
 *     $d->asInt(); // 42
 */
final readonly class DecimalOfInt implements Decimal
{
    /**
     * Ctor.
     *
     * @param int $value Native int to wrap.
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
        return TextOf::ofString((string) $this->value);
    }

    #[Override]
    public function asString(): string
    {
        return (string) $this->value;
    }
}
