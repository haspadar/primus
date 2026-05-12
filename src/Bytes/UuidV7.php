<?php

declare(strict_types=1);

namespace Primus\Bytes;

use InvalidArgumentException;
use Override;
use Primus\Time\Time;

/**
 * Raw 16-byte UUID version 7 derived from a Time source and a Bytes random source.
 *
 * Encodes 48 bits of Unix milliseconds (big-endian) in bytes 0-5, then forces
 * the version (byte 6 high nibble = 0x7) and variant (byte 8 high bits = 0b10)
 * fields per RFC 9562. The remaining bits come from the random source.
 *
 * Compose with {@see HexEncoded} for canonical hexadecimal form.
 *
 * Example:
 *     $hex = new HexEncoded(new UuidV7(new Now(), new RandomBytes(10)));
 *     $hex->value(); // 32 lowercase hex chars, first 12 digits encode the timestamp
 */
final readonly class UuidV7 implements Bytes
{
    private const int TIME_BYTES = 6;
    private const int TIME_BYTES_OFFSET = 2;
    private const int RANDOM_BYTES_REQUIRED = 10;
    private const int VERSION_BYTE = 6;
    private const int VERSION_MASK = 0x0F;
    private const int VERSION_7 = 0x70;
    private const int VARIANT_BYTE = 8;
    private const int VARIANT_MASK = 0x3F;
    private const int VARIANT_RFC9562 = 0x80;

    /**
     * Ctor.
     *
     * @param Time $time Time source providing the moment to encode.
     * @param Bytes $random Random byte source providing at least 10 bytes.
     */
    public function __construct(private Time $time, private Bytes $random) {}

    #[Override]
    public function value(): string
    {
        $rand = $this->random->value();

        if (strlen($rand) < self::RANDOM_BYTES_REQUIRED) {
            throw new InvalidArgumentException(
                sprintf('UuidV7 random source must provide at least %d bytes', self::RANDOM_BYTES_REQUIRED),
            );
        }

        $unixMs = (int) $this->time->value()->format('Uv');
        $timeBytes = substr(pack('J', $unixMs), self::TIME_BYTES_OFFSET, self::TIME_BYTES);
        $bytes = $timeBytes . substr($rand, 0, self::RANDOM_BYTES_REQUIRED);
        $bytes[self::VERSION_BYTE] = chr((ord($bytes[self::VERSION_BYTE]) & self::VERSION_MASK) | self::VERSION_7);
        $bytes[self::VARIANT_BYTE] = chr(
            (ord($bytes[self::VARIANT_BYTE]) & self::VARIANT_MASK) | self::VARIANT_RFC9562,
        );

        return $bytes;
    }
}
