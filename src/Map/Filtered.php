<?php

declare(strict_types=1);

namespace Primus\Map;

use Generator;
use Override;
use Primus\Func\Func;

/**
 * Map of pairs whose values match a predicate.
 *
 * Example:
 *     $map = new Filtered(
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
