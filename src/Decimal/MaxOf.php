<?php

declare(strict_types=1);

namespace Primus\Decimal;

use Override;
use Primus\Text\Text;
use Primus\Text\TextOf;

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
final readonly class MaxOf implements Decimal
{
    /**
     * Ctor.
     *
     * @param Decimal $left The first operand.
     * @param Decimal $right The second operand.
     * @param int $scale Number of digits considered past the decimal point.
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
        $leftValue = $this->left->asString();
        $rightValue = $this->right->asString();

        return bccomp($leftValue, $rightValue, $this->scale) >= 0
            ? $leftValue
            : $rightValue;
    }
}
