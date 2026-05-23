<?php

declare(strict_types=1);

namespace Primus\Integer;

use Override;
use Primus\Text\Text;
use Primus\Text\TextOf;

/**
 * Absolute value of an Integer.
 *
 * `PHP_INT_MIN` is the one input whose absolute value overflows the int range —
 * `abs()` silently widens to float and the strict int return contract breaks
 * with a TypeError. Callers must keep operands above `PHP_INT_MIN`.
 *
 * Construction forms:
 *
 * - `new Abs(Integer)` — wrap an existing {@see Integer} value.
 * - `Abs::ofInteger(Integer)` — named-constructor alias of the primary ctor.
 *
 * Example:
 *     $abs = Abs::ofInteger(IntegerOf::int(-7));
 *     $abs->asInt(); // 7
 */
final readonly class Abs implements Integer
{
    /**
     * Ctor.
     *
     * @param Integer $origin The integer to take the absolute value of.
     */
    public function __construct(private Integer $origin) {}

    /**
     * Takes the absolute value of an {@see Integer}.
     *
     * @param Integer $integer The integer to take the absolute value of.
     * @psalm-api
     */
    public static function ofInteger(Integer $integer): self
    {
        return new self($integer);
    }

    #[Override]
    public function asInt(): int
    {
        return abs($this->origin->asInt());
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
