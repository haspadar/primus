<?php

declare(strict_types=1);

namespace Primus\List;

use Generator;
use Override;
use RuntimeException;

/**
 * List that forbids null values.
 *
 * Iteration throws when the source list contains a null element,
 * enforcing a non-null invariant by failing fast.
 *
 * @template T
 * @extends ListEnvelope<T>
 * @since 0.3
 */
final readonly class NoNulls extends ListEnvelope
{
    #[Override]
    public function value(): array
    {
        return iterator_to_array($this->getIterator(), false);
    }

    #[Override]
    public function getIterator(): Generator
    {
        foreach ($this->origin->value() as $value) {
            if ($value === null) {
                throw new RuntimeException('Null value encountered in NoNulls list');
            }

            yield $value;
        }
    }
}
