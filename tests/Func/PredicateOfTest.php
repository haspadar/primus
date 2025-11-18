<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Tests\Func;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Func\PredicateOf;
use Primus\Tests\Constraint\AppliesFuncTo;
use Primus\Tests\Constraint\EqualsValue;

/**
 * @since 0.3
 */
final class PredicateOfTest extends TestCase
{
    #[Test]
    public function returnsTrueForMatchingCondition(): void
    {
        self::assertThat(
            new PredicateOf(fn (int $x): bool => $x > 0),
            new AppliesFuncTo(5, new EqualsValue(true)),
            'PredicateOf must return true for matching condition'
        );
    }

    #[Test]
    public function returnsFalseForNonMatchingCondition(): void
    {
        self::assertThat(
            new PredicateOf(fn (int $x): bool => $x > 0),
            new AppliesFuncTo(-3, new EqualsValue(false)),
            'PredicateOf must return false for non-matching condition'
        );
    }
}
