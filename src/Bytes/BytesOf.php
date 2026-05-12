<?php

declare(strict_types=1);

namespace Primus\Bytes;

use Override;

/**
 * Bytes wrapping a raw binary string.
 *
 * Example:
 *     $b = new BytesOf("hello");
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

    #[Override]
    public function value(): string
    {
        return $this->value;
    }
}
