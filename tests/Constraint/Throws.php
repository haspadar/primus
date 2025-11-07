<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Tests\Constraint;

use PHPUnit\Framework\Constraint\Constraint;
use Throwable;

/**
 * Asserts that calling {@see value()} on an object throws a specific exception type.
 *
 * Example:
 * self::assertThat(
 *     new FailingScalar(),
 *     new Throws(\RuntimeException::class)
 * );
 *
 * Output on failure:
 * Failed asserting that object throws RuntimeException
 *
 * @since 0.2
 */
final class Throws extends Constraint
{
    public function __construct(private string $expected)
    {
    }

    public function toString(): string
    {
        return "throws {$this->expected}";
    }

    protected function matches($other): bool
    {
        try {
            $other->value();
            return false;
        } catch (Throwable $e) {
            return is_a($e, $this->expected);
        }
    }

    protected function failureDescription($other): string
    {
        return "object {$this->toString()}";
    }

    protected function additionalFailureDescription($other): string
    {
        try {
            $other->value();
            return "\nExpected exception: {$this->expected}\nBut no exception was thrown.";
        } catch (Throwable $e) {
            return "\nExpected exception: {$this->expected}\nBut was:            " . get_class($e);
        }
    }
}
