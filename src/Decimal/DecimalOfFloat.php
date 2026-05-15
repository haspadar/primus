<?php

declare(strict_types=1);

namespace Primus\Decimal;

use Override;
use Primus\Text\Text;
use Primus\Text\TextOf;

/**
 * Decimal lifted from a native float.
 *
 * The float is serialized through PHP's default `(string)` cast, which
 * uses `serialize_precision=-1` (shortest round-trip repr). Short decimals
 * stay exact (`0.3` → `"0.3"`), but values whose precision exceeds float53
 * are already truncated at the float boundary on the caller side.
 *
 * NaN and infinite inputs are not rejected here — they will surface as
 * `"NAN"` or `"INF"` in `asText` and as the corresponding native sentinels
 * in `asInt`/`asFloat`, mirroring PHP's own casting semantics.
 *
 * Example:
 *     $d = new DecimalOfFloat(0.3);
 *     $d->asText()->value(); // "0.3"
 *     $d->asFloat(); // 0.3
 */
final readonly class DecimalOfFloat implements Decimal
{
    /**
     * Ctor.
     *
     * @param float $value Native float.
     */
    public function __construct(private float $value) {}

    #[Override]
    public function asInt(): int
    {
        return (int) $this->value;
    }

    #[Override]
    public function asFloat(): float
    {
        return $this->value;
    }

    #[Override]
    public function asText(): Text
    {
        return new TextOf((string) $this->value);
    }
}
