<?php

declare(strict_types=1);

namespace Primus\List;

use Generator;
use Override;

/**
 * List with elements in reverse order.
 *
 * Construction forms:
 *
 * - `new Reversed(List_)` — wrap an existing {@see List_}.
 * - `Reversed::ofList(List_)` — named-constructor alias of the primary ctor.
 *
 * Example:
 *     $list = Reversed::ofList(new ListOf(1, 2, 3));
 *     foreach ($list as $value) {
 *         echo $value;
 *     }
 *     // 321
 *
 * @template T
 * @extends ListEnvelope<T>
 */
final readonly class Reversed extends ListEnvelope
{
    /**
     * Reverses element order of a {@see List_}.
     *
     * @template U
     * @param List_<U> $list The list whose elements are reversed.
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
        return array_reverse($this->origin->value());
    }

    #[Override]
    public function getIterator(): Generator
    {
        yield from $this->value();
    }
}
