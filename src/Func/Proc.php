<?php

declare(strict_types=1);

namespace Primus\Func;

/**
 * Procedure from X with no result.
 *
 * @template X
 */
interface Proc
{
    /**
     * Execute the procedure.
     *
     * @param X $input
     * @psalm-suppress PossiblyUnusedMethod Public API of the library
     */
    public function exec(mixed $input): void;
}
