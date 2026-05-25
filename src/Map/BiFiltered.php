<?php

declare(strict_types=1);

namespace Primus\Map;

use Generator;
use Override;
use Primus\Func\BiFunc;

/**
 * Map of pairs whose key and value match a function.
 *
 * Construction forms:
 *
 * - `new BiFiltered(Map, BiFunc)` — wrap an existing {@see Map} and pair predicate.
 * - `BiFiltered::ofMap(Map, BiFunc)` — named-constructor alias of the primary ctor.
 *
 * Example:
 *     $map = BiFiltered::ofMap(
 *         new MapOf(['adult' => 19, 'minor' => 12]),
 *         new BiFuncOf(fn (string $key, int $value): bool => $key === 'adult' && $value >= 18),
 *     );
 *     foreach ($map as $key => $value) {
 *         echo "$key=$value ";
 *     }
 *     // adult=19
 *
 * @template K of array-key
 * @template V
 * @extends MapEnvelope<K, V>
 */
final readonly class BiFiltered extends MapEnvelope
{
    /**
     * Ctor.
     *
     * @param Map<K, V> $origin The map whose pairs are filtered.
     * @param BiFunc<K, V, bool> $predicate The function that selects pairs.
     */
    public function __construct(Map $origin, private BiFunc $predicate)
    {
        parent::__construct($origin);
    }

    /**
     * Selects pairs of a {@see Map} whose key and value match a predicate.
     *
     * @template L of array-key
     * @template W
     * @param Map<L, W> $map The map whose pairs are filtered.
     * @param BiFunc<L, W, bool> $selector The function that selects pairs.
     * @return self<L, W>
     * @psalm-api
     */
    public static function ofMap(Map $map, BiFunc $selector): self
    {
        return new self($map, $selector);
    }

    #[Override]
    public function value(): array
    {
        $pairs = [];

        foreach ($this->origin->value() as $key => $value) {
            if ($this->predicate->apply($key, $value)) {
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
            if ($this->predicate->apply($key, $value)) {
                yield $key => $value;
            }
        }
    }
}
