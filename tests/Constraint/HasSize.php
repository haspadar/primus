<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Tests\Constraint;

use PHPUnit\Framework\Constraint\Constraint;
use Primus\Text\LengthOfText;
use Primus\Text\Text;

final class HasSize extends Constraint
{
    public function __construct(private int $expected)
    {
    }

    public function toString(): string
    {
        return "has length {$this->expected}";
    }

    protected function matches($other): bool
    {
        return $other instanceof Text
            && (new LengthOfText($other))->value() === $this->expected;
    }

    protected function failureDescription($other): string
    {
        return 'text ' . $this->toString();
    }

    protected function additionalFailureDescription($other): string
    {
        $actual = $other instanceof Text
            ? (new LengthOfText($other))->value()
            : get_debug_type($other);

        return "\nExpected length: {$this->expected}\nBut was:          {$actual}";
    }
}
