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
 * Example:
 *     $scalar = new Constant(42);
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

    #[Override]
    public function value()
    {
        return $this->value;
    }
}
