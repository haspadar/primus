<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Tests\Constraint;

use PHPUnit\Framework\Constraint\Constraint;

/**
 * Asserts that a value strictly equals the expected value (===).
 *
 * Example:
 * self::assertThat($actual, new EqualsValue($expected));
 *
 * @since 0.5
 */
final class EqualsValue extends Constraint
{
    public function __construct(private readonly mixed $expected)
    {
    }

    public function toString(): string
    {
        return 'equals ' . $this->export($this->expected);
    }

    protected function matches($other): bool
    {
        return $other === $this->expected;
    }

    protected function failureDescription($other): string
    {
        return 'value ' . $this->toString();
    }

    protected function additionalFailureDescription($other): string
    {
        return "\nExpected: " . $this->export($this->expected)
            . "\nBut was:  " . $this->export($other);
    }

    private function export(mixed $value): string
    {
        return var_export($value, true);
    }
}
