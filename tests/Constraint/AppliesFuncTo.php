<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Tests\Constraint;

use PHPUnit\Framework\Constraint\Constraint;
use Primus\Func\Func;

/**
 * Asserts that a Func applied to a given input
 * returns the expected value.
 *
 * Example:
 * self::assertThat(
 *     new FuncOf(fn(int $x) => $x * 2),
 *     new AppliesTo(3, 6)
 * );
 *
 * @since 0.5
 */
final class AppliesFuncTo extends Constraint
{
    public function __construct(
        private readonly mixed $input,
        private readonly Constraint $resultConstraint
    ) {
    }

    public function toString(): string
    {
        return 'applied to ' . var_export($this->input, true)
            . ' ' . $this->resultConstraint->toString();
    }

    protected function matches($other): bool
    {
        if (!$other instanceof Func) {
            return false;
        }

        $result = $other->apply($this->input);

        return $this->resultConstraint->evaluate($result, '', true);
    }

    protected function failureDescription($other): string
    {
        return 'func ' . $this->toString();
    }

    protected function additionalFailureDescription($other): string
    {
        if (!$other instanceof Func) {
            return 'Provided value is not a Func: ' . get_debug_type($other);
        }

        try {
            $result = $other->apply($this->input);
        } catch (\Throwable $e) {
            return "\nFunction threw " . $e::class . ': ' . $e->getMessage();
        }

        return "\nConstraint failure:\n" .
            $this->resultConstraint->failureDescription($result) . "\n\n" .
            $this->resultConstraint->additionalFailureDescription($result);
    }
}
