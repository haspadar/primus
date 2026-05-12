<?php

declare(strict_types=1);

namespace Primus\Bytes;

use Override;

/**
 * Raw 16-byte MD5 digest of an origin Bytes.
 *
 * Compose with {@see HexEncoded} for the canonical hexadecimal form.
 *
 * Example:
 *     $hex = new HexEncoded(new Md5(new BytesOf('hello')));
 *     $hex->value(); // "5d41402abc4b2a76b9719d911017c592"
 */
final readonly class Md5 implements Bytes
{
    /**
     * Ctor.
     *
     * @param Bytes $origin The bytes to hash.
     */
    public function __construct(private Bytes $origin) {}

    #[Override]
    public function value(): string
    {
        return hash('md5', $this->origin->value(), true);
    }
}
