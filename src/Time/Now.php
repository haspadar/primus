<?php

declare(strict_types=1);

namespace Primus\Time;

use DateTimeImmutable;
use Override;

/**
 * The moment the value() accessor is called.
 *
 * Each call captures a fresh instant; the object holds no fixed time.
 *
 * Example:
 *     $now = new Now();
 *     $now->value(); // current DateTimeImmutable
 */
final readonly class Now implements Time
{
    #[Override]
    public function value(): DateTimeImmutable
    {
        return new DateTimeImmutable();
    }
}
