<?php

declare(strict_types=1);

namespace Primus\Text;

use Primus\Scalar\Scalar;

/**
 * Text based on a scalar producing a string.
 */
final readonly class TextOfScalar implements Text
{
    /**
     * Ctor.
     *
     * @param Scalar<string> $origin The scalar producing the string value.
     */
    public function __construct(private Scalar $origin)
    {
    }

    #[\Override]
    public function value(): string
    {
        /** @var string */
        return $this->origin->value();
    }
}
