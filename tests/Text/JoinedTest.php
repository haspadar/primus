<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Tests\Text;

use Generator;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Tests\Constraint\HasValue;
use Primus\Text\Joined;
use Primus\Text\TextOf;

final class JoinedTest extends TestCase
{
    #[Test]
    public function joinsTextsWithSeparator(): void
    {
        self::assertThat(
            new Joined(', ', [new TextOf('a'), new TextOf('b'), new TextOf('c')]),
            new HasValue('a, b, c')
        );
    }

    #[Test]
    public function joinsWithoutSeparator(): void
    {
        self::assertThat(
            new Joined('', [new TextOf('a'), new TextOf('b'), new TextOf('c')]),
            new HasValue('abc')
        );
    }

    #[Test]
    public function joinsSingleText(): void
    {
        self::assertThat(
            new Joined(', ', [new TextOf('solo')]),
            new HasValue('solo')
        );
    }

    #[Test]
    public function joinsEmptyIterable(): void
    {
        self::assertThat(
            new Joined(', ', []),
            new HasValue('')
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
            new HasValue('A-B')
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
            new HasValue('first,second')
        );
    }
}
