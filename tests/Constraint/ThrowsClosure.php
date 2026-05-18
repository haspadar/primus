<?php

declare(strict_types=1);

namespace Primus\Tests\Constraint;

use PHPUnit\Framework\Constraint\Constraint;
use Throwable;

/**
 * Asserts that invoking a zero-argument callable throws a specific exception
 * type.
 *
 * The historic name keeps `Closure` for compatibility, but the contract
 * accepts any callable (closures, `[$object, 'method']`, invokable objects).
 * Cached diagnostic fields are reset at the start of every evaluation so a
 * reused constraint instance never leaks state from a previous match.
 *
 * Example:
 * self::assertThat(
 *     fn () => $iterator->current(),
 *     new ThrowsClosure(\RuntimeException::class)
 * );
 *
 */
final class ThrowsClosure extends Constraint
{
    /** @var ?Throwable The caught exception, if any */
    private ?Throwable $caughtException = null;

    /** @var bool Whether an exception was thrown at all */
    private bool $exceptionThrown = false;

    /**
     * @param class-string<Throwable> $expected Expected exception class
     */
    public function __construct(private readonly string $expected)
    {
    }

    public function toString(): string
    {
        return "throws {$this->expected}";
    }

    /**
     * @param callable(): mixed $other
     */
    protected function matches($other): bool
    {
        $this->caughtException = null;
        $this->exceptionThrown = false;
        if (!is_callable($other)) {
            return false;
        }

        try {
            $other();
            return false;
        } catch (Throwable $e) {
            $this->caughtException = $e;
            $this->exceptionThrown = true;

            return is_a($e, $this->expected, true);
        }
    }

    protected function failureDescription($other): string
    {
        return "callable {$this->toString()}";
    }

    protected function additionalFailureDescription($other): string
    {
        if (!$this->exceptionThrown) {
            if ($this->caughtException === null && !is_callable($other)) {
                return "\nExpected: callable\nBut was:  " . get_debug_type($other);
            }
            return "\nExpected exception: {$this->expected}\nBut no exception was thrown.";
        }

        return "\nExpected exception: {$this->expected}\nBut was:            "
            . $this->caughtException::class
            . ': ' . $this->caughtException->getMessage()
            . ': ' . $this->caughtException->getTraceAsString();
    }
}
