<?php

declare(strict_types=1);

namespace Primus\Tests\Constraint;

use PHPUnit\Framework\Constraint\Constraint;

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
        if (!is_iterable($other)) {
            return false;
        }

        $actual = iterator_to_array($other);
        return $actual === $this->expected;
    }

    protected function failureDescription($other): string
    {
        return 'iterator ' . $this->toString();
    }

    protected function additionalFailureDescription($other): string
    {
        $actual = is_iterable($other) ? iterator_to_array($other) : get_debug_type($other);

        return "\nExpected: " . $this->export($this->expected)
            . "\nBut was:  " . $this->export($actual);
    }

    private function export(mixed $value): string
    {
        return var_export($value, true);
    }
}
