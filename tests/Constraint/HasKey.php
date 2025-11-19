<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Tests\Constraint;

use Iterator;
use PHPUnit\Framework\Constraint\Constraint;

/**
 * Asserts that an {@see Iterator} is currently positioned on the
 * expected key. This does not advance or rewind the iterator —
 * it strictly checks the key() of the iterator as-is.
 *
 * Example:
 * $it = new IteratorOf(['a', 'b', 'c']);
 * $it->rewind();
 * $it->next();        // key = 1
 *
 * self::assertThat($it, new HasKey(1));
 *
 * Failure output:
 * Failed asserting that iterator has key 2
 * But key was: 1
 *
 * @since 0.5
 */
final class HasKey extends Constraint
{
    public function __construct(private readonly mixed $expected)
    {
    }

    public function toString(): string
    {
        return 'has key ' . $this->export($this->expected);
    }

    protected function matches($other): bool
    {
        if (!$other instanceof Iterator) {
            return false;
        }

        return $other->key() === $this->expected;
    }

    protected function failureDescription($other): string
    {
        return 'iterator ' . $this->toString();
    }

    protected function additionalFailureDescription($other): string
    {
        if (!$other instanceof Iterator) {
            return "\nBut object of type "
                . get_debug_type($other)
                . ' was given instead of Iterator';
        }

        return "\nBut key was: " . $this->export($other->key());
    }

    /**
     * Formats values consistently for readable diffs.
     */
    private function export(mixed $value): string
    {
        return var_export($value, true);
    }
}
