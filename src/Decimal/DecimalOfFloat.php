<?php

declare(strict_types=1);

namespace Primus\Decimal;

use InvalidArgumentException;
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
 * NaN and infinite inputs raise {@see InvalidArgumentException} at the
 * first projection call — they have no meaningful decimal representation.
 *
 * Example:
 *     $d = new DecimalOfFloat(0.3);
 *     $d->asString(); // "0.3"
 *     $d->asFloat(); // 0.3
 */
final readonly class DecimalOfFloat implements Decimal
{
    /**
     * Ctor.
     *
     * @param float $value Native finite float.
     */
    public function __construct(private float $value) {}

    #[Override]
    public function asInt(): int
    {
        return (int) $this->finite();
    }

    #[Override]
    public function asFloat(): float
    {
        return $this->finite();
    }

    #[Override]
    public function asText(): Text
    {
        return new TextOf($this->asString());
    }

    #[Override]
    public function asString(): string
    {
        return (string) $this->finite();
    }

    /**
     * Returns the wrapped float, throwing for NaN or infinity.
     *
     * @throws InvalidArgumentException When the wrapped float is NaN or infinite.
     */
    private function finite(): float
    {
        if (!is_finite($this->value)) {
            throw new InvalidArgumentException('DecimalOfFloat rejects NaN and infinite values');
        }

        return $this->value;
    }
}
