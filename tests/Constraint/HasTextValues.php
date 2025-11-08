<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Tests\Constraint;

use PHPUnit\Framework\Constraint\Constraint;
use Primus\Text\Text;

/**
 * Asserts that an iterable of {@see Text} contains the expected string values.
 *
 * Example:
 * self::assertThat(
 *     [new TextOf('a'), new TextOf('b')],
 *     new HasTextValues(['a', 'b'])
 * );
 *
 * Output on failure:
 * Failed asserting that iterable has values ["a","b"]
 * Expected: ["a","b"]
 * But was:  ["a","c"]
 *
 * @since 0.2
 */
final class HasTextValues extends Constraint
{
    /**
     * @param string[] $expected Expected string values.
     */
    public function __construct(private readonly array $expected)
    {
    }

    public function toString(): string
    {
        return 'has text values ' . json_encode($this->expected, JSON_UNESCAPED_UNICODE);
    }

    protected function matches($other): bool
    {
        if (!is_iterable($other)) {
            return false;
        }

        $actual = [];
        foreach ($other as $t) {
            if (!$t instanceof Text) {
                return false;
            }
            $actual[] = $t->value();
        }

        return $actual === $this->expected;
    }

    protected function failureDescription($other): string
    {
        return 'iterable ' . $this->toString();
    }

    protected function additionalFailureDescription($other): string
    {
        $actual = [];
        if (is_iterable($other)) {
            foreach ($other as $t) {
                $actual[] = $t instanceof Text ? $t->value() : get_debug_type($t);
            }
        }

        return "\nExpected: " . json_encode($this->expected, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE)
            . "\nBut was:  " . json_encode($actual, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE);
    }
}
