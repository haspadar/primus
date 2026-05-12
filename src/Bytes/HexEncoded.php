<?php

declare(strict_types=1);

namespace Primus\Bytes;

use Override;
use Primus\Text\Text;

/**
 * Lowercase hexadecimal representation of Bytes.
 *
 * Each byte becomes two hex digits; the result has even length.
 *
 * Example:
 *     $text = new HexEncoded(new BytesOf("hi"));
 *     $text->value(); // "6869"
 */
final readonly class HexEncoded implements Text
{
    /**
     * Ctor.
     *
     * @param Bytes $origin The bytes to encode.
     */
    public function __construct(private Bytes $origin) {}

    #[Override]
    public function value(): string
    {
        return bin2hex($this->origin->value());
    }
}
