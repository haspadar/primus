<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Tests\Text;

use Generator;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Tests\Constraint\HasTextValue;
use Primus\Text\Joined;
use Primus\Text\TextOf;

/**
 * @since 0.2
 */
#[CoversClass(Joined::class)]
final class JoinedTest extends TestCase
{
    #[Test]
    public function joinsTextsWithSeparator(): void
    {
        self::assertThat(
            new Joined(', ', [new TextOf('a'), new TextOf('b'), new TextOf('c')]),
            new HasTextValue('a, b, c')
        );
    }

    #[Test]
    public function joinsWithoutSeparator(): void
    {
        self::assertThat(
            new Joined('', [new TextOf('a'), new TextOf('b'), new TextOf('c')]),
            new HasTextValue('abc')
        );
    }

    #[Test]
    public function joinsSingleText(): void
    {
        self::assertThat(
            new Joined(', ', [new TextOf('solo')]),
            new HasTextValue('solo')
        );
    }

    #[Test]
    public function joinsEmptyIterable(): void
    {
        self::assertThat(
            new Joined(', ', []),
            new HasTextValue('')
        );
    }

    #[Test]
    public function joinsIteratorIgnoresKeys(): void
    {
        self::assertThat(
            new Joined('-', (function (): Generator {
                yield 'x' => new TextOf('A');
                yield 'y' => new TextOf('B');
            })()),
            new HasTextValue('A-B')
        );
    }

    #[Test]
    public function joinsIteratorWithDuplicateKeys(): void
    {
        self::assertThat(
            new Joined(
                ',',
                (function (): Generator {
                    yield 0 => new TextOf('first');
                    yield 0 => new TextOf('second');
                })()
            ),
            new HasTextValue('first,second')
        );
    }
}
