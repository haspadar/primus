<?php

declare(strict_types=1);

namespace Primus\Decimal;

use Primus\Scalar\ScalarOf;

/**
 * Quotient of two Decimal operands, computed via bcmath at the given scale.
 *
 * Digits beyond `$scale` are truncated toward zero by bcmath without
 * rounding. A zero divisor raises DivisionByZeroError at first projection.
 *
 * Example:
 *     $div = new DivOf(new DecimalOf('1'), new DecimalOf('3'), 4);
 *     $div->asString(); // "0.3333"
 */
final readonly class DivOf extends DecimalEnvelope
{
    /**
     * Ctor.
     *
     * @param Decimal $dividend The number to divide.
     * @param Decimal $divisor The number to divide by.
     * @param int $scale Number of digits to keep past the decimal point.
     */
    public function __construct(Decimal $dividend, Decimal $divisor, int $scale)
    {
        parent::__construct(new DecimalOfScalar(new ScalarOf(
            static fn(): string => bcdiv($dividend->asString(), $divisor->asString(), $scale),
        )));
    }
}
