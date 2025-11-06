<?php

declare(strict_types=1);

namespace Primus\Tests\Constraint;

use PHPUnit\Framework\Constraint\Constraint;
use Primus\Text\Text;

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
        return $other instanceof Text
            && preg_match($this->pattern, $other->value()) === 1;
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
