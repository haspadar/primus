<?php

declare(strict_types=1);

namespace Primus\Map;

use Generator;
use Override;
use Primus\Func\Func;

/**
 * Map of pairs whose values match a predicate.
 *
 * Construction forms:
 *
 * - `new Filtered(Map, Func)` — wrap an existing {@see Map} and value predicate.
 * - `Filtered::ofMap(Map, Func)` — named-constructor alias of the primary ctor.
 *
 * Example:
 *     $map = Filtered::ofMap(
 *         new MapOf(['a' => 10, 'b' => 5, 'c' => 40]),
 *         new FuncOf(fn (int $v): bool => $v > 10),
 *     );
 *     foreach ($map as $key => $value) {
 *         echo "$key=$value ";
 *     }
 *     // c=40
 *
 * @template K of array-key
 * @template V
 * @extends MapEnvelope<K, V>
 */
final readonly class Filtered extends MapEnvelope
{
    /**
     * Ctor.
     *
     * @param Map<K, V> $origin The map whose pairs are filtered.
     * @param Func<V, bool> $predicate The predicate that selects values.
     */
    public function __construct(Map $origin, private Func $predicate)
    {
        parent::__construct($origin);
    }

    /**
     * Selects pairs of a {@see Map} whose values match a predicate.
     *
     * @template L of array-key
     * @template W
     * @param Map<L, W> $map The map whose pairs are filtered.
     * @param Func<W, bool> $selector The predicate that selects values.
     * @return self<L, W>
     * @psalm-api
     */
    public static function ofMap(Map $map, Func $selector): self
    {
        return new self($map, $selector);
    }

    #[Override]
    public function value(): array
    {
        $pairs = [];

        foreach ($this->origin->value() as $key => $value) {
            if ($this->predicate->apply($value)) {
                $pairs[$key] = $value;
            }
        }

        return $pairs;
    }

    #[Override]
    public function count(): int
    {
        return count($this->value());
    }

    #[Override]
    public function getIterator(): Generator
    {
        foreach ($this->origin->value() as $key => $value) {
            if ($this->predicate->apply($value)) {
                yield $key => $value;
            }
        }
    }
}
