<?php

declare(strict_types=1);

namespace Primus\Time;

use DateTimeImmutable;
use Override;

/**
 * Time parsed from a textual representation on access.
 *
 * The string is interpreted by PHP's DateTimeImmutable constructor,
 * which accepts ISO-8601, RFC-3339, "now", "tomorrow", and other
 * relative formats. Parsing happens at each value() call.
 *
 * Example:
 *     $t = new TimeOf('2026-05-12T10:00:00Z');
 *     $t->value(); // DateTimeImmutable @ 2026-05-12 10:00:00 UTC
 */
final readonly class TimeOf implements Time
{
    /**
     * Ctor.
     *
     * @param string $iso The textual moment in any format accepted by DateTimeImmutable.
     */
    public function __construct(private string $iso) {}

    #[Override]
    public function value(): DateTimeImmutable
    {
        return new DateTimeImmutable($this->iso);
    }
}
