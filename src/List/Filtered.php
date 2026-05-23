<?php

declare(strict_types=1);

namespace Primus\List;

use Generator;
use Override;
use Primus\Func\Func;

/**
 * List of elements that match a predicate.
 *
 * Construction forms:
 *
 * - `new Filtered(List_, Func)` — wrap an existing {@see List_} and predicate.
 * - `Filtered::ofList(List_, Func)` — named-constructor alias of the primary ctor.
 *
 * Example:
 *     $list = Filtered::ofList(
 *         new ListOf(10, 5, 40, 3),
 *         new FuncOf(fn (int $x): bool => $x > 10),
 *     );
 *     foreach ($list as $value) {
 *         echo $value . ' '; // 40
 *     }
 *
 * @template T
 * @extends ListEnvelope<T>
 */
final readonly class Filtered extends ListEnvelope
{
    /**
     * Ctor.
     *
     * @param List_<T> $origin The list whose elements are filtered.
     * @param Func<T, bool> $predicate The predicate that selects elements.
     */
    public function __construct(List_ $origin, private Func $predicate)
    {
        parent::__construct($origin);
    }

    /**
     * Selects elements of a {@see List_} that match a predicate.
     *
     * @template U
     * @param List_<U> $list The list whose elements are filtered.
     * @param Func<U, bool> $selector The predicate that selects elements.
     * @return self<U>
     * @psalm-api
     */
    public static function ofList(List_ $list, Func $selector): self
    {
        return new self($list, $selector);
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
        foreach ($this->origin->value() as $item) {
            if ($this->predicate->apply($item)) {
                yield $item;
            }
        }
    }
}
