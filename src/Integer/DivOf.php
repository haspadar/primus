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
 * Construction forms:
 *
 * - `new DivOf(Integer, Integer)` — wrap an existing pair of integers.
 * - `DivOf::integers(Integer, Integer)` — named-constructor alias of the primary ctor.
 *
 * Example:
 *     $div = DivOf::integers(IntegerOf::int(7), IntegerOf::int(2));
 *     $div->asInt(); // 3
 */
final readonly class DivOf implements Integer
{
    /**
     * Ctor.
     *
     * @param Integer $top The integer to divide.
     * @param Integer $bottom The integer to divide by.
     */
    public function __construct(private Integer $top, private Integer $bottom) {}

    /**
     * Divides one {@see Integer} by another, truncated toward zero.
     *
     * @param Integer $dividend The integer to divide.
     * @param Integer $divisor The integer to divide by.
     * @psalm-api
     */
    public static function integers(Integer $dividend, Integer $divisor): self
    {
        return new self($dividend, $divisor);
    }

    #[Override]
    public function asInt(): int
    {
        return intdiv($this->top->asInt(), $this->bottom->asInt());
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
