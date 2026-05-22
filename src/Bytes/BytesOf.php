<?php

declare(strict_types=1);

namespace Primus\Bytes;

use Override;

/**
 * Bytes wrapping a raw binary string.
 *
 * Construction forms:
 *
 * - `new BytesOf(string)` — wrap an existing native string.
 * - `BytesOf::str(string)` — named-constructor alias of the primary ctor.
 *
 * Example:
 *     $b = BytesOf::str("hello");
 *     $b->value(); // "hello"
 */
final readonly class BytesOf implements Bytes
{
    /**
     * Ctor.
     *
     * @param string $value The raw binary byte sequence.
     */
    public function __construct(private string $value) {}

    /**
     * Wraps a raw binary string as a {@see Bytes}.
     *
     * @param string $str The raw binary byte sequence.
     * @psalm-api
     */
    public static function str(string $str): self
    {
        return new self($str);
    }

    #[Override]
    public function value(): string
    {
        return $this->value;
    }
}
