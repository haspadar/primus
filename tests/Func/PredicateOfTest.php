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

/**
 * @since 0.3
 */
final class PredicateOfTest extends TestCase
{
    #[Test]
    public function returnsTrueForMatchingCondition(): void
    {
        $predicate = new PredicateOf(fn (int $x): bool => $x > 0);
        self::assertTrue($predicate->apply(5), 'Predicate must return true');
    }

    #[Test]
    public function returnsFalseForNonMatchingCondition(): void
    {
        $predicate = new PredicateOf(fn (int $x): bool => $x > 0);
        self::assertFalse($predicate->apply(-3), 'Predicate must return false');
    }
}
