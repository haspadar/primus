<?php

declare(strict_types=1);

namespace Primus\List;

use Generator;
use Override;
use Primus\Func\Func;

/**
 * List of elements that match a predicate.
 *
 * Example:
 *     $list = new Filtered(
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
