<?php

declare(strict_types=1);

namespace Primus\Decimal;

use Primus\Scalar\ScalarOf;

/**
 * Absolute value of a Decimal, computed via bcmath at the given scale.
 *
 * Negative origins are multiplied by -1 with `bcmul`; positives pass
 * through unchanged. Digits beyond `$scale` are truncated toward zero.
 *
 * Example:
 *     $abs = new Abs(new DecimalOf('-3.14'), 2);
 *     $abs->asString(); // "3.14"
 */
final readonly class Abs extends DecimalEnvelope
{
    /**
     * Ctor.
     *
     * @param Decimal $origin The decimal to take the absolute value of.
     * @param int $scale Number of digits to keep past the decimal point.
     */
    public function __construct(Decimal $origin, int $scale)
    {
        parent::__construct(new DecimalOfScalar(new ScalarOf(
            static function () use ($origin, $scale): string {
                $value = $origin->asString();
                $factor = str_starts_with($value, '-')
                    ? '-1'
                    : '1';

                return bcmul($value, $factor, $scale);
            },
        )));
    }
}
