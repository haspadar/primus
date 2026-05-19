<?php

declare(strict_types=1);

namespace Primus\Tests\Scalar;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\List\ListOf;
use Primus\Map\MapOf;
use Primus\Scalar\LengthOf;
use Primus\Text\TextOf;
use Primus\Tests\Constraint\HasSize;

final class LengthOfTest extends TestCase
{
    #[Test]
    public function countsTextCodepointsViaMultibyte(): void
    {
        self::assertSame(
            9,
            LengthOf::text(TextOf::str('Café Noël'))->value(),
        );
    }

    #[Test]
    public function returnsZeroForEmptyText(): void
    {
        self::assertSame(0, LengthOf::text(TextOf::str(''))->value());
    }

    #[Test]
    public function countsListElementsAsCountable(): void
    {
        self::assertSame(
            3,
            LengthOf::ofCountable(new ListOf(1, 2, 3))->value(),
        );
    }

    #[Test]
    public function countsMapPairsAsCountable(): void
    {
        self::assertSame(
            2,
            LengthOf::ofCountable(new MapOf(['a' => 1, 'b' => 2]))->value(),
        );
    }

    #[Test]
    public function countsPlainArrayAsCountable(): void
    {
        self::assertSame(4, LengthOf::ofCountable([10, 20, 30, 40])->value());
    }

    #[Test]
    public function returnsZeroForEmptyArray(): void
    {
        self::assertSame(0, LengthOf::ofCountable([])->value());
    }

    #[Test]
    public function feedsHasSizeConstraint(): void
    {
        self::assertThat(TextOf::str('abc'), new HasSize(3));
    }
}
