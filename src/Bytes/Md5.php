<?php

declare(strict_types=1);

namespace Primus\Bytes;

use Override;

/**
 * Raw 16-byte MD5 digest of an origin Bytes.
 *
 * Compose with {@see HexEncoded} for the canonical hexadecimal form.
 *
 * Construction forms:
 *
 * - `new Md5(Bytes)` — wrap an existing {@see Bytes} value.
 * - `Md5::of(Bytes)` — named-constructor alias of the primary ctor.
 *
 * Example:
 *     $hex = HexEncoded::of(Md5::of(new BytesOf('hello')));
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

    /**
     * Computes the raw MD5 digest of the given {@see Bytes}.
     *
     * @param Bytes $bytes The bytes to hash.
     * @psalm-api
     */
    public static function of(Bytes $bytes): self
    {
        return new self($bytes);
    }

    #[Override]
    public function value(): string
    {
        return hash('md5', $this->origin->value(), true);
    }
}
