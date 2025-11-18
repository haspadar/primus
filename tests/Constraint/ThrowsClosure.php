<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Tests\Constraint;

use Closure;
use PHPUnit\Framework\Constraint\Constraint;
use Throwable;

/**
 * Asserts that invoking a {@see Closure} throws a specific exception type.
 *
 * Example:
 * self::assertThat(
 *     fn () => $iterator->current(),
 *     new ThrowsClosure(\RuntimeException::class)
 * );
 *
 * @since 0.5
 */
final class ThrowsClosure extends Constraint
{
    /** @var ?Throwable The caught exception, if any */
    private ?Throwable $caughtException = null;

    /** @var bool Whether an exception was thrown at all */
    private bool $exceptionThrown = false;

    /**
     * @param class-string<Throwable> $expected Expected exception class
     */
    public function __construct(private readonly string $expected)
    {
    }

    public function toString(): string
    {
        return "throws {$this->expected}";
    }

    /**
     * @param Closure $other
     */
    protected function matches($other): bool
    {
        try {
            $other();
            $this->exceptionThrown = false;
            return false;
        } catch (Throwable $e) {
            $this->caughtException = $e;
            $this->exceptionThrown = true;

            return is_a($e, $this->expected, true);
        }
    }

    protected function failureDescription($other): string
    {
        return "closure {$this->toString()}";
    }

    protected function additionalFailureDescription($other): string
    {
        if (!$this->exceptionThrown) {
            return "\nExpected exception: {$this->expected}\nBut no exception was thrown.";
        }

        return "\nExpected exception: {$this->expected}\nBut was:            "
            . $this->caughtException::class
            . ': ' . $this->caughtException->getMessage()
            . ': ' . $this->caughtException->getTraceAsString();
    }
}
