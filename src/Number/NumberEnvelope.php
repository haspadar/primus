<?php

declare(strict_types=1);

namespace Primus\Number;

use Override;

/**
 * Envelope for {@see Number}, delegating both accessors to the origin.
 *
 * @since 0.3
 */
abstract readonly class NumberEnvelope implements Number
{
    /**
     * Ctor.
     *
     * @param Number $origin The number to delegate to.
     */
    public function __construct(protected Number $origin) {}

    #[Override]
    public function asInt(): int
    {
        return $this->origin->asInt();
    }

    #[Override]
    public function asFloat(): float
    {
        return $this->origin->asFloat();
    }
}
