<?php

declare(strict_types=1);

namespace Primus\Decimal;

use Primus\Scalar\ScalarOf;

/**
 * Product of two Decimal factors, computed via bcmath at the given scale.
 *
 * Digits beyond `$scale` past the decimal point are truncated toward zero
 * by bcmath without rounding.
 *
 * Example:
 *     $product = new MultOf(new DecimalOf('1.5'), new DecimalOf('2'), 1);
 *     $product->asString(); // "3.0"
 */
final readonly class MultOf extends DecimalEnvelope
{
    /**
     * Ctor.
     *
     * @param Decimal $left The first factor.
     * @param Decimal $right The second factor.
     * @param int $scale Number of digits to keep past the decimal point.
     */
    public function __construct(Decimal $left, Decimal $right, int $scale)
    {
        parent::__construct(new DecimalOfScalar(new ScalarOf(
            static fn(): string => bcmul($left->asString(), $right->asString(), $scale),
        )));
    }
}
