<?php

declare(strict_types=1);

namespace Primus\Integer;

use Override;
use Primus\Text\Text;
use Primus\Text\TextOf;

/**
 * Integer lifted from a native int.
 *
 * Construction forms:
 *
 * - `new IntegerOf(int)` — wrap an existing native int.
 * - `IntegerOf::int(int)` — named-constructor alias of the primary ctor.
 *
 * Example:
 *     $n = IntegerOf::int(42);
 *     $n->asInt(); // 42
 *     $n->asFloat(); // 42.0
 *     $n->asText()->value(); // "42"
 */
final readonly class IntegerOf implements Integer
{
    /**
     * Ctor.
     *
     * @param int $value The native int to wrap.
     */
    public function __construct(private int $value) {}

    /**
     * Wraps a native int as an {@see Integer}.
     *
     * @param int $int The native int to wrap.
     * @psalm-api
     */
    public static function int(int $int): self
    {
        return new self($int);
    }

    #[Override]
    public function asInt(): int
    {
        return $this->value;
    }

    #[Override]
    public function asFloat(): float
    {
        return (float) $this->value;
    }

    #[Override]
    public function asText(): Text
    {
        return TextOf::str((string) $this->value);
    }
}
