<?php

declare(strict_types=1);

namespace Primus\Func;

/**
 * Function from I to O.
 *
 * @template I
 * @template-covariant O
 */
interface Func
{
    /**
     * Apply the function to the input.
     *
     * @param I $input
     * @return O
     */
    public function apply(mixed $input): mixed;
}
