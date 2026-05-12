<?php

declare(strict_types=1);

namespace Primus\Bytes;

use Override;

/**
 * Cryptographically random bytes of the requested length.
 *
 * Each value() call reads fresh entropy from the system CSPRNG, so two
 * consecutive calls on the same instance return different bytes.
 *
 * Example:
 *     $bytes = new RandomBytes(16);
 *     $bytes->value(); // 16 unpredictable bytes
 */
final readonly class RandomBytes implements Bytes
{
    /**
     * Ctor.
     *
     * @param positive-int $length Number of random bytes to produce.
     */
    public function __construct(private int $length) {}

    #[Override]
    public function value(): string
    {
        return random_bytes($this->length);
    }
}
