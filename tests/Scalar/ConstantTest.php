<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Tests\Scalar;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Scalar\Constant;
use Primus\Tests\Constraint\HasScalarValue;

/**
 * @since 0.2
 */
final class ConstantTest extends TestCase
{
    #[Test]
    public function returnsStoredValue(): void
    {
        self::assertThat(
            new Constant('foo'),
            new HasScalarValue('foo'),
            'Constant must return the stored value'
        );
    }

    #[Test]
    public function returnsSameValueOnSubsequentCalls(): void
    {
        $constant = new Constant('bar');
        $constant->value();

        self::assertThat(
            $constant,
            new HasScalarValue('bar'),
            'Constant must return the same value on subsequent calls'
        );
    }
}
