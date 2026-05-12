<?php

declare(strict_types=1);

namespace Primus\Time;

use DateTimeImmutable;

/**
 * Represents a moment in time as an immutable PHP DateTimeImmutable.
 */
interface Time
{
    /**
     * Returns the moment this Time represents.
     */
    public function value(): DateTimeImmutable;
}
