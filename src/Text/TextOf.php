<?php

declare(strict_types=1);

namespace Primus\Text;

use Override;

/**
 * Text of a plain string.
 */
final readonly class TextOf implements Text
{
    /**
     * Ctor.
     *
     * @param string $value The string to wrap.
     */
    public function __construct(private string $value)
    {
    }

    #[Override]
    public function value(): string
    {
        return $this->value;
    }
}
