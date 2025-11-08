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
 * @since 0.2
 */
final class Throws extends Constraint
{
    private ?Throwable $caughtException = null;
    private bool $exceptionThrown = false;

    public function __construct(private readonly string $expected)
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
            $this->exceptionThrown = false;
            return false;
        } catch (Throwable $e) {
            $this->caughtException = $e;
            $this->exceptionThrown = true;
            return is_a($e, $this->expected);
        }
    }

    protected function failureDescription($other): string
    {
        return "object {$this->toString()}";
    }

    protected function additionalFailureDescription($other): string
    {
        if (!$this->exceptionThrown) {
            return "\nExpected exception: {$this->expected}\nBut no exception was thrown.";
        }

        return "\nExpected exception: {$this->expected}\nBut was:            " . $this->caughtException::class;
    }
}
