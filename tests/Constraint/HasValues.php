<?php

declare(strict_types=1);

namespace Primus\Tests\Constraint;

use PHPUnit\Framework\Constraint\Constraint;
use Primus\Text\Text;

/**
 * Проверяет, что iterable<Text> имеет ожидаемые значения.
 */
final class HasValues extends Constraint
{
    /**
     * @param string[] $expected
     */
    public function __construct(private array $expected)
    {
    }

    public function toString(): string
    {
        return 'has values ' . json_encode($this->expected, JSON_UNESCAPED_UNICODE);
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
