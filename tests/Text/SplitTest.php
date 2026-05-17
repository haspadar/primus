<?php

declare(strict_types=1);

namespace Primus\Tests\Text;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Tests\Constraint\HasTextValues;
use Primus\Text\Split;
use Primus\Text\TextOf;

/**
 */
final class SplitTest extends TestCase
{
    #[Test]
    public function splitsTextByDelimiter(): void
    {
        self::assertThat(
            (new Split(',', TextOf::str('a,b,c')))->value(),
            new HasTextValues(['a', 'b', 'c'])
        );
    }

    #[Test]
    public function returnsSinglePartWhenDelimiterNotFound(): void
    {
        self::assertThat(
            (new Split(',', TextOf::str('abc')))->value(),
            new HasTextValues(['abc'])
        );
    }

    #[Test]
    public function handlesEmptyString(): void
    {
        self::assertThat(
            (new Split(',', TextOf::str('')))->value(),
            new HasTextValues([''])
        );
    }

    #[Test]
    public function worksWithMultibyteDelimiter(): void
    {
        self::assertThat(
            (new Split('—', TextOf::str('a—b—c')))->value(),
            new HasTextValues(['a', 'b', 'c'])
        );
    }

    #[Test]
    public function consecutiveDelimitersProduceEmptyParts(): void
    {
        self::assertThat(
            (new Split(',', TextOf::str('a,,b,')))->value(),
            new HasTextValues(['a', '', 'b', ''])
        );
    }
}
