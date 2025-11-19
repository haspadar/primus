<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Tests\Constraint;

use PHPUnit\Framework\Constraint\Constraint;
use Primus\Func\BiProc;

/**
 * Asserts that a BiProc executes successfully
 * when invoked with two given inputs.
 *
 * Example:
 * self::assertThat(
 *     new ExecutesBiProcWith([2, 3]),
 *     new BiProcOf(...)
 * );
 *
 * @since 0.5
 */
final class ExecBiProcTo extends Constraint
{
    /**
     * @param array{0:mixed,1:mixed} $inputs
     */
    public function __construct(private readonly array $inputs)
    {
    }

    public function toString(): string
    {
        return 'executes with ' . var_export($this->inputs, true);
    }

    protected function matches($other): bool
    {
        if (!$other instanceof BiProc) {
            return false;
        }

        try {
            [$a, $b] = $this->inputs;
            $other->exec($a, $b);
            return true;
        } catch (\Throwable) {
            return false;
        }
    }

    protected function failureDescription($other): string
    {
        return 'biproc ' . $this->toString();
    }

    protected function additionalFailureDescription($other): string
    {
        if (!$other instanceof BiProc) {
            return 'Provided value is not a BiProc: ' . get_debug_type($other);
        }

        try {
            [$a, $b] = $this->inputs;
            $other->exec($a, $b);
        } catch (\Throwable $e) {
            return "\nBiProc threw: " . $e::class . ' → ' . $e->getMessage();
        }

        return '';
    }
}
