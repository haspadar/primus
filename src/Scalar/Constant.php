<?php

declare(strict_types=1);

namespace Primus\Scalar;

use Override;

/**
 * Scalar that always returns the same value.
 *
 * Acts as an eager, immutable source of a predefined value.
 * Unlike {@see ScalarOf}, it performs no computation — the value
 * is provided at construction time and never changes.
 *
 * Construction forms:
 *
 * - `new Constant(mixed)` — wrap a value.
 * - `Constant::ofValue(mixed)` — named-constructor alias of the primary ctor.
 *
 * Example:
 *     $scalar = Constant::ofValue(42);
 *     echo $scalar->value(); // 42
 *
 * @template T
 * @implements Scalar<T>
 */
final readonly class Constant implements Scalar
{
    /**
     * Ctor.
     *
     * @param T $value The value returned on each call.
     */
    public function __construct(private mixed $value) {}

    /**
     * Wraps a value as a constant {@see Scalar}.
     *
     * @template U
     * @param U $payload The value returned on each call.
     * @return self<U>
     * @psalm-api
     */
    public static function ofValue(mixed $payload): self
    {
        return new self($payload);
    }

    #[Override]
    public function value()
    {
        return $this->value;
    }
}
