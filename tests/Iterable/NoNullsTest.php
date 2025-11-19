<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Tests\Iterable;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Iterator\IteratorOf;
use Primus\Iterator\NoNulls;
use Primus\Tests\Constraint\EqualsValue;
use Primus\Tests\Constraint\HasIteratorValues;
use Primus\Tests\Constraint\HasKey;
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
            function (): void {
                $it = new NoNulls(new IteratorOf([1, null, 3]));
                $it->rewind();
                $it->next();
                $it->current();
            },
            new ThrowsClosure(RuntimeException::class),
            'NoNulls must throw when encountering null'
        );
    }

    #[Test]
    public function iteratesOverNonNullValues(): void
    {
        self::assertThat(
            new NoNulls(new IteratorOf([1, 2])),
            new HasIteratorValues([1, 2]),
            'NoNulls must yield non-null values only'
        );
    }

    #[Test]
    public function throwsOnNullAtFirstElement(): void
    {
        self::assertThat(
            function (): void {
                $it = new NoNulls(new IteratorOf([null]));
                $it->rewind();
                $it->current();
            },
            new ThrowsClosure(RuntimeException::class),
            'NoNulls must throw when first value is null'
        );
    }

    #[Test]
    public function yieldsSequentialIntegerKeys(): void
    {
        $it = new NoNulls(new IteratorOf(['a', 'b', 'c']));
        $it->rewind();

        $keys = [];
        while ($it->valid()) {
            $keys[] = $it->key();
            $it->next();
        }

        self::assertThat(
            $keys,
            new EqualsValue([0, 1, 2]),
            'NoNulls must reindex keys sequentially'
        );
    }

    #[Test]
    public function resetsKeysAfterRewind(): void
    {
        $it = new NoNulls(new IteratorOf(['x', 'y']));

        $it->rewind();
        while ($it->valid()) {
            $it->next();
        }
        $it->rewind();

        self::assertThat(
            $it,
            new HasKey(0),
            'NoNulls must reset key to 0 after rewind'
        );
    }

    #[Test]
    public function ignoresOriginKeys(): void
    {
        $origin = new \ArrayIterator([
            10 => 'p',
            20 => 'q',
        ]);

        $it = new NoNulls($origin);
        $it->rewind();

        $keys = [];
        while ($it->valid()) {
            $keys[] = $it->key();
            $it->next();
        }

        self::assertThat(
            $keys,
            new EqualsValue([0, 1]),
            'NoNulls must ignore origin keys and reindex'
        );
    }
}
