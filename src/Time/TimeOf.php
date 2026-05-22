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
 * Construction forms:
 *
 * - `new TimeOf(string)` — wrap an existing native datetime string.
 * - `TimeOf::str(string)` — named-constructor alias of the primary ctor.
 *
 * Example:
 *     $t = TimeOf::str('2026-05-12T10:00:00Z');
 *     $t->value(); // DateTimeImmutable @ 2026-05-12 10:00:00 UTC
 */
final readonly class TimeOf implements Time
{
    /**
     * Ctor.
     *
     * @param string $datetime The textual moment in any format accepted by DateTimeImmutable.
     */
    public function __construct(private string $datetime) {}

    /**
     * Wraps a native datetime string as a {@see Time}.
     *
     * @param string $str The textual moment in any format accepted by DateTimeImmutable.
     * @psalm-api
     */
    public static function str(string $str): self
    {
        return new self($str);
    }

    #[Override]
    public function value(): DateTimeImmutable
    {
        return new DateTimeImmutable($this->datetime);
    }
}
