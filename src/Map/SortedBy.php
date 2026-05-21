<?php

declare(strict_types=1);

namespace Primus\Map;

use Generator;
use Override;
use Primus\Func\BiFunc;

/**
 * Map with pairs ordered by an externally supplied value comparator, keys preserved.
 *
 * The comparator receives two values and returns a negative integer, zero,
 * or a positive integer when the first value should be ordered before, equal
 * to, or after the second value.
 *
 * Example:
 *     $byLength = new SortedBy(
 *         new MapOf(['x' => 'alpha', 'y' => 'pi', 'z' => 'gamma']),
 *         new BiFuncOf(static fn(string $left, string $right): int
 *             => strlen($left) <=> strlen($right)),
 *     );
 *     // ['y' => 'pi', 'x' => 'alpha', 'z' => 'gamma']
 *
 * @template K of array-key
 * @template V
 * @extends MapEnvelope<K, V>
 */
final readonly class SortedBy extends MapEnvelope
{
    /**
     * Ctor.
     *
     * @param Map<K, V> $origin The map to order.
     * @param BiFunc<V, V, int> $comparator The value-pair comparator.
     */
    public function __construct(Map $origin, private BiFunc $comparator)
    {
        parent::__construct($origin);
    }

    #[Override]
    public function value(): array
    {
        $pairs = $this->origin->value();
        $compare = $this->comparator;
        uasort(
            $pairs,
            /**
             * @param V $left
             * @param V $right
             */
            static fn(mixed $left, mixed $right): int => $compare->apply($left, $right),
        );

        return $pairs;
    }

    #[Override]
    public function getIterator(): Generator
    {
        yield from $this->value();
    }
}
