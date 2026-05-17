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
 * Example:
 *     $bytes = new Base64Decoded(TextOf::str("aGVsbG8="));
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

    #[Override]
    public function value(): string
    {
        $decoded = base64_decode($this->origin->value(), true);

        return is_string($decoded)
            ? $decoded
            : throw new InvalidArgumentException('Invalid Base64 input');
    }
}
