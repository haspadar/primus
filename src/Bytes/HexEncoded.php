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
 * Construction forms:
 *
 * - `new HexEncoded(Bytes)` — wrap an existing {@see Bytes} value.
 * - `HexEncoded::of(Bytes)` — named-constructor alias of the primary ctor.
 *
 * Example:
 *     $text = HexEncoded::of(new BytesOf("hi"));
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

    /**
     * Encodes raw {@see Bytes} into a lowercase hexadecimal text.
     *
     * @param Bytes $bytes The bytes to encode.
     * @psalm-api
     */
    public static function of(Bytes $bytes): self
    {
        return new self($bytes);
    }

    #[Override]
    public function value(): string
    {
        return bin2hex($this->origin->value());
    }
}
