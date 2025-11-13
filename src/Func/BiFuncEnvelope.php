<?php

declare(strict_types=1);

namespace Primus\Func;

/**
 * Envelope for {@see BiFunc}.
 *
 * @template X
 * @template Y
 * @template Z
 * @implements BiFunc<X, Y, Z>
 * @since 0.3
 */
abstract readonly class BiFuncEnvelope implements BiFunc
{
    /**
     * @param BiFunc<X, Y, Z> $origin
     */
    public function __construct(private BiFunc $origin)
    {
    }

    #[\Override]
    public function apply(mixed $first, mixed $second): mixed
    {
        return $this->origin->apply($first, $second);
    }
}
