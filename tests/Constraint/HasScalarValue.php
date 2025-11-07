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
 * Asserts that a {@see Scalar} has the expected scalar value.
 *
 * Supports int, float, string, and bool.
 *
 * @since 0.2
 */
final class HasScalarValue extends Constraint
{
    public function __construct(private int|float|string|bool $expected)
    {
    }

    public function toString(): string
    {
        return 'has scalar value ' . var_export($this->expected, true);
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

        return "\nExpected: " . var_export($this->expected, true) . "\nBut was:  {$actual}";
    }
}
