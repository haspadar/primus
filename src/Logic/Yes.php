<?php

declare(strict_types=1);

namespace Primus\Logic;

/**
 * Logic that always returns true.
 *
 * Useful in testing or as a default condition.
 *
 * @internal
 */
final readonly class Yes implements Logic
{
    #[\Override]
    public function value(): bool
    {
        return true;
    }
}
