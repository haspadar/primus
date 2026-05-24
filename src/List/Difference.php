<?php

declare(strict_types=1);

namespace Primus\List;

use Generator;
use Override;

/**
 * List of values from the first origin absent from all other origins.
 *
 * Values are compared with strict equality (`===`), so `0` and `'0'`
 * are treated as different. Order and duplicates of the first origin
 * are preserved for kept values; keys are renumbered from zero.
 *
 * Construction forms:
 *
 * - `new Difference(List_, List_, ...)` — wrap the first list and the excluded lists.
 * - `Difference::ofLists(List_, List_, ...)` — named-constructor alias of the primary ctor.
 *
 * Example:
 *     $list = Difference::ofLists(
 *         new ListOf(1, 2, 3, 4),
 *         new ListOf(2, 4),
 *     );
 *     foreach ($list as $value) {
 *         echo $value;
 *     }
 *     // 13
 *
 * @template T
 * @implements List_<T>
 */
final readonly class Difference implements List_
{
    /** @var array<array-key, List_<T>> */
    private array $excluded;

    /**
     * Ctor.
     *
     * @param List_<T> $first The list to draw values from.
     * @param List_<T> ...$excluded Lists whose values remove matches from the first.
     */
    public function __construct(private List_ $first, List_ ...$excluded)
    {
        $this->excluded = $excluded;
    }

    /**
     * Subtracts values of one or more {@see List_} from the first list.
     *
     * @template U
     * @param List_<U> $source The list to draw values from.
     * @param List_<U> ...$removed Lists whose values remove matches from the source.
     * @return self<U>
     * @psalm-api
     */
    public static function ofLists(List_ $source, List_ ...$removed): self
    {
        return new self($source, ...$removed);
    }

    #[Override]
    public function value(): array
    {
        $forbidden = [];

        foreach ($this->excluded as $source) {
            foreach ($source->value() as $item) {
                $forbidden[] = $item;
            }
        }

        $kept = [];

        foreach ($this->first->value() as $item) {
            if (!in_array($item, $forbidden, true)) {
                $kept[] = $item;
            }
        }

        return $kept;
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
