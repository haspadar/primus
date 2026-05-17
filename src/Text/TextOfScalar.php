<?php

declare(strict_types=1);

namespace Primus\Text;

use Override;
use Primus\Scalar\Scalar;

/**
 * Text based on a scalar producing a string.
 *
 * @internal Internal delegate of {@see TextOf::scalar()}. Callers should
 *     compose text from a {@see Scalar} through `TextOf::scalar(...)`
 *     instead of instantiating this class directly. Cactoos exposes its
 *     equivalent publicly to support value equality through `equals()`;
 *     Primus does not model Text identity, so a public surface here would
 *     be redundant.
 */
final readonly class TextOfScalar implements Text
{
    /**
     * Ctor.
     *
     * @param Scalar<string> $origin The scalar producing the string value.
     */
    public function __construct(private Scalar $origin) {}

    #[Override]
    public function value(): string
    {
        return $this->origin->value();
    }
}
