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
 * Construction forms:
 *
 * - `new SortedBy(Map, BiFunc)` — wrap an existing {@see Map} and value comparator.
 * - `SortedBy::ofMap(Map, BiFunc)` — named-constructor alias of the primary ctor.
 *
 * Example:
 *     $byLength = SortedBy::ofMap(
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

    /**
     * Sorts pairs of a {@see Map} by an externally supplied value comparator, keys preserved.
     *
     * @template L of array-key
     * @template W
     * @param Map<L, W> $map The map to order.
     * @param BiFunc<W, W, int> $order The value-pair comparator.
     * @return self<L, W>
     * @psalm-api
     */
    public static function ofMap(Map $map, BiFunc $order): self
    {
        return new self($map, $order);
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
