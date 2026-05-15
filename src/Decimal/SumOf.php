<?php

declare(strict_types=1);

namespace Primus\Decimal;

use Override;
use Primus\Text\Text;
use Primus\Text\TextOf;

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
final readonly class SumOf implements Decimal
{
    /**
     * Ctor.
     *
     * @param Decimal $left The first addend.
     * @param Decimal $right The second addend.
     * @param int $scale Number of digits to keep past the decimal point.
     */
    public function __construct(private Decimal $left, private Decimal $right, private int $scale) {}

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
        return new TextOf($this->asString());
    }

    #[Override]
    public function asString(): string
    {
        return bcadd($this->left->asString(), $this->right->asString(), $this->scale);
    }
}
