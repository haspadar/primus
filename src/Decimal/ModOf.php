<?php

declare(strict_types=1);

namespace Primus\Decimal;

use Primus\Scalar\ScalarOf;

/**
 * Remainder of dividing one Decimal by another via bcmath.
 *
 * The sign follows the dividend. A zero divisor raises DivisionByZeroError
 * at first projection.
 *
 * Example:
 *     $mod = new ModOf(new DecimalOf('7.5'), new DecimalOf('2'), 1);
 *     $mod->asString(); // "1.5"
 */
final readonly class ModOf extends DecimalEnvelope
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
            static fn(): string => bcmod($dividend->asString(), $divisor->asString(), $scale),
        )));
    }
}
