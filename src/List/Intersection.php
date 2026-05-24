<?php

declare(strict_types=1);

namespace Primus\List;

use Generator;
use Override;

/**
 * List of values from the first origin present in every other origin.
 *
 * Values are compared with strict equality (`===`), so `0` and `'0'`
 * are treated as different. Order and duplicates of the first origin
 * are preserved for kept values; keys are renumbered from zero.
 *
 * Construction forms:
 *
 * - `new Intersection(List_, List_, ...)` — wrap the first list and the others.
 * - `Intersection::ofLists(List_, List_, ...)` — named-constructor alias of the primary ctor.
 *
 * Example:
 *     $list = Intersection::ofLists(
 *         new ListOf(1, 2, 3, 4),
 *         new ListOf(2, 3, 5),
 *     );
 *     foreach ($list as $value) {
 *         echo $value;
 *     }
 *     // 23
 *
 * @template T
 * @implements List_<T>
 */
final readonly class Intersection implements List_
{
    /** @var array<array-key, List_<T>> */
    private array $others;

    /**
     * Ctor.
     *
     * @param List_<T> $first The list to draw values from.
     * @param List_<T> ...$others Lists whose values must contain a strict-equal copy.
     */
    public function __construct(private List_ $first, List_ ...$others)
    {
        $this->others = $others;
    }

    /**
     * Keeps values of the first {@see List_} that exist in every other list.
     *
     * @template U
     * @param List_<U> $source The list to draw values from.
     * @param List_<U> ...$required Lists whose values must contain a strict-equal copy.
     * @return self<U>
     * @psalm-api
     */
    public static function ofLists(List_ $source, List_ ...$required): self
    {
        return new self($source, ...$required);
    }

    #[Override]
    public function value(): array
    {
        $required = array_map(
            static fn(List_ $source): array => $source->value(),
            $this->others,
        );

        $kept = [];

        foreach ($this->first->value() as $item) {
            foreach ($required as $values) {
                if (!in_array($item, $values, true)) {
                    continue 2;
                }
            }

            $kept[] = $item;
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
