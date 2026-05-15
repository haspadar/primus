<?php

declare(strict_types=1);

namespace Primus\Decimal;

use Override;
use Primus\Text\Text;
use Primus\Text\TextOf;

/**
 * Decimal lifted from a numeric string.
 *
 * The string is stored as-is (no float roundtrip, no normalization), so
 * precision past float53 is preserved through both `asText` and `asString`.
 * The `numeric-string` annotation forces static analyzers to verify the
 * literal at the call site.
 *
 * Example:
 *     $d = new DecimalOf('100000000000000.000001');
 *     $d->asString(); // "100000000000000.000001" (exact)
 *     $d->asInt(); // 100000000000000 (truncated toward zero)
 */
final readonly class DecimalOf implements Decimal
{
    /**
     * Ctor.
     *
     * @param numeric-string $value Numeric string suitable for bcmath.
     */
    public function __construct(private string $value) {}

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
        return new TextOf($this->value);
    }

    #[Override]
    public function asString(): string
    {
        return $this->value;
    }
}
