<?php

declare(strict_types=1);

namespace Primus\Bytes;

use Override;

/**
 * Raw 32-byte SHA-256 digest of an origin Bytes.
 *
 * Compose with {@see HexEncoded} for the canonical hexadecimal form.
 *
 * Construction forms:
 *
 * - `new Sha256(Bytes)` — wrap an existing {@see Bytes} value.
 * - `Sha256::of(Bytes)` — named-constructor alias of the primary ctor.
 *
 * Example:
 *     $hex = HexEncoded::of(Sha256::of(new BytesOf('hello')));
 *     $hex->value(); // "2cf24dba5fb0a30e26e83b2ac5b9e29e1b161e5c1fa7425e73043362938b9824"
 */
final readonly class Sha256 implements Bytes
{
    /**
     * Ctor.
     *
     * @param Bytes $origin The bytes to hash.
     */
    public function __construct(private Bytes $origin) {}

    /**
     * Computes the raw SHA-256 digest of the given {@see Bytes}.
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
        return hash('sha256', $this->origin->value(), true);
    }
}
