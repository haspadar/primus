<?php

declare(strict_types=1);

namespace Primus\List;

use Generator;
use Override;

/**
 * List of given values.
 *
 * Example:
 *     $list = new ListOf(1, 2, 3);
 *     echo count($list); // 3
 *
 * @template T
 * @implements List_<T>
 */
final readonly class ListOf implements List_
{
    /** @var array<array-key, T> */
    private array $items;

    /**
     * Ctor.
     *
     * @param T ...$items The values to wrap.
     */
    public function __construct(mixed ...$items)
    {
        $this->items = $items;
    }

    #[Override]
    public function value(): array
    {
        return $this->items;
    }

    #[Override]
    public function count(): int
    {
        return count($this->items);
    }

    #[Override]
    public function getIterator(): Generator
    {
        yield from $this->items;
    }
}
