<?php

declare(strict_types=1);

namespace Primus\List;

use Generator;
use Override;

/**
 * Envelope for {@see List_}, delegating all calls to the origin.
 *
 * @template T
 * @implements List_<T>
 * @since 0.3
 */
abstract readonly class ListEnvelope implements List_
{
    /**
     * Ctor.
     *
     * @param List_<T> $origin The list to delegate to.
     */
    public function __construct(protected List_ $origin) {}

    #[Override]
    public function value(): array
    {
        return $this->origin->value();
    }

    #[Override]
    public function count(): int
    {
        return $this->origin->count();
    }

    #[Override]
    public function getIterator(): Generator
    {
        yield from $this->origin->getIterator();
    }
}
