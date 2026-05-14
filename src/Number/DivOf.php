<?php

declare(strict_types=1);

namespace Primus\Number;

use Override;
use Primus\Text\Text;
use Primus\Text\TextOf;

/**
 * Quotient of a dividend Number and a divisor Number.
 *
 * The float accessor returns the dividend's float projection divided
 * by the divisor's float projection. The int accessor truncates the
 * resulting quotient toward zero. A zero divisor surfaces PHP's
 * native DivisionByZeroError at accessor time.
 *
 * Example:
 *     $q = new DivOf(new NumberOf(7), new NumberOf(2));
 *     $q->asFloat(); // 3.5
 *     $q->asInt(); // 3
 */
final readonly class DivOf implements Number
{
    /**
     * Ctor.
     *
     * @param Number $dividend The number to be divided.
     * @param Number $divisor The number to divide by.
     */
    public function __construct(private Number $dividend, private Number $divisor) {}

    #[Override]
    public function asInt(): int
    {
        return (int) $this->asFloat();
    }

    #[Override]
    public function asFloat(): float
    {
        return $this->dividend->asFloat() / $this->divisor->asFloat();
    }

    #[Override]
    public function asText(): Text
    {
        return new TextOf((string) $this->asFloat());
    }
}
