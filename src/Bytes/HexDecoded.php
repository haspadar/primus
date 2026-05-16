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
 * Example:
 *     $bytes = new HexDecoded(TextOf::ofString("6869"));
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

    #[Override]
    public function value(): string
    {
        $decoded = @hex2bin($this->origin->value());

        return is_string($decoded)
            ? $decoded
            : throw new InvalidArgumentException('Invalid hexadecimal input');
    }
}
