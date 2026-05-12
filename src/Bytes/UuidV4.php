<?php

declare(strict_types=1);

namespace Primus\Bytes;

use InvalidArgumentException;
use Override;

/**
 * Raw 16-byte UUID version 4 derived from a Bytes random source.
 *
 * Reads 16 bytes from the source on each value() call, then forces the
 * version (byte 6 high nibble = 0x4) and variant (byte 8 high bits = 0b10)
 * fields per RFC 9562.
 *
 * Compose with {@see HexEncoded} for canonical hexadecimal form.
 *
 * Example:
 *     $hex = new HexEncoded(new UuidV4(new RandomBytes(16)));
 *     $hex->value(); // 32 lowercase hex chars, e.g. "550e8400e29b41d4a716446655440000"
 */
final readonly class UuidV4 implements Bytes
{
    private const int UUID_LENGTH = 16;
    private const int VERSION_BYTE = 6;
    private const int VERSION_MASK = 0x0F;
    private const int VERSION_4 = 0x40;
    private const int VARIANT_BYTE = 8;
    private const int VARIANT_MASK = 0x3F;
    private const int VARIANT_RFC9562 = 0x80;

    /**
     * Ctor.
     *
     * @param Bytes $source Random byte source providing at least 16 bytes.
     */
    public function __construct(private Bytes $source) {}

    #[Override]
    public function value(): string
    {
        $raw = $this->source->value();

        if (strlen($raw) < self::UUID_LENGTH) {
            throw new InvalidArgumentException('UuidV4 source must provide at least 16 bytes');
        }

        $bytes = substr($raw, 0, self::UUID_LENGTH);
        $bytes[self::VERSION_BYTE] = chr((ord($bytes[self::VERSION_BYTE]) & self::VERSION_MASK) | self::VERSION_4);
        $bytes[self::VARIANT_BYTE] = chr(
            (ord($bytes[self::VARIANT_BYTE]) & self::VARIANT_MASK) | self::VARIANT_RFC9562,
        );

        return $bytes;
    }
}
