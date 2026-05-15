<?php

declare(strict_types=1);

namespace Primus\Decimal;

use Override;
use Primus\Text\Text;
use Primus\Text\TextOf;

/**
 * Decimal lifted from a plain decimal string.
 *
 * The string is stored as-is (no float roundtrip, no normalization), so
 * precision past float53 is preserved through `asText`. Caller is
 * responsible for passing a well-formed plain decimal — `(int)` and
 * `(float)` casts on malformed input follow PHP's native behavior, and
 * downstream bcmath-backed aggregates will reject non-decimal inputs at
 * the moment of computation.
 *
 * Example:
 *     $d = new DecimalOf('100000000000000.000001');
 *     $d->asText()->value(); // "100000000000000.000001" (exact)
 *     $d->asInt(); // 100000000000000 (truncated toward zero)
 */
final readonly class DecimalOf implements Decimal
{
    /**
     * Ctor.
     *
     * @param string $value Plain decimal string.
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
}
