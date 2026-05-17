<?php

declare(strict_types=1);

namespace Primus\Integer;

use Override;
use Primus\Text\Text;
use Primus\Text\TextOf;

/**
 * Integer division of two Integer operands, truncated toward zero.
 *
 * Throws DivisionByZeroError on access when the divisor is zero.
 *
 * Example:
 *     $div = new DivOf(new IntegerOf(7), new IntegerOf(2));
 *     $div->asInt(); // 3
 */
final readonly class DivOf implements Integer
{
    /**
     * Ctor.
     *
     * @param Integer $dividend The integer to divide.
     * @param Integer $divisor The integer to divide by.
     */
    public function __construct(private Integer $dividend, private Integer $divisor) {}

    #[Override]
    public function asInt(): int
    {
        return intdiv($this->dividend->asInt(), $this->divisor->asInt());
    }

    #[Override]
    public function asFloat(): float
    {
        return (float) $this->asInt();
    }

    #[Override]
    public function asText(): Text
    {
        return TextOf::str((string) $this->asInt());
    }
}
