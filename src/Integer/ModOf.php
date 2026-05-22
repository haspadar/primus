<?php

declare(strict_types=1);

namespace Primus\Integer;

use Override;
use Primus\Text\Text;
use Primus\Text\TextOf;

/**
 * Remainder of dividing one Integer by another. The sign follows the dividend.
 *
 * Throws DivisionByZeroError on access when the divisor is zero.
 *
 * Construction forms:
 *
 * - `new ModOf(Integer, Integer)` — wrap an existing pair of integers.
 * - `ModOf::integers(Integer, Integer)` — named-constructor alias of the primary ctor.
 *
 * Example:
 *     $mod = ModOf::integers(IntegerOf::int(7), IntegerOf::int(3));
 *     $mod->asInt(); // 1
 */
final readonly class ModOf implements Integer
{
    /**
     * Ctor.
     *
     * @param Integer $top The integer to divide.
     * @param Integer $bottom The integer to divide by.
     */
    public function __construct(private Integer $top, private Integer $bottom) {}

    /**
     * Computes the remainder of dividing one {@see Integer} by another.
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
        return $this->top->asInt() % $this->bottom->asInt();
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
