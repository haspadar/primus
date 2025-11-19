<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Tests\Constraint;

use PHPUnit\Framework\Constraint\Constraint;

/**
*
* @since 0.3
*/
final class HasCallCount extends Constraint
{
    public function __construct(private readonly int $expected)
    {
    }

    public function toString(): string
    {
        return "has call count {$this->expected}";
    }

    protected function matches($other): bool
    {
        return method_exists($other, 'total') && $other->total() === $this->expected;
    }

    protected function failureDescription($other): string
    {
        return "object {$this->toString()}";
    }

    protected function additionalFailureDescription($other): string
    {
        $actual = method_exists($other, 'total')
            ? $other->total()
            : 'N/A';

        return "\nExpected: {$this->expected}\nBut was:  {$actual}";
    }
}
