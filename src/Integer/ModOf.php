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
 * Example:
 *     $mod = new ModOf(new IntegerOf(7), new IntegerOf(3));
 *     $mod->asInt(); // 1
 */
final readonly class ModOf implements Integer
{
    /**
     * Ctor.
     *
     * @param Integer $dividend The integer to divide.
     * @param Integer $divisor The integer to divide by.
     */
    public function __construct(private Integer $dividend, private Integer $divisor) {}

    #[Override]
    public function asInt(): int
    {
        return $this->dividend->asInt() % $this->divisor->asInt();
    }

    #[Override]
    public function asFloat(): float
    {
        return (float) $this->asInt();
    }

    #[Override]
    public function asText(): Text
    {
        return new TextOf((string) $this->asInt());
    }
}
