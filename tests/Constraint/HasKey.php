<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Tests\Constraint;

use PHPUnit\Framework\Constraint\Constraint;

final class HasKey extends Constraint
{
    public function __construct(private readonly mixed $expected)
    {
    }

    public function toString(): string
    {
        return "has key {$this->export($this->expected)}";
    }

    protected function matches($other): bool
    {
        return $other->key() === $this->expected;
    }

    protected function failureDescription($other): string
    {
        return "iterator {$this->toString()}";
    }

    protected function additionalFailureDescription($other): string
    {
        return "\nBut key was: " . $this->export($other->key());
    }

    private function export(mixed $value): string
    {
        return var_export($value, true);
    }
}
