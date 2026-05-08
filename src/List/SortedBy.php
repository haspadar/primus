<?php

declare(strict_types=1);

namespace Primus\List;

use Generator;
use Override;
use Primus\Func\BiFunc;

/**
 * List with elements ordered by an externally supplied comparator.
 *
 * The comparator receives two items and returns a negative integer, zero,
 * or a positive integer when the first item should be ordered before, equal
 * to, or after the second item.
 *
 * Example:
 *     $byLength = new SortedBy(
 *         new ListOf('alpha', 'pi', 'gamma'),
 *         new BiFuncOf(static fn(string $left, string $right): int
 *             => strlen($left) <=> strlen($right)),
 *     );
 *     // ['pi', 'alpha', 'gamma']
 *
 * @template T
 * @extends ListEnvelope<T>
 * @since 0.3
 */
final readonly class SortedBy extends ListEnvelope
{
    /**
     * Ctor.
     *
     * @param List_<T> $origin The list to order.
     * @param BiFunc<T, T, int> $comparator The pairwise comparator.
     */
    public function __construct(List_ $origin, private BiFunc $comparator)
    {
        parent::__construct($origin);
    }

    #[Override]
    public function value(): array
    {
        $items = $this->origin->value();
        $compare = $this->comparator;
        usort(
            $items,
            /**
             * @param T $left
             * @param T $right
             */
            static fn(mixed $left, mixed $right): int => $compare->apply($left, $right),
        );

        return $items;
    }

    #[Override]
    public function getIterator(): Generator
    {
        yield from $this->value();
    }
}
