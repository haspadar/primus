<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Tests\Constraint;

use PHPUnit\Framework\Constraint\Constraint;
use Primus\Func\BiFunc;

/**
 * Asserts that a BiFunc applied to given inputs
 * returns the expected value.
 *
 * Example:
 * self::assertThat(
 *     new BiFuncOf(fn(int $a, int $b) => $a + $b),
 *     new AppliesBiFuncTo([3, 4], 7)
 * );
 *
 * @since 0.5
 */
final class AppliesBiFuncTo extends Constraint
{
    /**
     * @param array{0:mixed,1:mixed} $inputs
     */
    public function __construct(
        private readonly array $inputs,
        private readonly mixed $expected,
    ) {
    }

    public function toString(): string
    {
        return 'applied to ' . var_export($this->inputs, true)
            . ' equals ' . var_export($this->expected, true);
    }

    protected function matches($other): bool
    {
        if (!$other instanceof BiFunc) {
            return false;
        }

        [$a, $b] = $this->inputs;
        $actual = $other->apply($a, $b);

        return $actual === $this->expected;
    }

    protected function failureDescription($other): string
    {
        return 'bifunc ' . $this->toString();
    }

    protected function additionalFailureDescription($other): string
    {
        if (!$other instanceof BiFunc) {
            return 'Provided value is not a BiFunc: ' . get_debug_type($other);
        }

        try {
            [$a, $b] = $this->inputs;
            $actual = $other->apply($a, $b);
        } catch (\Throwable $e) {
            return "\nBiFunc threw: " . $e::class . ' → ' . $e->getMessage();
        }

        return "\nExpected: " . var_export($this->expected, true)
            . "\nBut was:  " . var_export($actual, true);
    }
}
