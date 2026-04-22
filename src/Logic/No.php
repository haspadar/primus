<?php

declare(strict_types=1);

namespace Primus\Logic;

/**
 * Logic that always returns false.
 *
 * Useful in testing or as a default negative condition.
 *
 * @internal
 */
final readonly class No implements Logic
{
    #[\Override]
    public function value(): bool
    {
        return false;
    }
}
