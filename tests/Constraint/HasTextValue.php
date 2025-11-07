<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Tests\Constraint;

use PHPUnit\Framework\Constraint\Constraint;
use Primus\Text\Text;

/**
 * Asserts that {@see Text} has the expected string value.
 *
 * Example:
 * self::assertThat(new TextOf('foo'), new HasTextValue('foo'));
 *
 * @since 0.2
 */
final class HasTextValue extends Constraint
{
    public function __construct(private string $expected)
    {
    }

    public function toString(): string
    {
        return "has text value '{$this->expected}'";
    }

    protected function matches($other): bool
    {
        return $other instanceof Text
            && $other->value() === $this->expected;
    }

    protected function failureDescription($other): string
    {
        return 'text ' . $this->toString();
    }

    protected function additionalFailureDescription($other): string
    {
        $actual = $other instanceof Text
            ? $other->value()
            : get_debug_type($other);

        return "\nExpected value: '{$this->expected}'\nBut was:         '{$actual}'";
    }
}
