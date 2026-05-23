<?php

declare(strict_types=1);

namespace Primus\Tests\Scalar;

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\List\ListOf;
use Primus\Scalar\Constant;
use Primus\Scalar\ItemAt;
use Primus\Scalar\Scalar;

final class ItemAtTest extends TestCase
{
    #[Test]
    public function returnsElementAtRequestedPosition(): void
    {
        self::assertSame(
            'b',
            (new ItemAt(
                1,
                new ListOf('a', 'b', 'c'),
                new Constant('-'),
            ))->value(),
        );
    }

    #[Test]
    public function returnsFirstElementForZeroPosition(): void
    {
        self::assertSame(
            'a',
            (new ItemAt(
                0,
                new ListOf('a', 'b', 'c'),
                new Constant('-'),
            ))->value(),
        );
    }

    #[Test]
    public function returnsFallbackWhenPositionExceedsLength(): void
    {
        self::assertSame(
            '-',
            (new ItemAt(
                10,
                new ListOf('a', 'b'),
                new Constant('-'),
            ))->value(),
        );
    }

    #[Test]
    public function returnsFallbackWhenPositionEqualsLength(): void
    {
        self::assertSame(
            '-',
            (new ItemAt(
                2,
                new ListOf('a', 'b'),
                new Constant('-'),
            ))->value(),
        );
    }

    #[Test]
    public function returnsFallbackForEmptySource(): void
    {
        self::assertSame(
            'none',
            (new ItemAt(
                0,
                new ListOf(),
                new Constant('none'),
            ))->value(),
        );
    }

    #[Test]
    public function rejectsNegativePosition(): void
    {
        $this->expectException(InvalidArgumentException::class);
        (new ItemAt(
            -1,
            new ListOf('a', 'b'),
            new Constant('-'),
        ))->value();
    }

    #[Test]
    public function defersTraversalUntilValueCall(): void
    {
        $touched = false;
        $fallback = new class ($touched) implements Scalar {
            public function __construct(private bool &$touched) {}

            public function value(): mixed
            {
                $this->touched = true;

                return 'fallback';
            }
        };
        $item = new ItemAt(5, new ListOf('a', 'b'), $fallback);

        self::assertFalse($touched);
        self::assertSame('fallback', $item->value());
        self::assertTrue($touched);
    }

    #[Test]
    public function ofListFactoryAgreesWithPrimaryConstructor(): void
    {
        $list = new ListOf('a', 'b', 'c');
        $fallback = new Constant('-');

        self::assertSame(
            (new ItemAt(1, $list, $fallback))->value(),
            ItemAt::ofList(1, $list, $fallback)->value(),
        );
    }
}
