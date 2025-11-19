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
use Traversable;

/**
 * Asserts that an iterable (array, {@see Iterator}, or {@see IteratorAggregate})
 * produces the exact expected key/value pairs.
 *
 * Arrays are used as-is, while Traversable instances are converted via
 * {@see iterator_to_array()}. This enables assertions on lazy iterators
 * and iterator decorators without losing key information.
 *
 * Example:
 * self::assertThat(
 *     new Filtered(
 *         new IteratorOf([1, 2, 3, 4]),
 *         new PredicateOf(fn (int $x): bool => $x > 2),
 *     ),
 *     new HasKeyValuePairs([2 => 3, 3 => 4])
 * );
 *
 * Failure output:
 * Failed asserting that iterator has key/value pairs array (
 *   2 => 3,
 *   3 => 4,
 * )
 * Expected: array (
 *   2 => 3,
 *   3 => 4,
 * )
 * But was:  array (
 *   0 => 3,
 *   1 => 4,
 * )
 *
 * @since 0.5
 */
final class HasKeyValuePairs extends Constraint
{
    /**
     * @param array<mixed,mixed> $expected
     */
    public function __construct(private readonly array $expected)
    {
    }

    public function toString(): string
    {
        return 'has key/value pairs ' . $this->export($this->expected);
    }

    protected function matches($other): bool
    {
        if (!$this->isSupported($other)) {
            return false;
        }

        return $this->toArray($other) === $this->expected;
    }

    protected function failureDescription($other): string
    {
        return 'iterator ' . $this->toString();
    }

    protected function additionalFailureDescription($other): string
    {
        $actual = $this->isSupported($other)
            ? $this->toArray($other)
            : get_debug_type($other);

        return "\nExpected: " . $this->export($this->expected)
            . "\nBut was:  " . $this->export($actual);
    }

    /**
     * Determines whether the input is supported by this constraint.
     */
    private function isSupported(mixed $value): bool
    {
        return is_iterable($value);
    }

    /**
     * Converts an iterable (array or Traversable) into a full array
     * while preserving keys.
     *
     * @return array<mixed,mixed>
     */
    private function toArray(mixed $value): array
    {
        if (is_array($value)) {
            return $value;
        }

        if ($value instanceof IteratorAggregate) {
            $value = $value->getIterator();
        }

        if ($value instanceof Traversable) {
            return iterator_to_array($value);
        }

        throw new RuntimeException(
            'HasKeyValuePairs expects array or Traversable, got ' . get_debug_type($value)
        );
    }

    /**
     * Pretty var_export wrapper for readable diffs.
     */
    private function export(mixed $value): string
    {
        return var_export($value, true);
    }
}
