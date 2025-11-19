<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Tests\Constraint;

use Iterator;
use IteratorAggregate;
use PHPUnit\Framework\Constraint\Constraint;
use RuntimeException;

/**
 * Asserts that an {@see Iterator} or {@see IteratorAggregate}
 * produces the expected scalar values when iterated from the beginning.
 *
 * Rewind is always called before iteration to ensure consistent behavior
 * for lazy and stateful iterators.
 *
 * Example:
 * self::assertThat(
 *     new Mapped(new IteratorOf([1, 2]), new FuncOf(fn(int $x) => $x * 10)),
 *     new HasIteratorValues([10, 20])
 * );
 *
 * Failure output:
 * Failed asserting that iterator has values [10,20]
 * Expected: [10,20]
 * But was:  [10]
 *
 * @since 0.5
 */
final class HasIteratorValues extends Constraint
{
    /**
     * @param list<int|float|string|bool> $expected
     */
    public function __construct(private readonly array $expected)
    {
    }

    public function toString(): string
    {
        return 'has iterator values ' . json_encode($this->expected, JSON_UNESCAPED_UNICODE);
    }

    protected function matches($other): bool
    {
        $it = $this->asIterator($other);

        $it->rewind();
        $actual = iterator_to_array($it, false);

        return $actual === $this->expected;
    }

    protected function failureDescription($other): string
    {
        return 'iterator ' . $this->toString();
    }

    protected function additionalFailureDescription($other): string
    {
        $it = $this->asIterator($other);

        $it->rewind();
        $actual = iterator_to_array($it, false);

        return "\nExpected: " . json_encode($this->expected, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE)
            . "\nBut was:  " . json_encode($actual, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE);
    }

    /**
     * @throws \Exception
     * @return Iterator<mixed,mixed>
     * @param Iterator|IteratorAggregate $value
     */
    private function asIterator(mixed $value): Iterator
    {
        if ($value instanceof IteratorAggregate) {
            return $value->getIterator();
        }

        if ($value instanceof Iterator) {
            return $value;
        }

        throw new RuntimeException(
            'HasIteratorValues expects Iterator or IteratorAggregate, got ' . get_debug_type($value)
        );
    }
}
