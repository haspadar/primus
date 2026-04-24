<?php

declare(strict_types=1);

namespace Primus\Tests\Iterable;

use ArrayIterator;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Iterable\IterableOf;
use Primus\Iterable\NoNulls;
use Primus\Tests\Constraint\HasIteratorValues;
use Primus\Tests\Constraint\ThrowsClosure;
use RuntimeException;

/**
 * @since 0.5
 */
final class NoNullsTest extends TestCase
{
    #[Test]
    public function throwsOnNullValue(): void
    {
        self::assertThat(
            static function (): void {
                foreach (new NoNulls(new IterableOf([1, null, 3])) as $value) {
                    // consume
                    unset($value);
                }
            },
            new ThrowsClosure(RuntimeException::class),
            'NoNulls must throw when encountering null'
        );
    }

    #[Test]
    public function iteratesOverNonNullValues(): void
    {
        self::assertThat(
            new NoNulls(new IterableOf([1, 2])),
            new HasIteratorValues([1, 2]),
            'NoNulls must yield non-null values only'
        );
    }

    #[Test]
    public function throwsOnNullAtFirstElement(): void
    {
        self::assertThat(
            static function (): void {
                foreach (new NoNulls(new IterableOf([null])) as $value) {
                    // consume
                    unset($value);
                }
            },
            new ThrowsClosure(RuntimeException::class),
            'NoNulls must throw when first value is null'
        );
    }

    #[Test]
    public function yieldsSequentialIntegerKeys(): void
    {
        $keys = [];
        foreach (new NoNulls(new IterableOf(['a', 'b', 'c'])) as $key => $value) {
            $keys[] = $key;
            unset($value);
        }

        self::assertSame([0, 1, 2], $keys, 'NoNulls must reindex keys sequentially');
    }

    #[Test]
    public function ignoresOriginKeys(): void
    {
        $origin = new ArrayIterator([
            10 => 'p',
            20 => 'q',
        ]);

        $keys = [];
        foreach (new NoNulls($origin) as $key => $value) {
            $keys[] = $key;
            unset($value);
        }

        self::assertSame([0, 1], $keys, 'NoNulls must ignore origin keys and reindex');
    }
}
