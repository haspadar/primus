<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Tests\Logic;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Exception;
use Primus\Logic\No;
use Primus\Logic\ThrowsIf;
use Primus\Logic\Yes;

final class ThrowsIfTest extends TestCase
{
    #[Test]
    public function throwsWhenConditionIsTrue(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('True condition triggered');
        new ThrowsIf(new Yes(), 'True condition triggered')->whenTrue();
    }

    #[Test]
    public function throwsWhenConditionIsFalse(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('False condition triggered');
        new ThrowsIf(new No(), 'False condition triggered')->whenFalse();
    }

    #[Test]
    public function returnsSilentlyWhenTrueCheckIsFalse(): void
    {
        new ThrowsIf(new No(), 'No exception expected')->whenTrue();
        $this->assertTrue(true, 'Expected no exception to be thrown');
    }

    #[Test]
    public function returnsSilentlyWhenFalseCheckIsTrue(): void
    {
        new ThrowsIf(new Yes(), 'No exception expected')->whenFalse();
        $this->assertTrue(true, 'Expected no exception to be thrown');
    }

    #[Test]
    public function skipsExceptionWhenTrueConditionIsFalse(): void
    {
        new ThrowsIf(new No(), 'no exception')->whenTrue();
        $this->addToAssertionCount(1);
    }

    #[Test]
    public function skipsExceptionWhenFalseConditionIsTrue(): void
    {
        new ThrowsIf(new Yes(), 'no exception')->whenFalse();
        $this->addToAssertionCount(1);
    }
}
