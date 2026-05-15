<?php

declare(strict_types=1);

namespace Primus\Decimal;

use Primus\Scalar\ScalarOf;

/**
 * Sum of two Decimal addends, computed via bcmath at the given scale.
 *
 * Digits beyond `$scale` past the decimal point are truncated toward zero
 * by bcmath without rounding.
 *
 * Example:
 *     $sum = new SumOf(new DecimalOf('1.5'), new DecimalOf('2.5'), 1);
 *     $sum->asString(); // "4.0"
 */
final readonly class SumOf extends DecimalEnvelope
{
    /**
     * Ctor.
     *
     * @param Decimal $left The first addend.
     * @param Decimal $right The second addend.
     * @param int $scale Number of digits to keep past the decimal point.
     */
    public function __construct(Decimal $left, Decimal $right, int $scale)
    {
        parent::__construct(new DecimalOfScalar(new ScalarOf(
            static fn(): string => bcadd($left->asString(), $right->asString(), $scale),
        )));
    }
}
