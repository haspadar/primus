<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Tests\Text;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Tests\Constraint\HasTextValues;
use Primus\Text\Split;
use Primus\Text\TextOf;

/**
 * @since 0.2
 */
#[CoversClass(Split::class)]
final class SplitTest extends TestCase
{
    #[Test]
    public function splitsTextByDelimiter(): void
    {
        self::assertThat(
            (new Split(',', new TextOf('a,b,c')))->value(),
            new HasTextValues(['a', 'b', 'c'])
        );
    }

    #[Test]
    public function returnsSinglePartWhenDelimiterNotFound(): void
    {
        self::assertThat(
            (new Split(',', new TextOf('abc')))->value(),
            new HasTextValues(['abc'])
        );
    }

    #[Test]
    public function handlesEmptyString(): void
    {
        self::assertThat(
            (new Split(',', new TextOf('')))->value(),
            new HasTextValues([''])
        );
    }

    #[Test]
    public function worksWithMultibyteDelimiter(): void
    {
        self::assertThat(
            (new Split('—', new TextOf('a—b—c')))->value(),
            new HasTextValues(['a', 'b', 'c'])
        );
    }

    #[Test]
    public function consecutiveDelimitersProduceEmptyParts(): void
    {
        self::assertThat(
            (new Split(',', new TextOf('a,,b,')))->value(),
            new HasTextValues(['a', '', 'b', ''])
        );
    }
}
