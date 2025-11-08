<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Tests\Constraint;

use PHPUnit\Framework\Constraint\Constraint;
use Primus\Scalar\Scalar;

/**
 * Asserts that a {@see Scalar<bool>} evaluates to the expected boolean value.
 *
 * Example:
 * self::assertThat(new True_(), new HasBoolValue(true));
 *
 * @since 0.2
 */
final class HasBoolValue extends Constraint
{
    public function __construct(private readonly bool $expected)
    {
    }

    public function toString(): string
    {
        return 'has boolean value ' . ($this->expected ? 'true' : 'false');
    }

    protected function matches($other): bool
    {
        return $other instanceof Scalar && $other->value() === $this->expected;
    }

    protected function failureDescription($other): string
    {
        return 'scalar ' . $this->toString();
    }

    protected function additionalFailureDescription($other): string
    {
        $actual = $other instanceof Scalar ? var_export($other->value(), true) : get_debug_type($other);

        return "\nExpected: " . ($this->expected ? 'true' : 'false') . "\nBut was:  {$actual}";
    }
}
