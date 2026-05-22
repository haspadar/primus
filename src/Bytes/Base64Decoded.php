<?php

declare(strict_types=1);

namespace Primus\Bytes;

use InvalidArgumentException;
use Override;
use Primus\Text\Text;

/**
 * Raw bytes decoded from a Base64-encoded Text.
 *
 * Strict decoding is used: any character outside the Base64 alphabet
 * rejects access with InvalidArgumentException.
 *
 * Construction forms:
 *
 * - `new Base64Decoded(Text)` — wrap an existing {@see Text} value.
 * - `Base64Decoded::of(Text)` — named-constructor alias of the primary ctor.
 *
 * Example:
 *     $bytes = Base64Decoded::of(TextOf::str("aGVsbG8="));
 *     $bytes->value(); // "hello"
 */
final readonly class Base64Decoded implements Bytes
{
    /**
     * Ctor.
     *
     * @param Text $origin The Base64 text to decode.
     */
    public function __construct(private Text $origin) {}

    /**
     * Decodes a Base64-encoded {@see Text} into raw bytes.
     *
     * @param Text $text The Base64 text to decode.
     * @psalm-api
     */
    public static function of(Text $text): self
    {
        return new self($text);
    }

    #[Override]
    public function value(): string
    {
        $decoded = base64_decode($this->origin->value(), true);

        return is_string($decoded)
            ? $decoded
            : throw new InvalidArgumentException('Invalid Base64 input');
    }
}
