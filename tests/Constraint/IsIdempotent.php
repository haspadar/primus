<?php

declare(strict_types=1);

namespace Primus\Tests\Constraint;

use Closure;
use PHPUnit\Framework\Constraint\Constraint;

/**
 * Asserts that a zero-argument {@see Closure} returns the expected value on
 * each of two consecutive invocations.
 *
 * Captures the «one-assert-per-test» Angry Tests rule for memoization-style
 * checks where the SUT must produce the same value across repeated calls
 * (caching decorators, Sticky variants, idempotent factories).
 *
 * Comparison is strict identity (`===`). Beware that `NAN === NAN` is
 * `false` and that two distinct value-objects with equal contents compare
 * unequal — supply a Closure that returns the same instance/scalar both
 * times.
 *
 * Example:
 *     self::assertThat(
 *         fn(): int => $sticky->asInt(),
 *         new IsIdempotent(42),
 *     );
 */
final class IsIdempotent extends Constraint
{
    /** @var mixed The value produced by the first invocation. */
    private mixed $first = null;

    /** @var mixed The value produced by the second invocation. */
    private mixed $second = null;

    /** @var bool Whether the Closure was actually invoked (i.e. it had the right type). */
    private bool $invoked = false;

    public function __construct(private readonly mixed $expected) {}

    public function toString(): string
    {
        return sprintf(
            'yields %s on two consecutive invocations',
            $this->exporter()->export($this->expected),
        );
    }

    /**
     * @param Closure(): mixed $other
     */
    protected function matches($other): bool
    {
        if (!$other instanceof Closure) {
            return false;
        }
        $this->first = $other();
        $this->second = $other();
        $this->invoked = true;

        return $this->first === $this->expected && $this->second === $this->expected;
    }

    protected function failureDescription($other): string
    {
        return 'closure ' . $this->toString();
    }

    protected function additionalFailureDescription($other): string
    {
        if (!$this->invoked) {
            return "\nExpected: Closure\nBut was:  " . get_debug_type($other);
        }
        $expectedRepr = $this->exporter()->export($this->expected);
        $firstRepr = $this->exporter()->export($this->first);
        $secondRepr = $this->exporter()->export($this->second);

        return "\nExpected (both calls): $expectedRepr"
            . "\n1st invocation:        $firstRepr"
            . "\n2nd invocation:        $secondRepr";
    }
}
