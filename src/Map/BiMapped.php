<?php

declare(strict_types=1);

namespace Primus\Map;

use Generator;
use Override;
use Primus\Func\BiFunc;

/**
 * Map with each value transformed by a function of key and value while preserving keys.
 *
 * Construction forms:
 *
 * - `new BiMapped(Map, BiFunc)` — wrap an existing {@see Map} and pair mapper.
 * - `BiMapped::ofMap(Map, BiFunc)` — named-constructor alias of the primary ctor.
 *
 * Example:
 *     $map = BiMapped::ofMap(
 *         new MapOf(['a' => 1, 'b' => 2]),
 *         new BiFuncOf(fn (string $key, int $value): string => "$key=$value"),
 *     );
 *     foreach ($map as $key => $value) {
 *         echo "$key:$value ";
 *     }
 *     // a:a=1 b:b=2
 *
 * @template K of array-key
 * @template V
 * @template W
 * @implements Map<K, W>
 */
final readonly class BiMapped implements Map
{
    /**
     * Ctor.
     *
     * @param Map<K, V> $origin The map whose values are transformed.
     * @param BiFunc<K, V, W> $func The transformation function.
     */
    public function __construct(private Map $origin, private BiFunc $func) {}

    /**
     * Transforms each value of a {@see Map} through a key/value {@see BiFunc}, keeping keys.
     *
     * @template L of array-key
     * @template A
     * @template B
     * @param Map<L, A> $map The map whose values are transformed.
     * @param BiFunc<L, A, B> $mapper The transformation function.
     * @return self<L, A, B>
     * @psalm-api
     */
    public static function ofMap(Map $map, BiFunc $mapper): self
    {
        return new self($map, $mapper);
    }

    #[Override]
    public function value(): array
    {
        $pairs = [];

        foreach ($this->origin->value() as $key => $value) {
            $pairs[$key] = $this->func->apply($key, $value);
        }

        return $pairs;
    }

    #[Override]
    public function count(): int
    {
        return $this->origin->count();
    }

    #[Override]
    public function getIterator(): Generator
    {
        foreach ($this->origin->value() as $key => $value) {
            yield $key => $this->func->apply($key, $value);
        }
    }
}
