<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Tests\Text;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Tests\Constraint\HasSize;
use Primus\Tests\Constraint\MatchesPattern;
use Primus\Text\RandomText;

/**
 * @since 0.2
 */
final class RandomTextTest extends TestCase
{
    #[Test]
    public function generatesTextOfSpecifiedLength(): void
    {
        self::assertThat(
            new RandomText(10),
            new HasSize(10)
        );
    }

    #[Test]
    public function usesCustomAlphabet(): void
    {
        self::assertThat(
            new RandomText(50, 'abc'),
            new MatchesPattern('/^[abc]+$/')
        );
    }

    #[Test]
    public function supportsMultibyteAlphabet(): void
    {
        self::assertThat(
            new RandomText(5, '🙂🚀🔥'),
            new MatchesPattern('/^[🙂🚀🔥]+$/u')
        );
    }

    #[Test]
    public function lengthAlwaysExact(): void
    {
        self::assertThat(
            new RandomText(20, 'ab'),
            new HasSize(20)
        );
    }

    #[Test]
    public function returnsEmptyStringWhenLengthIsZero(): void
    {
        self::assertThat(
            new RandomText(0),
            new MatchesPattern('/^$/')
        );
    }

    #[Test]
    public function returnsEmptyStringWhenLengthIsNegative(): void
    {
        self::assertThat(
            new RandomText(-5),
            new MatchesPattern('/^$/')
        );
    }

    #[Test]
    public function replacesEmptyAlphabetWithDefault(): void
    {
        self::assertThat(
            new RandomText(5, ''),
            new MatchesPattern('/^[a]+$/')
        );
    }
}
