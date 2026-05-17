<?php

declare(strict_types=1);

namespace Primus\Decimal;

use Override;
use Primus\Scalar\Scalar;
use Primus\Text\Text;
use Primus\Text\TextOf;

/**
 * Decimal lifted from a deferred {@see Scalar} producing a numeric string.
 *
 * The scalar is evaluated lazily on each projection call. Wrap in
 * {@see Sticky} to memoize.
 *
 * Example:
 *     $d = new DecimalOfScalar(new ScalarOf(static fn(): string => '3.14'));
 *     $d->asString(); // "3.14"
 *
 * @phpstan-type NumericScalar Scalar<numeric-string>
 */
final readonly class DecimalOfScalar implements Decimal
{
    /**
     * Ctor.
     *
     * @param NumericScalar $origin The deferred numeric-string scalar.
     */
    public function __construct(private Scalar $origin) {}

    #[Override]
    public function asInt(): int
    {
        return (int) $this->asString();
    }

    #[Override]
    public function asFloat(): float
    {
        return (float) $this->asString();
    }

    #[Override]
    public function asText(): Text
    {
        return TextOf::str($this->asString());
    }

    #[Override]
    public function asString(): string
    {
        return $this->origin->value();
    }
}
