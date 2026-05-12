<?php

declare(strict_types=1);

namespace Primus\Func;

/**
 * Function of two arguments.
 *
 * @template X
 * @template Y
 * @template Z
 */
interface BiFunc
{
    /**
     * Apply the function to the inputs.
     *
     * @param X $first
     * @param Y $second
     * @return Z
     * @psalm-suppress PossiblyUnusedMethod Public API of the library
     */
    public function apply(mixed $first, mixed $second): mixed;
}
