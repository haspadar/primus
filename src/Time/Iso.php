<?php

declare(strict_types=1);

namespace Primus\Time;

use Override;
use Primus\Text\Text;

/**
 * ISO-8601 textual representation of a Time.
 *
 * Formatting follows PHP DateTimeImmutable's `c` format (ISO-8601 with
 * timezone offset). The Time is resolved on each value() call.
 *
 * Example:
 *     $iso = new Iso(new TimeOf('2026-05-12T10:00:00Z'));
 *     $iso->value(); // "2026-05-12T10:00:00+00:00"
 */
final readonly class Iso implements Text
{
    /**
     * Ctor.
     *
     * @param Time $origin The time to format.
     */
    public function __construct(private Time $origin) {}

    #[Override]
    public function value(): string
    {
        return $this->origin->value()->format('c');
    }
}
