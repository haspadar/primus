<?php

declare(strict_types=1);

namespace Primus\Bytes;

use InvalidArgumentException;
use Override;
use Primus\Text\Text;

/**
 * Raw bytes decoded from hexadecimal Text.
 *
 * Input must contain only hexadecimal characters in pairs; an odd
 * length or any non-hex character rejects access with
 * InvalidArgumentException.
 *
 * Construction forms:
 *
 * - `new HexDecoded(Text)` — wrap an existing {@see Text} value.
 * - `HexDecoded::of(Text)` — named-constructor alias of the primary ctor.
 *
 * Example:
 *     $bytes = HexDecoded::of(TextOf::str("6869"));
 *     $bytes->value(); // "hi"
 */
final readonly class HexDecoded implements Bytes
{
    /**
     * Ctor.
     *
     * @param Text $origin The hexadecimal text to decode.
     */
    public function __construct(private Text $origin) {}

    /**
     * Decodes a hexadecimal {@see Text} into raw bytes.
     *
     * @param Text $text The hexadecimal text to decode.
     * @psalm-api
     */
    public static function of(Text $text): self
    {
        return new self($text);
    }

    #[Override]
    public function value(): string
    {
        $decoded = @hex2bin($this->origin->value());

        return is_string($decoded)
            ? $decoded
            : throw new InvalidArgumentException('Invalid hexadecimal input');
    }
}
