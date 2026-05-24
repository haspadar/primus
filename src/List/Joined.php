<?php

declare(strict_types=1);

namespace Primus\List;

use Generator;
use Override;

/**
 * List that concatenates several source lists in the order they were passed.
 *
 * Element keys are reindexed as sequential integers starting at zero.
 *
 * Construction forms:
 *
 * - `new Joined(List_, ...)` — wrap the source lists to concatenate.
 * - `Joined::ofLists(List_, ...)` — named-constructor alias of the primary ctor.
 *
 * Example:
 *     $joined = Joined::ofLists(
 *         new ListOf(1, 2),
 *         new ListOf(3, 4, 5),
 *     );
 *     // [1, 2, 3, 4, 5]
 *
 * @template T
 * @implements List_<T>
 */
final readonly class Joined implements List_
{
    /** @var array<array-key, List_<T>> */
    private array $sources;

    /**
     * Ctor.
     *
     * @param List_<T> ...$sources The lists to concatenate.
     */
    public function __construct(List_ ...$sources)
    {
        $this->sources = $sources;
    }

    /**
     * Concatenates several {@see List_} into one in the order they were passed.
     *
     * @template U
     * @param List_<U> ...$parts The lists to concatenate.
     * @return self<U>
     * @psalm-api
     */
    public static function ofLists(List_ ...$parts): self
    {
        return new self(...$parts);
    }

    #[Override]
    public function value(): array
    {
        $items = [];

        foreach ($this->sources as $source) {
            foreach ($source->value() as $item) {
                $items[] = $item;
            }
        }

        return $items;
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
