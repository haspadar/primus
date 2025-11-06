<?php

declare(strict_types=1);

namespace Primus\Tests\Constraint;

use PHPUnit\Framework\Constraint\Constraint;
use Primus\Text\Text;

final class HasValue extends Constraint
{
    public function __construct(private string $expected)
    {
    }

    public function toString(): string
    {
        return "has text value '{$this->expected}'";
    }

    protected function matches($other): bool
    {
        return $other instanceof Text && $other->value() === $this->expected;
    }

    protected function failureDescription($other): string
    {
        return 'text ' . $this->toString();
    }

    protected function additionalFailureDescription($other): string
    {
        $actual = $other instanceof Text ? $other->value() : get_debug_type($other);

        return "\nExpected: '{$this->expected}'\nBut was:  '{$actual}'";
    }
}
