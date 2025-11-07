<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Tests\Constraint;

use PHPUnit\Framework\Constraint\Constraint;

/**
 * Asserts that an iterable of scalar values (int, float, string, bool)
 * has the expected values.
 *
 * @since 0.2
 */
final class HasScalarValues extends Constraint
{
    /**
     * @param array<int|float|string|bool> $expected
     */
    public function __construct(private array $expected)
    {
    }

    public function toString(): string
    {
        return 'has scalar values ' . json_encode($this->expected, JSON_UNESCAPED_UNICODE);
    }

    protected function matches($other): bool
    {
        if (!is_iterable($other)) {
            return false;
        }

        $actual = [];
        foreach ($other as $v) {
            if (!is_scalar($v)) {
                return false;
            }
            $actual[] = $v;
        }

        return $actual === $this->expected;
    }

    protected function failureDescription($other): string
    {
        return 'iterable ' . $this->toString();
    }

    protected function additionalFailureDescription($other): string
    {
        $actual = [];
        if (is_iterable($other)) {
            foreach ($other as $v) {
                $actual[] = is_scalar($v) ? $v : get_debug_type($v);
            }
        }

        return "\nExpected: " . json_encode($this->expected, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE)
            . "\nBut was:  " . json_encode($actual, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE);
    }
}
