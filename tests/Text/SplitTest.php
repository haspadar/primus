<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Tests\Text;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Tests\Constraint\HasValues;
use Primus\Text\Split;
use Primus\Text\TextOf;

final class SplitTest extends TestCase
{
    #[Test]
    public function splitsTextByDelimiter(): void
    {
        self::assertThat(
            (new Split(',', new TextOf('a,b,c')))->value(),
            new HasValues(['a', 'b', 'c'])
        );
    }

    #[Test]
    public function returnsSinglePartWhenDelimiterNotFound(): void
    {
        self::assertThat(
            (new Split(',', new TextOf('abc')))->value(),
            new HasValues(['abc'])
        );
    }

    #[Test]
    public function handlesEmptyString(): void
    {
        self::assertThat(
            (new Split(',', new TextOf('')))->value(),
            new HasValues([''])
        );
    }

    #[Test]
    public function worksWithMultibyteDelimiter(): void
    {
        self::assertThat(
            (new Split('—', new TextOf('a—b—c')))->value(),
            new HasValues(['a', 'b', 'c'])
        );
    }

    #[Test]
    public function consecutiveDelimitersProduceEmptyParts(): void
    {
        self::assertThat(
            (new Split(',', new TextOf('a,,b,')))->value(),
            new HasValues(['a', '', 'b', ''])
        );
    }
}
