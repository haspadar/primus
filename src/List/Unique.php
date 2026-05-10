<?php

declare(strict_types=1);

namespace Primus\List;

use Generator;
use Override;

/**
 * List with duplicate values removed using strict equality.
 *
 * Only the first occurrence of each distinct value is kept; subsequent
 * occurrences are dropped. Values are compared with `===`, so `0` and
 * `'0'` are treated as different.
 *
 * Example:
 *     $list = new Unique(new ListOf(1, 2, 1, 3, 2));
 *     foreach ($list as $value) {
 *         echo $value;
 *     }
 *     // 123
 *
 * @template T
 * @extends ListEnvelope<T>
 * @since 0.3
 */
final readonly class Unique extends ListEnvelope
{
    /**
     * Ctor.
     *
     * @param List_<T> $origin The list to deduplicate.
     */
    public function __construct(List_ $origin)
    {
        parent::__construct($origin);
    }

    #[Override]
    public function value(): array
    {
        $seen = [];

        foreach ($this->origin->value() as $item) {
            if (!in_array($item, $seen, true)) {
                $seen[] = $item;
            }
        }

        return $seen;
    }

    #[Override]
    public function count(): int
    {
        return count($this->value());
    }

    #[Override]
    public function getIterator(): Generator
    {
        yield from $this->value();
    }
}
