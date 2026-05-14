<?php

declare(strict_types=1);

namespace Primus\Number;

use Override;
use Primus\Text\Text;
use Primus\Text\TextOf;

/**
 * Sum of one or more Number addends.
 *
 * Each operand contributes its float projection; the int accessor
 * truncates the resulting sum toward zero.
 *
 * Example:
 *     $sum = new SumOf(new NumberOf(1), new NumberOf(2.5));
 *     $sum->asInt(); // 3 (truncate)
 *     $sum->asFloat(); // 3.5
 */
final readonly class SumOf implements Number
{
    /** @var array<array-key, Number> */
    private array $addends;

    /**
     * Ctor.
     *
     * @param Number ...$addends The numbers to add.
     */
    public function __construct(Number ...$addends)
    {
        $this->addends = $addends;
    }

    #[Override]
    public function asInt(): int
    {
        return (int) $this->asFloat();
    }

    #[Override]
    public function asFloat(): float
    {
        $total = (float) 0;

        foreach ($this->addends as $addend) {
            $total += $addend->asFloat();
        }

        return $total;
    }

    #[Override]
    public function asText(): Text
    {
        return new TextOf((string) $this->asFloat());
    }
}
