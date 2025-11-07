<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Tests\Constraint;

use InvalidArgumentException;
use PHPUnit\Framework\Constraint\Constraint;
use Primus\Text\Text;

/**
 * Asserts that {@see Text} matches a given regular expression pattern.
 *
 * Example:
 * self::assertThat(
 *     new TextOf('hello'),
 *     new MatchesPattern('/^h.*o$/')
 * );
 *
 * Output on failure:
 * Failed asserting that text matches pattern /^foo$/
 * Expected pattern: /^foo$/
 * But was:          'bar'
 *
 * @since 0.2
 */
final class MatchesPattern extends Constraint
{
    public function __construct(private string $pattern)
    {
    }

    public function toString(): string
    {
        return "matches pattern {$this->pattern}";
    }

    protected function matches($other): bool
    {
        if (!$other instanceof Text) {
            return false;
        }

        $result = preg_match($this->pattern, $other->value());
        if ($result === false || preg_last_error() !== PREG_NO_ERROR) {
            throw new InvalidArgumentException("Invalid regex pattern: {$this->pattern}");
        }

        return $result === 1;
    }

    protected function failureDescription($other): string
    {
        return 'text ' . $this->toString();
    }

    protected function additionalFailureDescription($other): string
    {
        $actual = $other instanceof Text ? $other->value() : get_debug_type($other);

        return "\nExpected pattern: {$this->pattern}\nBut was:          '{$actual}'";
    }
}
