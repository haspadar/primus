<?php

declare(strict_types=1);

namespace Primus\Decimal;

use Primus\Scalar\ScalarOf;

/**
 * Greater of two Decimal operands, compared via bcmath at the given scale.
 *
 * Digits past `$scale` are ignored during comparison; ties resolve to the
 * left operand.
 *
 * Example:
 *     $max = new MaxOf(new DecimalOf('1.5'), new DecimalOf('2.7'), 1);
 *     $max->asString(); // "2.7"
 */
final readonly class MaxOf extends DecimalEnvelope
{
    /**
     * Ctor.
     *
     * @param Decimal $left The first operand.
     * @param Decimal $right The second operand.
     * @param int $scale Number of digits considered past the decimal point.
     */
    public function __construct(Decimal $left, Decimal $right, int $scale)
    {
        parent::__construct(new DecimalOfScalar(new ScalarOf(
            static function () use ($left, $right, $scale): string {
                $leftValue = $left->asString();
                $rightValue = $right->asString();

                return bccomp($leftValue, $rightValue, $scale) >= 0
                    ? $leftValue
                    : $rightValue;
            },
        )));
    }
}
