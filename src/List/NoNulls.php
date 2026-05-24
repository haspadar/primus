<?php

declare(strict_types=1);

namespace Primus\List;

use Generator;
use Override;
use Primus\RuntimeException;

/**
 * List that forbids null values.
 *
 * Iteration throws when the source list contains a null element,
 * enforcing a non-null invariant by failing fast.
 *
 * Construction forms:
 *
 * - `new NoNulls(List_)` — wrap an existing {@see List_}.
 * - `NoNulls::ofList(List_)` — named-constructor alias of the primary ctor.
 *
 * @template T
 * @extends ListEnvelope<T>
 */
final readonly class NoNulls extends ListEnvelope
{
    /**
     * Forbids null values in a {@see List_}, throwing on iteration when one is found.
     *
     * @template U
     * @param List_<U> $list The list to guard against nulls.
     * @return self<U>
     * @psalm-api
     */
    public static function ofList(List_ $list): self
    {
        return new self($list);
    }

    #[Override]
    public function value(): array
    {
        return iterator_to_array($this->getIterator(), false);
    }

    #[Override]
    public function count(): int
    {
        return count($this->value());
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
