<?php

declare(strict_types=1);

namespace Primus\Text;

use Override;

/**
 * Envelope for {@see Text}, delegating all calls to the origin.
 *
 */
abstract readonly class TextEnvelope implements Text
{
    /**
     * Ctor.
     *
     * @param Text $origin The text to delegate to.
     */
    public function __construct(protected Text $origin)
    {
    }

    #[Override]
    public function value(): string
    {
        return $this->origin->value();
    }
}
